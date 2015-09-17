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

class Author implements JsonSerializable
{
    protected $name;
    protected $link;
    protected $icon;

    /**
     * @param string $name
     * @param string $link
     * @param string $icon
     */
    public function __construct($name, $link = '', $icon = '')
    {
        $this->name = $name;
        $this->link = $link;
        $this->icon = $icon;
    }

    /**
     * @param Author $that
     * @return bool
     */
    public function equalsTo(Author $that)
    {
        return $this->name === $that->name
            && $this->link === $that->link
            && $this->icon === $that->icon;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $payload = ['author_name' => $this->name];

        if ($this->link) {
            $payload['author_link'] = $this->link;
        }

        if ($this->icon) {
            $payload['author_icon'] = $this->icon;
        }

        return $payload;
    }
}
