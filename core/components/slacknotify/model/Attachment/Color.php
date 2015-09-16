<?php

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
