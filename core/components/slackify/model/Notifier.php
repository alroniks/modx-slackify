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

include_once 'Attachment/Author.php';
include_once 'Attachment/Color.php';
include_once 'Attachment/Field.php';
include_once 'Attachment/Title.php';
include_once 'Attachment.php';
include_once 'Message.php';

class Notifier
{
//    private $modx;

//    public function __construct(modX $modx)
//    {
////        $this->modx =& $modx;
//
//        // entrypoint
//        // channel// to
//        // from
//        // icon
//
//    }

    public function send(Message $message)
    {
        $entrypoint = $this->modx->getOption('slacknotify_entrypoint', null, false);
        if (!$entrypoint) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Entry point for SlackNotify not defined in system settings');
        }

        if (!$message->getChannel()) {
            $message->setChannel($this->modx->getOption('slacknotify_channel', null, '#general'));
        }

        if (!$message->getUsername()) {
            $username = $this->modx->getOption('slacknotify_username', null, $this->modx->getOption('site_name'));
            $message->setUsername($username);
        }

        // TODO: added abbility reset config options, if not set

        $fields = ['payload' => json_encode($message)];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $entrypoint);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);

        if ($output != 'ok') {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Cannot send message to Slack, reason: "' . $output . '"');
        }
    }
}
