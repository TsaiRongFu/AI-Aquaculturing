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

from collections import Sequence

def _clean(k):
    k = k[1:] if k.startswith('_') else k
    return k.replace('_', '-')

def rgb(color):
    return 'rgb(%s, %s, %s)' % color

class Style:
    def __init__(self, **attrs):
        self._attrs = attrs

    def __str__(self):
        return ';'.join('%s:%s' % (_clean(k), v) for k, v in self._attrs.items())

class Tag:
    NAME = None
    REQUIRED_ATTRS = ()

    def __init__(self, **attrs):
        self._attrs = attrs

        for attr in self.REQUIRED_ATTRS:
            if attr not in attrs:
                raise ValueError('Missing attribute "%s" from tag <%s/>' % (attr, self.NAME))

    @property
    def value(self):
        return None

    def __str__(self):
        sattrs = ' '.join('%s="%s"' % (_clean(k), v) for k, v in self._attrs.items())
        if sattrs:
            sattrs = ' ' + sattrs
        value = self.value
        if value is None:
            return '<%s%s/>' % (self.NAME, sattrs)
        return '<%s%s>%s</%s>' % (self.NAME, sattrs, value, self.NAME)

class TagContainer(Tag):
    def __init__(self, **attrs):
        super().__init__(**attrs)
        self._children = []

    def add(self, one_or_more):
        try:
            self._children.extend(one_or_more)
        except TypeError:
            self._children.append(one_or_more)

        return self

    def __iadd__(self, child):
        self.add(child)
        return self

    @property
    def value(self):
        return ''.join(str(child) for child in self._children)

class Svg(TagContainer):
    NAME = 'svg'

    def __init__(self, **attrs):
        super().__init__(**{'xmlns':'http://www.w3.org/2000/svg', **attrs})

class Group(TagContainer):
    NAME = 'g'

class Line(Tag):
    NAME = 'line'
    REQUIRED_ATTRS = ('x1', 'y1', 'x2', 'y2')

class Rect(Tag):
    NAME = 'rect'
    REQUIRED_ATTRS = ('x', 'y', 'width', 'height')

class Circle(Tag):
    NAME = 'circle'
    REQUIRED_ATTRS = ('cx', 'cy', 'r')

class Ellipse(Tag):
    NAME = 'ellipse'
    REQUIRED_ATTRS = ('cx', 'cy', 'rx', 'ry')

class Text(TagContainer):
    NAME = 'text'

    def __init__(self, text=None, **attrs):
        super().__init__(**attrs)
        self._text = text

    @property
    def value(self):
        if self._text:
            return self._text
        return super().value

class TSpan(Tag):
    NAME = 'tspan'

    def __init__(self, text, **attrs):
        super().__init__(**attrs)
        self._text = text

    @property
    def value(self):
        return self._text

class Path(Tag):
    NAME = 'path'
    REQUIRED_ATTRS = ('d',)

class Defs(TagContainer):
    NAME = 'defs'

class CssStyle(Tag):
    NAME = 'style'

    def __init__(self, styles):
        super().__init__(**{'_type': 'text/css'})
        self._styles = styles

    @property
    def value(self):
        return '<![CDATA[%s]]>' % '\n'.join('%s {%s}' % (k, v) for k, v in self._styles.items())
