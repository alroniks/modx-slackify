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

 + добавить namespace в пакет, без него не будут работать системные настройки и лексиконы - v0.2  
 
 - добавить недостающие опции в список
 - переписать резолвер для опций при установке - v0.3
 - добавить лексиконы для опций - v0.3
 
 - добавить в сборщик поддержку плагинов и событий, чтобы шли с пакетом предустановленные - v0.4

 - добавить плагин для NotFound - v0.5
 - добавить плагин для miniShop2 - v0.6
 - добавить плагин для Tickets - v0.7
 - ?
 
 - обновить документацию, написать примеры
 - написать заметку в блоге на английском и на русском, сделать репост на modx.pro
 
 

