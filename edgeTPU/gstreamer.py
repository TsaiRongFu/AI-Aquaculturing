# Copyright 2019 Google LLC
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     https://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

import collections
import contextlib
import enum
import fcntl
import functools
import os
import pathlib
import queue
import signal
import sys
import termios
import threading
import time

import numpy as np

import gi
gi.require_version('Gtk', '3.0')
gi.require_version('GLib', '2.0')
gi.require_version('GObject', '2.0')
gi.require_version('Gst', '1.0')
gi.require_version('GstBase', '1.0')
gi.require_version('GstGL', '1.0')
gi.require_version('GstPbutils', '1.0')
gi.require_version('GstVideo', '1.0')
from gi.repository import GLib, GObject, Gst, GstBase, GstGL, GstVideo, Gtk

GObject.threads_init()
Gst.init([])
Gtk.init([])

from gi.repository import GstPbutils  # Must be called after Gst.init().

from PIL import Image

from .pipelines import *

COMMAND_SAVE_FRAME = ' '
COMMAND_PRINT_INFO = 'p'
COMMAND_QUIT       = 'q'
WINDOW_TITLE       = 'Coral'

class Display(enum.Enum):
    FULLSCREEN = 'fullscreen'
    WINDOW = 'window'
    NONE = 'none'

    def __str__(self):
        return self.value

@contextlib.contextmanager
def nonblocking(fd):
    os.set_blocking(fd, False)
    try:
        yield
    finally:
        os.set_blocking(fd, True)

@contextlib.contextmanager
def term_raw_mode(fd):
    old = termios.tcgetattr(fd)
    new = termios.tcgetattr(fd)
    new[3] = new[3] & ~(termios.ICANON | termios.ECHO)
    termios.tcsetattr(fd, termios.TCSANOW, new)
    try:
        yield
    finally:
        termios.tcsetattr(fd, termios.TCSAFLUSH, old)

@contextlib.contextmanager
def Commands():
    commands = queue.Queue()

    def on_keypress(fd, flags):
        for ch in sys.stdin.read():
            commands.put(ch)
        return True

    def get_nowait():
        try:
            return commands.get_nowait()
        except queue.Empty:
            return None

    if sys.stdin.isatty():
        fd = sys.stdin.fileno()
        GLib.io_add_watch(fd, GLib.IO_IN, on_keypress)
        with term_raw_mode(fd), nonblocking(fd):
            yield get_nowait
    else:
        yield lambda: None

@contextlib.contextmanager
def Worker(process, maxsize=0):
    commands = queue.Queue(maxsize)

    def run():
        while True:
            args = commands.get()
            if args is None:
                break
            process(*args)
            commands.task_done()

    thread = threading.Thread(target=run)
    thread.start()
    try:
        yield commands
    finally:
        commands.put(None)
        thread.join()

def save_frame(rgb, size, overlay=None, ext='png'):
    tag = '%010d' % int(time.monotonic() * 1000)
    img = Image.frombytes('RGB', size, rgb, 'raw')
    name = 'img-%s.%s' % (tag, ext)
    img.save(name)
    print('Frame saved as "%s"' % name)
    if overlay:
        name = 'img-%s.svg' % tag
        with open(name, 'w') as f:
            f.write(overlay)
        print('Overlay saved as "%s"' % name)

Layout = collections.namedtuple('Layout', ('size', 'window', 'inference_size', 'render_size'))

def make_layout(inference_size, render_size):
    inference_size = Size(*inference_size)
    render_size = Size(*render_size)
    size = min_outer_size(inference_size, render_size)
    window = center_inside(render_size, size)
    return Layout(size=size, window=window,
                  inference_size=inference_size, render_size=render_size)

def caps_size(caps):
    structure = caps.get_structure(0)
    return Size(structure.get_value('width'),
                structure.get_value('height'))

def get_video_info(filename):
    uri = pathlib.Path(filename).absolute().as_uri()
    discoverer = GstPbutils.Discoverer()
    info = discoverer.discover_uri(uri)

    streams = info.get_video_streams()
    assert len(streams) == 1
    return streams[0]

