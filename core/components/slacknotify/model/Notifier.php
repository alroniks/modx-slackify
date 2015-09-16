<?php

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
