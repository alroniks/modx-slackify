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
    case 'OnCommentSave':

        $slackify = $modx->getService('slackify');

        /** @var TicketComment $comment */
        $comment =& $object;

        /** @var TicketThread $ticket */
        $thread = $comment->getOne('Thread');

        /** @var Ticket $ticket */
        $ticket = $thread->getOne('Ticket');

        $a = new Attachment();
        $a->setPretext('Somebody left mention to the important theme on site');

        $a->setColor(new Color('#00FF00')); // green
        $a->setAuthor(new Author($comment->get('name'), 'mailto:' . $comment->get('email')));

        $a->setTitle(new Title("left comment to ticket '{$ticket->get('pagetitle')}'"));
        $a->setText($comment->get('text')); // raw

        $a->addField(new Field('When', $comment->get('createdon'), true));
        $a->addField(new Field('Published', $comment->get('published') ? 'True' : 'False', true));
        $a->addField(new Field('Ticket', new Link($modx->makeUrl($ticket->get('id'), 'web', '', 'full'), $ticket->get('pagetitle'))));

        $message = new Message('*New comment*');
        $message->attach($a);

        $slackify->send($message);
    break;
}
