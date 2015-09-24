# Slackify Extra for MODX Revolution

Extra for simple adding events notifies to Slack chat rooms.

MODX has powerful and simple event model for easy defining events handlers - plugins.
Plugin runs only if some event was fired and in other times plugin do nothing. It's very simple and clear.

This extra allow create own plugins to MODX and provide clear, powerful and customisable API
for send any type of messages to Slack channels and users.

Extra will be available in the official repository and in the modstore.pro, but deploy can take some time, so latest versions of package always available in [releases](/releases).

## Classes

Most of the classes from this extra are follow value-object design pattern. Class Message accumulates in self-build message payload logic.
Class Slackify implements config override and base functions of sending messages. Class Attachment is similar to value-object but more complex and it's a like as master-class for rest small atomic classes.

### class Author

This class keeps inside information about an author.

```php
$author = new Author('Name', 'http://klimchuk.com', 'http://klimchuk.com/iamicon.png');
```

- First parameter `name` is required.
- Second parameter `link` can be defined for representing author name as a link. Also you can add `mailto:` before email address instead of URL, (ex. `mailto:ivan@klimchuk.com`)
- Third parameter `icon` can be defined as a link to the image and it will add small icon image left from author name in the message.

### class Color

It's very simple value-object class. This class contains only string with color in hex format. Also his can validate color string when you try to create an object of the class.

```php
$color = new Color('#FF0000'); // red
```

### class Field

It's very simple value-object class too. Field keep data as key-value storage, but this class has additional parameter - short. This parameter allows to place two field value on one row in Slack chat.

```php
$field = new Field('Client IP address', '127.0.0.1', true);
```

### class Link

Class contain information about the link (URL and title) and process link to a valid format for Slack.

```php
$link = new Link('http://klimchuk.com', 'Ivan Klimchuk'); // <http://klimchuk.com|Ivan Klimchuk>
```

