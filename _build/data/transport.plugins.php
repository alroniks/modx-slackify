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

$plugins = [];

$list = [
    'PageNotFoundSlackify' => [
        'description' => 'This plugin sends message to defined channel in Slack when 404 error occurs on site.',
        'events' => [
            'OnPageNotFound'
        ]
    ]
];

foreach ($list as $k => $v) {
    $plugin = new modPlugin($xpdo);
    $plugin->fromArray([
        'id' => 0,
        'name' => $k,
        'category' => 0,
        'description' => $v['description'],
        'plugincode' => trim(str_replace(['<?php', '?>'], '', file_get_contents($sources['plugins'] . $k . '.php'))),
        'static' => true,
        'static_file' => 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/' . $k . '.php',
        'source' => 1,
        'property_preprocess' => 0,
        'editor_type' => 0,
        'cache_type' => 0
    ], '', true, true);

    if (!empty($v['events'])) {
        foreach ($v['events'] as $e) {
            $event = new modPluginEvent($xpdo);
            $event->fromArray([
                'pluginid' => 0,
                'event' => $e,
                'priority' => 0,
                'propertyset' => 0,
            ], '', true, true);

            $plugin->addOne($event, 'PluginEvents');
        }
        unset($v['events']);
    }

    $plugins[] = $plugin;
}

return $plugins;
