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
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
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
