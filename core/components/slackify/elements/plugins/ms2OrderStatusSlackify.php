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

switch ($modx->event->name) {
    case 'msOnChangeOrderStatus':

        $slackify = $modx->getService('slackify');

        /** @var msOrderStatus $status */
        $status = $modx->getObject('msOrderStatus', ['id' => $order->get('status'), 'active' => true]);

        $new = $order->get('status') == 1;

        $a = new Attachment();
        $a->setPretext($new ? 'New order was made on site' : 'Status of order was changed');
        $a->setColor(new Color('#' . $status->get('color'))); // from status

        /** @var modAction $action */
        $action = $modx->getObject('modAction', ['namespace' => 'minishop2', 'controller' => 'controllers/mgr/orders']);
        $link = new Link(rtrim(MODX_SITE_URL, '/') . MODX_MANAGER_URL . "index.php?a={$action->get('id')}#&order={$order->get('id')}", $order->get('num'));
        $title = $new
            ? "New order $link was placed on the site"
            : "Order with $link was updated";

        $a->setTitle(new Title($title));
        $a->addField(new Field('Status', $status->get('name'), true));
        $a->addField(new Field('When', $order->get('createdon'), true));

        if ($new) {
            $a->addField(new Field('Cost', $order->get('cost'), true));
            $a->addField(new Field('Cart cost', $order->get('cost'), true));

            $a->addField(new Field('Delivery', $order->getOne('Delivery')->get('name'), true));
            $a->addField(new Field('Delivery cost', $order->get('delivery_cost'), true));

            $a->addField(new Field('Payment', $order->getOne('Payment')->get('name'), true));
            $a->addField(new Field('Weight'), $order->get('weight'));

            $a->setText($order->get('comment'));
        }

        $message = new Message($new ? '*New order*' : '*Order status update*');
        $message->attach($a);

        $slackify->send($message);

    break;
}
