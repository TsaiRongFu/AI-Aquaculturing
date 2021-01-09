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

"""A demo which runs object classification on camera frames.

export TEST_DATA=/usr/lib/python3/dist-packages/edgetpu/test_data

python3 -m edgetpuvision.classify \
  --model ${TEST_DATA}/mobilenet_v2_1.0_224_inat_bird_quant.tflite \
  --labels ${TEST_DATA}/inat_bird_labels.txt
"""
import argparse
import collections
import itertools
import time

from edgetpu.classification.engine import ClassificationEngine

from . import svg
from . import utils
from .apps import run_app


CSS_STYLES = str(svg.CssStyle({'.back': svg.Style(fill='black',
                                                  stroke='black',
                                                  stroke_width='0.5em')}))

def size_em(length):
    return '%sem' % str(0.6 * (length + 1))

def overlay(title, results, inference_time, inference_rate, layout):
    x0, y0, width, height = layout.window
    font_size = 0.03 * height

    defs = svg.Defs()
    defs += CSS_STYLES

    doc = svg.Svg(width=width, height=height,
                  viewBox='%s %s %s %s' % layout.window,
                  font_size=font_size, font_family='monospace', font_weight=500)
    doc += defs

    ox1, ox2 = x0 + 20, x0 + width - 20
    oy1, oy2 = y0 + 20 + font_size, y0 + height - 20

    # Classes
    lines = ['%s (%.2f)' % pair for pair in results]
    for i, line in enumerate(lines):
        y = oy2 - i * 1.7 * font_size

        doc += svg.Rect(x=0, y=0, width=size_em(len(line)), height='1em',
                        transform='translate(%s, %s) scale(-1,-1)' % (ox2, y),
                        _class='back')

        doc += svg.Text(line, text_anchor='end', x=ox2, y=y, fill='white')

    # Title
    if title:
        doc += svg.Rect(x=0, y=0, width=size_em(len(title)), height='1em',
                        transform='translate(%s, %s) scale(1,-1)' % (ox1, oy1), _class='back')
        doc += svg.Text(title, x=ox1, y=oy1, fill='white')

    # Info
    lines = [
        'Inference time: %.2f ms (%.2f fps)' % (inference_time * 1000, 1.0 / inference_time)
    ]

    for i, line in enumerate(reversed(lines)):
        y = oy2 - i * 1.7 * font_size
        doc += svg.Rect(x=0, y=0, width=size_em(len(line)), height='1em',
                       transform='translate(%s, %s) scale(1,-1)' % (ox1, y), _class='back')
        doc += svg.Text(line, x=ox1, y=y, fill='white')

    return str(doc)

def top_results(window, top_k):
    total_scores = collections.defaultdict(lambda: 0.0)
    for results in window:
        for label, score in results:
            total_scores[label] += score
    return sorted(total_scores.items(), key=lambda kv: kv[1], reverse=True)[:top_k]

def accumulator(size, top_k):
    window = collections.deque(maxlen=size)
    window.append((yield []))
    while True:
        window.append((yield top_results(window, top_k)))

def print_results(inference_rate, results):
    print('\nInference (rate=%.2f fps):' % inference_rate)
    print(results)
    for label, score in results:
        print('  %s, score=%.2f' % (label, score))

def render_gen(args):
    acc = accumulator(size=args.window, top_k=args.top_k)
    acc.send(None)  # Initialize.

    fps_counter = utils.avg_fps_counter(30)

    engines, titles = utils.make_engines(args.model, ClassificationEngine)
    assert utils.same_input_image_sizes(engines)
    engines = itertools.cycle(engines)
    engine = next(engines)

    labels = utils.load_labels(args.labels)
    draw_overlay = True

    yield utils.input_image_size(engine)

    output = None
    while True:
        tensor, layout, command = (yield output)

        inference_rate = next(fps_counter)
        if draw_overlay:
            start = time.monotonic()
            results = engine.classify_with_input_tensor(tensor, threshold=args.threshold, top_k=args.top_k)
            inference_time = time.monotonic() - start

            results = [(labels[i], score) for i, score in results]
            results = acc.send(results)
            if args.print:
                print_results(inference_rate, results)

            title = titles[engine]
            output = overlay(title, results, inference_time, inference_rate, layout)
        else:
            output = None

        if command == 'o':
            draw_overlay = not draw_overlay
        elif command == 'n':
            engine = next(engines)

def add_render_gen_args(parser):
    parser.add_argument('--model', required=True,
                        help='.tflite model path')
    parser.add_argument('--labels', required=True,
                        help='label file path')
    parser.add_argument('--window', type=int, default=10,
                        help='number of frames to accumulate inference results')
    parser.add_argument('--top_k', type=int, default=3,
                        help='number of classes with highest score to display')
    parser.add_argument('--threshold', type=float, default=0.1,
                        help='class score threshold')
    parser.add_argument('--print', default=False, action='store_true',
                        help='Print inference results')

def main():
    run_app(add_render_gen_args, render_gen)

if __name__ == '__main__':
    main()
