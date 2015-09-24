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
    case 'OnDocFormSave':

        if ($resource->get('class_key') !== 'Ticket') {
            return;
        }

        if (!empty($mode) && $mode != 'new') {
            return;
        }

        $slackify = $modx->getService('slackify');

        /** @var Ticket $ticket */
        $ticket =& $resource;

        /** @var modUser $creator */
        $creator = $ticket->getOne('CreatedBy');

        /** @var modUserProfile $profile */
        $creatorProfile = $creator->getOne('Profile');

        $a = new Attachment();
        $a->setPretext('Somebody add new important theme for discussion to the site');

        $a->setColor(new Color('#0000FF')); // blue
        $a->setAuthor(new Author($creatorProfile->get('fullname'), 'mailto:' . $creatorProfile->get('email')));

        $ticketTitle = new Link($modx->makeUrl($ticket->get('id'), 'web', '', 'full'), $ticket->get('pagetitle'));
        $a->setTitle(new Title("add new ticket '$ticketTitle'"));
        $a->setText($ticket->get('introtext'));

        $a->addField(new Field('When', $ticket->get('createdon'), true));

        $message = new Message('*New ticket*');
        $message->attach($a);

        $slackify->send($message);
    break;
}



