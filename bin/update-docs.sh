#!/bin/bash

# The MIT License
#
# Copyright 2017 Nissar Chababy <contact at funilrys dot com>.
#
# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the Software), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
#
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
#
# THE SOFTWARE IS PROVIDED AS IS, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
# THE SOFTWARE.
#


# The following update the documentation.

if [[ -d ${PWD}/Core ]]
then
    rm -fR ${PWD}/docs/*
    /usr/bin/php /usr/bin/phpdoc run --ansi --progressbar --directory . --target ${PWD}/docs --title funombi --ignore ${PWD}/public/vendor/
    git add ${PWD}/docs && git commit -S -m 'Update of the documentation' && git push
else
    echo "Please move to the parent directory."
    exit 1
fi