<?php

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
