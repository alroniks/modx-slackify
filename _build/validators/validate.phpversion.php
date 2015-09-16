<?php

if (!$object->xpdo) {
    return false;
}

if (!version_compare(PHP_VERSION, '5.6.12', '>=')) {
    $object->xpdo->log(modX::LOG_LEVEL_ERROR, 'Invalid php version. Should be grather or equal 5.4');

    return false;
}

return true;
