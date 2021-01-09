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
import os
import re
import time

LABEL_PATTERN = re.compile(r'\s*(\d+)(.+)')

def load_labels(path):
    with open(path, 'r', encoding='utf-8') as f:
       lines = (LABEL_PATTERN.match(line).groups() for line in f.readlines())
       return {int(num): text.strip() for num, text in lines}


def input_image_size(engine):
    _, h, w, _ = engine.get_input_tensor_shape()
    return w, h

def same_input_image_sizes(engines):
    return len({input_image_size(engine) for engine in engines}) == 1

def avg_fps_counter(window_size):
    window = collections.deque(maxlen=window_size)
    prev = time.monotonic()
    yield 0.0  # First fps value.

    while True:
        curr = time.monotonic()
        window.append(curr - prev)
        prev = curr
        yield len(window) / sum(window)

def make_engines(models, engine_class):
    engines, titles = [], {}
    for model in models.split(','):
        if '@' in model:
            model_path, title = model.split('@')
        else:
            model_path, title = model, os.path.basename(os.path.normpath(model))
        engine = engine_class(model_path)
        engines.append(engine)
        titles[engine] = title
    return engines, titles
