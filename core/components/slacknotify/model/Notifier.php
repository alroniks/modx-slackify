<?php

include_once 'Attachment/Author.php';
include_once 'Attachment/Color.php';
include_once 'Attachment/Field.php';
include_once 'Attachment.php';
include_once 'Message.php';


class Notifier
{
    private $modx;

    public static function createMessage()
    {
        return new Message();
    }

    public function __construct(modX $modx)
    {
        $this->modx =& $modx;

        // entrypoint
        // channel// to
        // from
        // icon

    }

    public function send($message, $options = [])
    {
        $url = ''; // get from ss
        $fields = [
            'payload' => json_encode([
                "pretext" => "pretext",
                "color" => "#ff0000",
                "text" => $message,
                "channel" => "#offtopic",
                "username" => "shop.by.loc",
                "icon_emoji" => ":monkey_face:",
                "fields" => [[
                    'title' => 'title of field',
                    'value' => 'value',
                    'short' => true
                ]]
            ])
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        // echo "Message '$message' sent.";
    }
}

