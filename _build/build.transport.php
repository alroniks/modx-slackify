<?php
/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2015 Ivan Klimchuk <ivan@klimchuk.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * slackNotify package builder
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package slackNotify
 * @subpackage build
 */

set_time_limit(0);

ini_set('date.timezone', 'Europe/Minsk');

define('PKG_NAME', 'slackNotify');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
define('PKG_VERSION', '0.1.0');
define('PKG_RELEASE', 'alpha');

//define('BUILD_SETTING_UPDATE', true);

require_once 'xpdo/xpdo/xpdo.class.php';
require_once 'xpdo/xpdo/transport/xpdotransport.class.php';

$xpdo = xPDO::getInstance('db', [
    xPDO::OPT_CACHE_PATH => __DIR__ . '/../cache/',
    xPDO::OPT_HYDRATE_FIELDS => true,
    xPDO::OPT_HYDRATE_RELATED_OBJECTS => true,
    xPDO::OPT_HYDRATE_ADHOC_FIELDS => true,
    xPDO::OPT_CONNECTIONS => [
        [
            'dsn' => 'mysql:host=localhost;dbname=xpdotest;charset=utf8',
            'username' => 'test',
            'password' => 'test',
            'options' => [xPDO::OPT_CONN_MUTABLE => true],
            'driverOptions' => [],
        ]
    ]
]);

$xpdo->setLogLevel(xPDO::LOG_LEVEL_FATAL);
$xpdo->setLogTarget();

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources = [
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'docs' => $root . 'docs/',
    'resolvers' => $root . '_build/resolvers/',
    'core' => [
        'components/slacknotify/',
    ],
];

$signature = join('-', [PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE]);
//$directory = $root . '_packages/';
$directory = __DIR__ . '/../../../core/packages/'; // local place
$filename = $directory . $signature . '.transport.zip';

/* remove the package if it's already been made */
if (file_exists($filename)) {
    unlink($filename);
}
if (file_exists($directory . $signature) && is_dir($directory . $signature)) {
    $cacheManager = $xpdo->getCacheManager();
    if ($cacheManager) {
        $cacheManager->deleteTree($directory . $signature, true, false, []);
    }
}

$package = new xPDOTransport($xpdo, $signature, $directory);

/* load system settings */
if (defined('BUILD_SETTING_UPDATE')) {
    $settings = include $sources['data'] . 'transport.settings.php';
    if (!is_array($settings)) {
        $xpdo->log(XPDO::LOG_LEVEL_ERROR, 'Could not package in settings.');
    } else {
        foreach ($settings as $setting) {
            $package->put($setting, [
                xPDOTransport::UNIQUE_KEY => 'key',
                xPDOTransport::PRESERVE_KEYS => true,
                xPDOTransport::UPDATE_OBJECT => BUILD_SETTING_UPDATE,
                'class' => 'modSystemSetting',
                'resolve' => null,
                'validate' => null,
                'package' => 'modx',
            ]);
        }
    }
}

$resolvers = [];
foreach ($sources['core'] as $file) {
    $directory = dirname($file);
    array_push($resolvers, [
        'type' => 'file',
        'source' => $root . 'core/' . $file,
        'target' => "return MODX_CORE_PATH . '$directory/';"
    ]);
}
array_push($resolvers, [
    'type' => 'php',
    'source' => $sources['resolvers'] . 'resolve.settings.php'
]);

class msPayment extends xPDOObject {}
$payment = new msPayment($xpdo);
$payment->fromArray([
    'id' => null,
    'name' => 'BePaid',
    'description' => null,
    'price' => 0,
    'logo' => null,
    'rank' => 0,
    'active' => 0,
    'class' => 'BePaid',
    'properties' => null
]);

$package->put($payment, [
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => false,
    'package' => 'slackNotify',
    'resolve' => $resolvers
]);

$package->setAttribute('changelog', file_get_contents($sources['docs'] . 'changelog.txt'));
$package->setAttribute('license', file_get_contents($sources['docs'] . 'license.txt'));
$package->setAttribute('readme', file_get_contents($sources['docs'] . 'readme.txt'));
$package->setAttribute('setup-options', [
    'source' => $sources['build'] . 'setup.options.php'
]);

if ($package->pack()) {
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Package built");
}
