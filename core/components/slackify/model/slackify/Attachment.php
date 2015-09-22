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

class Attachment implements JsonSerializable
{
    protected $attributes;

    /**
     * @param $text
     * @param string $pretext
     */
    public function __construct($text = '', $pretext = '')
    {
        if ($text) {
            $this->attributes['text'] = (string)$text;
        }

        if ($pretext) {
            $this->attributes['pretext'] = (string) $pretext;
        }
    }

    /**
     * @param $text
     */
    public function setText($text)
    {
        $this->attributes['text'] = $text;
    }

    /**
     * @param $pretext
     */
    public function setPretext($pretext)
    {
        $this->attributes['pretext'] = $pretext;
    }

    /**
     * @param $fallback
     */
    public function setFallback($fallback)
    {
        $this->attributes['fallback'] = $fallback;
    }

    /**
     * @param Author $author
     */
    public function setAuthor(Author $author)
    {
        $this->attributes = array_merge($this->attributes, $author->toArray());
    }

    /**
     * @param Title $title
     */
    public function setTitle(Title $title)
    {
        $this->attributes = array_merge($this->attributes, $title->toArray());
    }

    /**
     * @param Color $color
     */
    public function setColor(Color $color)
    {
        $this->attributes['color'] = $color;
    }

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->attributes['fields'][] = $field;
    }

    /**
     * @param $image
     */
    public function setImage($image)
    {
        $this->attributes['image_url'] = $image;
    }

    /**
     * @param $thumb
     */
    public function setThumb($thumb)
    {
        $this->attributes['thumb_url'] = $thumb;
    }

    /**
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->attributes;
    }
}
