<?php

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
