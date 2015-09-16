<?php

class Author implements JsonSerializable
{
    private $name;
    private $link;
    private $icon;

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
        $payload = ['name' => $this->name];

        if ($this->link) {
            $payload['link'] = $this->link;
        }

        if ($this->icon) {
            $payload['icon'] = $this->icon;
        }

        return json_encode($payload);
    }
}
