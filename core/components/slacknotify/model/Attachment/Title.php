<?php

class Title
{
    protected $title;
    protected $link;

    /**
     * @param $title
     * @param string $link
     */
    public function __construct($title, $link = '')
    {
        $this->title = $title;
        $this->link = $link;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $payload = ['title' => $this->title];

        if ($this->link) {
            $payload['title_link'] = $this->link;
        }

        return $payload;
    }
}
