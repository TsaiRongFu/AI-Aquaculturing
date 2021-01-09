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

from .gst import *

def decoded_file_src(filename):
    return [
        Source('file', location=filename),
        Filter('decodebin'),
    ]

def v4l2_src(fmt):
    return [
        Source('v4l2', device=fmt.device),
        Caps('video/x-raw', format=fmt.pixel, width=fmt.size.width, height=fmt.size.height,
             framerate='%d/%d' % fmt.framerate),
    ]

def display_sink():
    return Sink('glsvgoverlay', name='glsink'),

def h264_sink():
    return Sink('app', name='h264sink', emit_signals=True, max_buffers=1, drop=False, sync=False)

def inference_pipeline(layout, stillimage=False):
    size = max_inner_size(layout.render_size, layout.inference_size)
    return [
        Filter('glfilterbin', filter='glbox'),
        Caps('video/x-raw', format='RGB', width=layout.inference_size.width, height=layout.inference_size.height),
        Sink('app', name='appsink', emit_signals=True, max_buffers=1, drop=True, sync=False),
    ]

# Display
def image_display_pipeline(filename, layout):
    return (
        [decoded_file_src(filename),
         Filter('imagefreeze'),
         Caps('video/x-raw', framerate='30/1'),
         Filter('glupload'),
         Tee(name='t')],
        [Pad('t'),
         Queue(),
         display_sink()],
        [Pad('t'),
         Queue(max_size_buffers=1, leaky='downstream'),
         inference_pipeline(layout)],
    )


def video_display_pipeline(filename, layout):
    return (
        [decoded_file_src(filename),
         Filter('glupload'),
         Tee(name='t')],
        [Pad('t'),
         Queue(),
         display_sink()],
        [Pad('t'),
         Queue(max_size_buffers=1, leaky='downstream'),
         inference_pipeline(layout)],
    )

def camera_display_pipeline(fmt, layout):
    return (
        [v4l2_src(fmt),
         Filter('glupload'),
         Tee(name='t')],
        [Pad('t'),
         Queue(),
         display_sink()],
        [Pad(name='t'),
         Queue(max_size_buffers=1, leaky='downstream'),
         inference_pipeline(layout)],
    )

# Headless
def image_headless_pipeline(filename, layout):
    return (
      [decoded_file_src(filename),
       Filter('imagefreeze'),
       Filter('glupload'),
       inference_pipeline(layout)],
    )

def video_headless_pipeline(filename, layout):
    return (
        [decoded_file_src(filename),
         Filter('glupload'),
         inference_pipeline(layout)],
    )

def camera_headless_pipeline(fmt, layout):
    return (
        [v4l2_src(fmt),
         Filter('glupload'),
         inference_pipeline(layout)],
    )

# Streaming
def video_streaming_pipeline(filename, layout):
    return (
        [Source('file', location=filename),
         Filter('qtdemux'),
         Tee(name='t')],
        [Pad('t'),
         Queue(max_size_buffers=1),
         Filter('h264parse'),
         Caps('video/x-h264', stream_format='byte-stream', alignment='nal'),
         h264_sink()],
        [Pad('t'),
         Queue(max_size_buffers=1),
         Filter('decodebin'),
         inference_pipeline(layout)],
    )

def camera_streaming_pipeline(fmt, profile, bitrate, layout):
    return (
        [v4l2_src(fmt), Tee(name='t')],
        [Pad('t'),
         Queue(max_size_buffers=1, leaky='downstream'),
         Filter('videoconvert'),
         Filter('x264enc',
                 speed_preset='ultrafast',
                 tune='zerolatency',
                 threads=4,
                 key_int_max=5,
                 bitrate=int(bitrate / 1000),  # kbit per second.
                 aud=False),
          Caps('video/x-h264', profile=profile),
          Filter('h264parse'),
          Caps('video/x-h264', stream_format='byte-stream', alignment='nal'),
          h264_sink()],
        [Pad('t'),
         Queue(),
         inference_pipeline(layout)],
    )