def get_seek_element(pipeline):
    element = pipeline.get_by_name('glsink')
    if not element:
        element = pipeline
    query = Gst.Query.new_seeking(Gst.Format.TIME)
    if element.query(query):
        _,  seekable, _, _ = query.parse_seeking()
        return element
    return None

@contextlib.contextmanager
def pull_sample(sink):
    sample = sink.emit('pull-sample')
    buf = sample.get_buffer()

    result, mapinfo = buf.map(Gst.MapFlags.READ)
    if result:
        yield sample, mapinfo.data
    buf.unmap(mapinfo)

def new_sample_callback(process):
    def callback(sink, pipeline):
        with pull_sample(sink) as (sample, data):
            process(data, caps_size(sample.get_caps()))
        return Gst.FlowReturn.OK
    return callback

def on_bus_message(bus, message, pipeline, loop):
    if message.type == Gst.MessageType.EOS:
        seek_element = get_seek_element(pipeline)
        if loop and seek_element:
            flags = Gst.SeekFlags.FLUSH | Gst.SeekFlags.KEY_UNIT
            if not seek_element.seek_simple(Gst.Format.TIME, flags, 0):
                Gtk.main_quit()
        else:
            Gtk.main_quit()
    elif message.type == Gst.MessageType.WARNING:
        err, debug = message.parse_warning()
        sys.stderr.write('Warning: %s: %s\n' % (err, debug))
    elif message.type == Gst.MessageType.ERROR:
        err, debug = message.parse_error()
        sys.stderr.write('Error: %s: %s\n' % (err, debug))
        Gtk.main_quit()

def on_sink_eos(sink, pipeline):
    overlay = pipeline.get_by_name('overlay')
    if overlay:
        overlay.set_eos()

def on_new_sample(sink, pipeline, render_overlay, layout, images, get_command):
    with pull_sample(sink) as (sample, data):
        custom_command = None
        save_frame = False

        command = get_command()
        if command == COMMAND_SAVE_FRAME:
            save_frame = True
        elif command == COMMAND_PRINT_INFO:
            print('Timestamp: %.2f' % time.monotonic())
            print('Render size: %d x %d' % layout.render_size)
            print('Inference size: %d x %d' % layout.inference_size)
        elif  command == COMMAND_QUIT:
            Gtk.main_quit()
        else:
            custom_command = command

        svg = render_overlay(np.frombuffer(data, dtype=np.uint8),
                             command=custom_command)
        glsink = pipeline.get_by_name('glsink')
        if glsink:
            glsink.set_property('svg', svg)

        if save_frame:
            images.put((data, layout.inference_size, svg))

    return Gst.FlowReturn.OK

def run_gen(render_overlay_gen, *, source, loop, display):
    inference_size = render_overlay_gen.send(None)  # Initialize.
    next(render_overlay_gen)
    return run(inference_size,
        lambda tensor, layout, command:
            render_overlay_gen.send((tensor, layout, command)),
        source=source,
        loop=loop,
        display=display)

def run(inference_size, render_overlay, *, source, loop, display):
    result = get_pipeline(source, inference_size, display)
    if result:
        layout, pipeline = result
        run_pipeline(pipeline, layout, loop, render_overlay, display)
        return True

    return False

def get_pipeline(source, inference_size, display):
    fmt = parse_format(source)
    if fmt:
        layout = make_layout(inference_size, fmt.size)
        return layout, camera_pipeline(fmt, layout, display)

    filename = os.path.expanduser(source)
    if os.path.isfile(filename):
        info = get_video_info(filename)
        render_size = Size(info.get_width(), info.get_height())
        layout = make_layout(inference_size, render_size)
        return layout, file_pipline(info.is_image(), filename, layout, display)

    return None

def camera_pipeline(fmt, layout, display):
    if display is Display.NONE:
        return camera_headless_pipeline(fmt, layout)
    else:
        return camera_display_pipeline(fmt, layout)

