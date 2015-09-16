<?php

switch ($modx->event->name) {
    case 'OnPageNotFound':
        $msg = new Message('Page not found');

        (new Notifier())->send($msg);

    break;
}
