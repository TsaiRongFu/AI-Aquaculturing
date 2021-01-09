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
import itertools
import re

__all__ = ('Filter', 'Source', 'Sink', 'Queue', 'Tee', 'Caps', 'Pad',
           'Size', 'Fraction', 'Format',
           'describe', 'max_inner_size', 'min_outer_size', 'center_inside', 'parse_format')

Fraction = collections.namedtuple('Fraction', ('num', 'den'))
Fraction.__str__ = lambda self: '%s/%s' % (self.num, self.den)

Size = collections.namedtuple('Size', ('width', 'height'))
Size.__mul__ = lambda self, arg: Size(int(arg * self.width), int(arg * self.height))
Size.__rmul__ = lambda self, arg: Size(int(arg * self.width), int(arg * self.height))
Size.__floordiv__ = lambda self, arg: Size(self.width // arg, self.height // arg)
Size.__truediv__ = lambda self, arg: Size(int(self.width / arg), int(self.height / arg))
Size.__str__ = lambda self: '%dx%d' % self

Format = collections.namedtuple('Format', ('device', 'pixel', 'size', 'framerate'))

V4L2_DEVICE = re.compile(r'(?P<dev>[^:]+):(?P<fmt>[^:]+):(?P<w>\d+)x(?P<h>\d+):(?P<num>\d+)/(?P<den>\d+)')

def parse_format(src):
    match = V4L2_DEVICE.search(src)
    if match:
        return Format(device=match.group('dev'),
                      pixel=match.group('fmt'),
                      size=Size(int(match.group('w')), int(match.group('h'))),
                      framerate=Fraction(int(match.group('num')), int(match.group('den'))))
    return None

def max_inner_size(what, where):
    # Example: what=(800, 600) where=(300, 300) => (300, 225)
    return what * min(where.width / what.width, where.height / what.height)

def min_outer_size(what, where):
    # Example: what=(300, 300), where=(800, 600) => (800, 800)
    return what * max(where.width / what.width, where.height / what.height)

def center_inside(inner, outer):
    return int((outer.width - inner.width) / 2), int((outer.height - inner.height) / 2), \
           inner.width, inner.height

def escape(s):
    return s.replace(' ', '\\ ') if isinstance(s, str) else s

def join_params(params, sep=' '):
    return sep.join('%s=%s' % (k.replace('_', '-'), escape(v)) for k, v in params.items())

def join(name, sep, params, param_sep=' '):
    return name if not params else name + sep + join_params(params, param_sep)

class Pad:
    def __init__(self, name, pad=''):
        self.name = name
        self.pad = pad

    def __str__(self):
        return '%s.%s' % (self.name, self.pad)

class Caps:
    def __init__(self, mediatype, **params):
        self.params = params
        self.mediatype = mediatype

    def __str__(self):
        return join(self.mediatype, ',', self.params, ',')

class Element:
    def __init__(self, elementname, params):
        self.elementname = elementname
        self.params = params

    def __getattr__(self, name):
        return self.params[name]

    def __str__(self):
        return join(self.elementname, ' ', self.params)

class Filter(Element):
    def __init__(self, filtername, **params):
        super().__init__(filtername, params)

class Source(Element):
    def __init__(self, sourcename, **params):
        super().__init__(sourcename + 'src', params)

class Sink(Element):
    def __init__(self, sinkname, **params):
        super().__init__(sinkname + 'sink', params)

class Queue(Element):
    def __init__(self, **params):
        super().__init__('queue', params)

class Tee(Element):
    def __init__(self, **params):
        super().__init__('tee', params)

def describe0(arg):
    if isinstance(arg, collections.Sequence):
        return ' ! '.join(describe0(x) for x in arg)
    else:
        return str(arg)

def describe(pipeline):
    return '\n'.join(describe0(x) for x in pipeline)