def file_pipline(is_image, filename, layout, display):
    if display is Display.NONE:
        if is_image:
            return image_headless_pipeline(filename, layout)
        else:
            return video_headless_pipeline(filename, layout)
    else:
        fullscreen = display is Display.FULLSCREEN
        if is_image:
            return image_display_pipeline(filename, layout)
        else:
            return video_display_pipeline(filename, layout)

def quit():
    Gtk.main_quit()

def run_pipeline(pipeline, layout, loop, render_overlay, display, handle_sigint=True, signals=None):
    # Create pipeline
    pipeline = describe(pipeline)
    print(pipeline)
    pipeline = Gst.parse_launch(pipeline)

    # Set up a pipeline bus watch to catch errors.
    bus = pipeline.get_bus()
    bus.add_signal_watch()
    bus.connect('message', on_bus_message, pipeline, loop)

    if display is not Display.NONE:
        # Needed to commit the wayland sub-surface.
        def on_gl_draw(sink, widget):
            widget.queue_draw()

        # Needed to account for window chrome etc.
        def on_widget_configure(widget, event, glsink):
            allocation = widget.get_allocation()
            glsink.set_render_rectangle(allocation.x, allocation.y,
                    allocation.width, allocation.height)
            return False

        window = Gtk.Window(Gtk.WindowType.TOPLEVEL)
        window.set_title(WINDOW_TITLE)
        window.set_default_size(layout.render_size.width, layout.render_size.height)
        if display is Display.FULLSCREEN:
            window.fullscreen()

        drawing_area = Gtk.DrawingArea()
        window.add(drawing_area)
        drawing_area.realize()

        glsink = pipeline.get_by_name('glsink')
        glsink.connect('drawn', on_gl_draw, drawing_area)

        # Wayland window handle.
        wl_handle = glsink.get_wayland_window_handle(drawing_area)
        glsink.set_window_handle(wl_handle)

        # Wayland display context wrapped as a GStreamer context.
        wl_display = glsink.get_default_wayland_display_context()
        glsink.set_context(wl_display)

        drawing_area.connect('configure-event', on_widget_configure, glsink)
        window.connect('delete-event', Gtk.main_quit)
        window.show_all()

        # The appsink pipeline branch must use the same GL display as the screen
        # rendering so they get the same GL context. This isn't automatically handled
        # by GStreamer as we're the ones setting an external display handle.
        def on_bus_message_sync(bus, message, glsink):
            if message.type == Gst.MessageType.NEED_CONTEXT:
                _, context_type = message.parse_context_type()
                if context_type == GstGL.GL_DISPLAY_CONTEXT_TYPE:
                    sinkelement = glsink.get_by_interface(GstVideo.VideoOverlay)
                    gl_context = sinkelement.get_property('context')
                    if gl_context:
                        display_context = Gst.Context.new(GstGL.GL_DISPLAY_CONTEXT_TYPE, True)
                        GstGL.context_set_gl_display(display_context, gl_context.get_display())
                        message.src.set_context(display_context)
            return Gst.BusSyncReply.PASS

        bus.set_sync_handler(on_bus_message_sync, glsink)

    with Worker(save_frame) as images, Commands() as get_command:
        signals = {'appsink':
            {'new-sample': functools.partial(on_new_sample,
                render_overlay=functools.partial(render_overlay, layout=layout),
                layout=layout,
                images=images,
                get_command=get_command),
             'eos' : on_sink_eos},
            **(signals or {})
        }

        for name, signals in signals.items():
            component = pipeline.get_by_name(name)
            if component:
                for signal_name, signal_handler in signals.items():
                    component.connect(signal_name, signal_handler, pipeline)

        # Handle signals.
        if handle_sigint:
            GLib.unix_signal_add(GLib.PRIORITY_DEFAULT, signal.SIGINT, Gtk.main_quit)

        # Run pipeline.
        pipeline.set_state(Gst.State.PLAYING)
        try:
            Gtk.main()
        except KeyboardInterrupt:
            pass
        finally:
            pipeline.set_state(Gst.State.NULL)

        # Process all pending MainContext operations.
        while GLib.MainContext.default().iteration(False):
            pass
