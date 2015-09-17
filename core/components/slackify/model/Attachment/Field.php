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

class Field implements JsonSerializable
{
    protected $title;
    protected $value;
    protected $short;

    /**
     * @param $title
     * @param $value
     * @param bool|false $short
     */
    public function __construct($title, $value, $short = false)
    {
        $this->title = $title;
        $this->value = $value;
        $this->short = $short;
    }

    /**
     * @param Field $that
     * @return bool
     */
    public function equalsTo(Field $that)
    {
        return $this->title === $that->title
            && $this->value === $that->value
            && $this->short === $that->short;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
            'short' => (boolean) $this->short
        ];
    }
}
