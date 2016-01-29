<?php
switch ($modx->event->name) { // as usual, check event name for run it only for needed event, if plugin attached to several events
    case 'OnResourceDelete':
        $slackify = $modx->getService('slackify'); // Important, you should initialize Slackify service before usage
        // modx will load class Slackify and all related classes for work
        // create message
        $sitename = $modx->getOption('site_name');
        $siteurl = $modx->getOption('site_url');   
        $user = $modx->getUser();
        if (!$user) break;
        $creatorProfile = $user->getOne('Profile');
        if (!$creatorProfile) break;

        $a = new Attachment();
        $a->setColor(new Color('#ff7e00'));
        $a->setAuthor(new Author($creatorProfile->get('fullname'), 'mailto:' . $creatorProfile->get('email')));
        $resourceTitle = new Link($modx->makeUrl($resource->get('id'), 'web', '', 'full'), $resource->get('pagetitle'));
        $a->setTitle(new Title("deleted resource '$resourceTitle' in Context ".$resource->get('context_key')));
        $a->setText($resource->get('description'));
        $a->addField(new Field('Context',$resource->get('context_key'), true));
        $a->addField(new Field('ID', $resource->get('id'), true));
        $a->addField(new Field('Alias', $resource->get('alias'), true));
        $a->addField(new Field('Menu-Title', $resource->get('menutitle'), true));
        if ($resource->get('published')==1){ $published = 'yes'; } else { $published = 'no'; }
        $a->addField(new Field('Published', $published, true));
        $templateObj = $resource->getOne('Template');
        $a->addField(new Field('Template', $resource->get('template').' - '.$templateObj->get('templatename'), true));
        $a->addField(new Field('When', (new DateTime())->format('d M Y - G:i:s'), true));
        $a->addField(new Field('User IP', $_SERVER['REMOTE_ADDR'], true));
        $message = new Message('*resource deleted* on '.$sitename.' at '.$siteurl);
        $message->attach($a); // attach attachment to message. You cn create several attachments and attach their to message
        $slackify->send($message); // and send message to Slack
    break;
}