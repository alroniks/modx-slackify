<?php

if (!$object->xpdo && !$object->xpdo instanceof modX) {
    return true;
}

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
        $object->xpdo->addExtensionPackage('slackNotify', '[[++core_path]]components/slacknotify/model/');
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $object->xpdo->removeExtensionPackage('slackNotify');
        break;
}

return true;
