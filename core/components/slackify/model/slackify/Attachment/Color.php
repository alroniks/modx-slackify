<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Ivan Klimchuk
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

class Color implements JsonSerializable
{
    /**
     * @var string
     */
    protected $color;

    /**
     * @param $color
     */
    public function __construct($color) {
        if (!preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $color)) {
            throw new InvalidArgumentException('Invalid color format, should be like "#000000"');
        }

        $this->color = $color;
    }

    /**
     * @param Color $that
     * @return bool
     */
    public function equalsTo(Color $that)
    {
        return $this->color === $that->color;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->color;
    }

    public function jsonSerialize()
    {
        return $this->color;
    }
}
