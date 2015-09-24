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
 * Slackify package builder
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package slackNotify
 * @subpackage build
 */

set_time_limit(0);

ini_set('date.timezone', 'Europe/Minsk');

define('PKG_NAME', 'Slackify');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));
define('PKG_VERSION', '0.6.2');
define('PKG_RELEASE', 'beta');

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

$xpdo->setLogLevel(xPDO::LOG_LEVEL_INFO);
$xpdo->setLogTarget();

class modNamespace extends xPDOObject {}
class modCategory extends xPDOObject {
    public function getFKDefinition($alias)
    {
        $aggregates = [
            'Plugins' => [
                'class' => 'modPlugin',
                'local' => 'id',
                'foreign' => 'category',
                'cardinality' => 'many',
                'owner' => 'local',
            ]
        ];

        return isset($aggregates[$alias]) ? $aggregates[$alias] : [];
    }
}
class modSystemSetting extends xPDOObject {}
class modPlugin extends xPDOObject {
    public function getFKDefinition($alias)
    {
        $aggregates = [
            'PluginEvents' => [
                'class' => 'modPluginEvent',
                'local' => 'id',
                'foreign' => 'pluginid',
                'cardinality' => 'one',
                'owner' => 'local',
            ]
        ];

        return isset($aggregates[$alias]) ? $aggregates[$alias] : [];
    }
}
class modPluginEvent extends xPDOObject {}

/* define sources */
$root = dirname(dirname(__FILE__)) . '/';
$sources = [
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'plugins' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/',
    'docs' => $root . 'docs/',
    'resolvers' => $root . '_build/resolvers/',
    'validators' => $root . '_build/validators/',
    'core' => [
        'components/slackify/',
    ],
];

$signature = join('-', [PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE]);
//$directory = $root . '_packages/';
$directory = __DIR__ . '/../../../core/packages/'; // local place
$filename = $directory . $signature . '.transport.zip';

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

$namespace = new modNamespace($xpdo);
$namespace->fromArray([
    'id' => PKG_NAME_LOWER,
    'name' => PKG_NAME_LOWER,
    'path' => '{core_path}components/' . PKG_NAME_LOWER . '/',
]);

$package->put($namespace, [
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RESOLVE_FILES => true,
    xPDOTransport::RESOLVE_PHP => true,
    xPDOTransport::NATIVE_KEY => PKG_NAME_LOWER,
    'namespace' => PKG_NAME_LOWER,
    'package' => 'modx',
    'resolve' => null,
    'validate' => null
]);

$settings = include $sources['data'] . 'transport.settings.php';
foreach ($settings as $setting) {
    $package->put($setting, [
        xPDOTransport::UNIQUE_KEY => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => true,
        'class' => 'modSystemSetting',
        'resolve' => null,
        'validate' => null,
        'package' => 'modx',
    ]);
}

$validators = [];
array_push($validators, [
    'type' => 'php',
    'source' => $sources['validators'] . 'validate.phpversion.php'
]);

$resolvers = [];
foreach ($sources['core'] as $file) {
    $directory = dirname($file);
    array_push($resolvers, [
        'type' => 'file',
        'source' => $root . 'core/' . $file,
        'target' => "return MODX_CORE_PATH . '$directory/';"
    ]);
}
array_push($resolvers,
    ['type' => 'php', 'source' => $sources['resolvers'] . 'resolve.extension.php'],
    ['type' => 'php', 'source' => $sources['resolvers'] . 'resolve.settings.php']
);

$category = new modCategory($xpdo);
$category->fromArray([
    'id' => 1,
    'category' => PKG_NAME,
    'parent' => 0,
]);

$plugins = include $sources['data'] . 'transport.plugins.php';
if (is_array($plugins)) {
    $category->addMany($plugins, 'Plugins');
}

$package->put($category, [
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::ABORT_INSTALL_ON_VEHICLE_FAIL => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'Plugins' => [
            xPDOTransport::UNIQUE_KEY => 'name',
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::RELATED_OBJECTS => true
        ],
        'PluginEvents' => [
            xPDOTransport::UNIQUE_KEY => ['pluginid', 'event'],
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::RELATED_OBJECTS => true
        ]
    ],
    xPDOTransport::NATIVE_KEY => true,
    'package' => 'modx',
    'validate' => $validators,
    'resolve' => $resolvers
]);

$package->setAttribute('changelog', file_get_contents($sources['docs'] . 'changelog.txt'));
$package->setAttribute('license', file_get_contents($sources['docs'] . 'license.txt'));
$package->setAttribute('readme', file_get_contents($sources['docs'] . 'readme.txt'));
$package->setAttribute('requires', ['php' => '>=5.4']);
$package->setAttribute('setup-options', ['source' => $sources['build'] . 'setup.options.php']);

if ($package->pack()) {
    $xpdo->log(xPDO::LOG_LEVEL_INFO, "Package built");
}
