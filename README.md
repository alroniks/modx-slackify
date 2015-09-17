# Slack Notifier Extra for MODX Revolution

Extra for simple adding events notifies to Slack rooms


Usage

$author = new Author('Ivan Klimchuk', 'http://klimchuk.com');

$color = new Color('#FF0000');
$title = new Title('title', 'http://alroniks.com');

$field1 = new Field('ftitle', 'fvalue', true);
$field2 = new Field('ftitl2', 'fval2', false);

$a = new Attachment(
    'this a title',
    'pre text'
);

$a->setAuthor($author);
$a->setColor($color);
$a->setTitle($title);

$a->setImage('http://alroniks.com/img.png');
$a->setThumb('http://alroniks.com/tmg.png');

$a->addField($field1);
$a->addField($field2);

$m = new Message('message special');
$m->from('alroniks')->to('#offtopic')->withIcon('http://alroniks.com/icon');
$m->withIcon(':ghost:', Message::ICON_EMOJI);

$m->attach($a);

//$m->allowMarkdown();
//$m->disallowMarkdown();

$mm = new Message('test <http://klimchuk.com> 2', [
    'unfurl_links' => false
]);
$mm->to('#offtopic')->from('alroniks')->withIcon(':monkey:', Message::ICON_EMOJI);


$n = new Notifier();
$n->send($mm);

//print_r($m);
//echo json_encode($m, JSON_PRETTY_PRINT);

Contributing



TODO:

 - добавить в сборщик поддержку плагинов и событий, чтобы шли с пакетом предустановленные
 - переписать резолвер для опций при установке
 - добавить недостающие опции в список
 - добавить лексиконы для опций