Full details about formatting messages and links you can find in [official documentation of Slack](https://api.slack.com/docs/formatting).

### class Title

Class prepare title text and URL (if defined) to valid format for the message.

```php
$title = new Title('This is title', 'http://google.com');
```

### class Attachment

Class Attachment contains combination of classes, described above. Attachment is a special block of Slack message, that can be attached to the message and can contain information, that formatted by special rules. Here example how we can add other data to attachment:

```php
$a = new Attachment();
$a->setPretext('Somebody add new important theme for discussion to the site');

$a->setColor(new Color('#0000FF')); // blue
$a->setAuthor(new Author($creatorProfile->get('fullname'), 'mailto:' . $creatorProfile->get('email')));

$ticketTitle = new Link($modx->makeUrl($ticket->get('id'), 'web', '', 'full'), $ticket->get('pagetitle'));
$a->setTitle(new Title("add new ticket '$ticketTitle'"));
$a->setText($ticket->get('introtext'));

$a->addField(new Field('When', $ticket->get('createdon'), true));
```

More about attachments you can find in [Slack documentation](https://api.slack.com/docs/attachments).

The class has special methods for set includes.

```php
$a->setText('text');
$a->setPretext('pretext');
$a->setAuthor($author);
$a->setTitle($title);
$a->setColor($color);
$a->addField($field); // attachment can contain array of fields
$a->setImage('url/path/to/image');
$a->setThumb('url/path/to/thumb');
```

### class Message

The message class is general transport class, that will be sent to Slack via web-hook. In Message class, you should define from who and to who the message will be sent. Message class required one parameter - message.

```php
$message = new Message('*New ticket*');
$message->attach($a);
```

Attachment not required for the message, you can create and send the simple text message without any additional data.

For set sender and destination of message you can use some available methods:

```php
$message->to('#newchannel'); // or
$message->to('@username'); // this method override default value of destination from system settings

$message->from('Chuck Norris'); // shit!
// by default Slackify use site_name system setting
```

Also, you can attach a custom icon to your message. You can use the link to image or emoji. The second param defines type of icon.

```php
$message->withIcon('http://klimchuk.com/icon.png', Message::ICON_URL);
$message->withIcon(':monkey:', Message::ICON_EMOJI);
```

Slack support markdown in messages and it can be setting globally by system settings, but you can turn on or turn off markdown for each message.

```php
$message->allowMarkdown();
$message->disallowMarkdown();
```

### class Slackify

Class in the package, that loaded as extension package to MODX and include other related classes. Also, this class provides one general method - `send`.

```php
$slackify->send($message);
```

## Usage

Let's write a plugin for send message to Slack when requested page was not found (404 error). I will write comments in the code below.

```php
switch ($modx->event->name) { // as usual, check event name for run it only for needed event, if plugin attached to several events
    case 'OnPageNotFound':
        $slackify = $modx->getService('slackify'); // Important, you should initialize Slackify service before usage
        // modx will load class Slackify and all related classes for work

        $a = new Attachment(); // create new attachment
        $a->setPretext('This is an automated notification of a 404 error that has occurred on the site.');
        // set pretext. This text will be shown before attachment as plain text

        $a->setColor(new Color('#FF0000')); // define color of line on left from attachment block
        $a->setTitle(new Title($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'])); // define title
        $a->setText('Requested url not found and returns 404 error'); // set text of attachment. It will be shown after title

        // define date and time, when message was sent
        $a->addField(new Field('When', (new DateTime())->format('d M Y - G:i:s'), true));

        // define visitor IP
        $a->addField(new Field('Visitor IP', $_SERVER['REMOTE_ADDR'], true));

        // define user agent data
        $a->addField(new Field('User agent', $_SERVER['HTTP_USER_AGENT']));

        // create message
        $message = new Message('*Error 404*, Page not found');
        $message->attach($a); // attach attachment to message. You cn create several attachments and attach their to message

        $slackify->send($message); // and send message to Slack
    break;
}
```

## System settings

- **setting_slackify_entrypoint** – Url to Slack incoming web-hook
- **setting_slackify_channel** – The default channel that messages will be sent to
- **setting_slackify_username** – The default username that messages will be sent from. If empty will be used site_name setting
- **setting_slackify_icon** – The default icon messages will be sent with, either :emoji: or a URL to an image
- **setting_slackify_link_names** – Whether names like @regan or #accounting should be linked
- **setting_slackify_unfurl_links** – Whether Slack should unfurl text-based URLs
- **setting_slackify_unfurl_media** – Whether Slack should unfurl media-based URLs
- **setting_slackify_allow_markdown** – Whether Markdown should be parsed in messages
- **setting_slackify_markdown_in_attachments** – Which attachment fields should have Markdown parsed

## Contributing

If you found an error or strange behavior, please, [send issue](/issues/new) via GitHub.

**Now I added only four plugins as examples, but I wait suggestions from you, for that cases it would be good write plugin with Slack notifies.**

If you familiar with PHP and want suggest an improvement, fill free to send a pull request with your patch.

Almost at all manuals for creating CMPs build script required installed live MODX site. But I solve this problem.
For start develop this extra you should clone this repository, install xPDO via git modules and run a build script. It's all.

```bash
git clone --recursive git@github.com:Alroniks/modx-slackify.git
cd _build && php build.tranposrt.php
```

After running build script you can see some errors, but it's not important. As we use xPDO without a live connection to the database, errors appear, because we do not use real implementation of classes and tables not exists.

Also, you may change a path to directory for built packages, just redefine variable `$directory` in build.transport.script.

## Troubleshooting

In classes I use type hinting in methods, like this `public function addField(Field $field) {}`, so if you pass to this function simple string you will get error and your script will not work. On the real site, it can looks as white screen or site can have strange behavior. If it occurs, please, at first check error log in MODX and fix the problem described there.

## Author

- [Ivan Klimchuk](http://klimchuk.com), [Alroniks](https://github.com/Alroniks)

## License

Project licensed by MIT. Details in [License file](LICENSE).
