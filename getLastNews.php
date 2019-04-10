<?php
//кол-во
$count = 5;
if (!empty($_GET['count'])) $count = $_GET['count'];

//сортировка
$sort = 'asc';// asc/desc
if (!empty($_GET['sort'])) $sort = $_GET['sort'];

$siteUrl = 'https://lenta.ru/rss';
$SiteRss = simplexml_load_file($siteUrl);

//собираем массив для дальнейшей работы
foreach ($SiteRss->channel->item as $item) {
    $array[] = <<<RSS
Название: {$item->title}\n
Ссылка на новость: {$item->link}\n
Анонс: {$item->description}\n\n
RSS;
}

//сортировка по  убыванию
if ($sort == 'desc') krsort($array);

//выводим в цикле $count элементов
$i = 1;
foreach ($array as $val) {
    print $val;
    if ($i >= $count) break;
    $i++;
}