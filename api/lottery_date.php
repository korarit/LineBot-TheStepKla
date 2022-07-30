<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

use voku\helper\HtmlDomParser;
use voku\helper\UTF8;

$file = file_get_contents("https://news.sanook.com/lotto/");
$dom = HtmlDomParser::str_get_html($file);

//list ดึง lottocheck__table จาก html
$data_r1 = $dom->getElementByClass("lotto-form__select");



//$data = $data_r1->getElementsByTagName("strong");

$i = 0;
$json = [];
$datajson = [];

foreach($data_r1 as $item){
    $data = $item->getElementsByTagName("option");
    foreach($data as $items){
        $json["date"][] = [$items->text, $items->getAttribute("value")];
        $i++;
    }
}
print_r($json);
//echo $data_r1;
//file_put_contents('log.txt', $dom, FILE_APPEND);
?>