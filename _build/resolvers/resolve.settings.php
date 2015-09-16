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
 * System settings resolver
 *
 * @author Ivan Klimchuk <ivan@klimchuk.com>
 * @package slacknotify
 * @subpackage build
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;

    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            if (!empty($options['bepaid-store-id'])) {
                if (!$tmp = $modx->getObject('modSystemSetting', array('key' => 'ms2_payment_bepaid_store_id'))) {
                    $tmp = $modx->newObject('modSystemSetting');
                }
                $tmp->fromArray(array(
                    'namespace' => 'minishop2',
                    'area' => 'ms2_payment_bepaid',
                    'xtype' => 'textfield',
                    'value' => $options['bepaid-store-id'],
                    'key' => 'ms2_payment_bepaid_store_id',
                ), '', true, true);
                $tmp->save();
            }

            break;

        case xPDOTransport::ACTION_UPGRADE:
            break;

        // TODO: Should be replace to valid data
        case xPDOTransport::ACTION_UNINSTALL:
//            $modelPath = $modx->getOption('minishop2.core_path', null, $modx->getOption('core_path') . 'components/minishop2/') . 'model/';
//            $modx->addPackage('minishop2', $modelPath);
//            $modx->removeCollection('msPayment', array('class' => 'WebPay'));
//            $modx->removeCollection('modSystemSetting', array('key:LIKE' => 'ms2\_payment\_bepaid\_%'));
            break;
    }
}

return true;
