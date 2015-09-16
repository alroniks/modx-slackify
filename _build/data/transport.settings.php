<?php

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
