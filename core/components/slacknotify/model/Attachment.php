<?php

class Attachment implements JsonSerializable
{
    protected $attributes;

    /**
     * @param $text
     * @param string $pretext
     */
    public function __construct($text, $pretext = '')
    {
        $this->attributes['text'] = (string) $text;

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
