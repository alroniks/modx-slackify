<?php

class Message implements JsonSerializable
{
    protected $text;
    protected $channel;
    protected $username;
    protected $icon = null;
    protected $attachments = [];

    protected $config;

    const ICON_URL = 'icon_url';
    const ICON_EMOJI = 'icon_emoji';

    /**
     * @param $text
     * @param array $config
     */
    public function __construct($text, $config = [])
    {
        $this->text = $text;
        $this->setConfig($config);
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param $channel
     */
    public function setChannel($channel)
    {
        $this->channel = $channel;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param array $config
     */
    protected function setConfig(array $config)
    {
        $allowed = [
            'link_names',
            'unfurl_links',
            'unfurl_media',
            'allow_markdown'
        ];

        foreach ($config as $key => $value) {
            if (in_array($key, $allowed)) {
                $this->config[$key] = (boolean) $value;
            }
        }

        if (isset($config['markdown_in_attachments'])) {
            $this->config['markdown_in_attachments'] = $config['markdown_in_attachments'];
        }
    }

    public function from($username)
    {
        $this->username = $username;

        return $this;
    }

    public function to($channel)
    {
        $this->channel = $channel;

        return $this;
    }

    public function withIcon($icon, $type = self::ICON_URL)
    {
        $this->icon = new stdClass();
        $this->icon->source = $icon;
        $this->icon->type = $type;

        return $this;
    }

    public function attach($attachment)
    {
        $this->attachments[] = $attachment;
    }

    public function allowMarkdown()
    {
        $this->config['allow_markdown'] = true;
    }

    public function disallowMarkdown()
    {
        $this->config['allow_markdown'] = false;
    }

    public function toArray()
    {
        $payload = ['text' => $this->text];

        if ($this->username) {
            $payload['username'] = $this->username;
        }

        if ($this->channel) {
            $payload['channel'] = $this->channel;
        }

        if ($this->icon) {
            $payload[$this->icon->type] = $this->icon->source;
        }

        if ($this->attachments) {
            $payload['attachments'] = $this->attachments;
        }

        if ($this->config) {
            foreach ($this->config as $key => $value) {
                $payload[$key] = $value;
            }
        }

        return $payload;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
