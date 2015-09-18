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
 * @package Slackify
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
    ],
    'link_names' => [
        'xtype' => 'combo-boolean',
        'value' => false
    ],
    'unfurl_links' => [
        'xtype' => 'combo-boolean',
        'value' => false
    ],
    'unfurl_media' => [
        'xtype' => 'combo-boolean',
        'value' => true
    ],
    'allow_markdown' => [
        'xtype' => 'combo-boolean',
        'value' => true
    ],
    'markdown_in_attachments' => [
        'xtype' => 'textfield',
        'value' => ''
    ]
];

$settings = [];
foreach ($list as $k => $v) {
    $setting = new modSystemSetting($xpdo);
    $setting->fromArray(array_merge(
        [
            'key' => 'slackify_' . $k,
            'namespace' => 'slackify',
            'editedon' => null,
        ], $v
    ), '', true, true);

    $settings[] = $setting;
}

return $settings;
