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

/**
 * System settings for package
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package slackNotify
 * @subpackage build
 */

$list = [
    'entrypoint' => [
        'xtype' => 'textfield',
        'value' => '',
    ],
    'channel' => [
        'xtype' => 'textfield',
        'value' => '#general'
    ],
    'username' => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    'icon' => [
        'xtype' => 'textfield',
        'value' => ''
    ]
];

class modSystemSetting extends xPDOObject {}

$settings = [];
foreach ($list as $k => $v) {
    $setting = new modSystemSetting($xpdo);
    $setting->fromArray(array_merge(
        array(
            'key' => 'slacknotify_' . $k,
            'namespace' => 'slacknotify',
            'editedon' => null,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}

return $settings;


//All settings are optional, but are a convenient way of specifying how the client should behave beyond the defaults.


//link_names: whether names like @regan or #accounting should be linked
//bool
//default: false

//unfurl_links: whether Slack should unfurl text-based URLs
//bool
//default: false

//unfurl_media: whether Slack should unfurl media-based URLs
//bool
//default: true

//allow_markdown: whether Markdown should be parsed in messages
//bool
//default: true

//markdown_in_attachments: which attachment fields should have Markdown parsed
//array
//default: []
