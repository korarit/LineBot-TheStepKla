<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/function/lottery.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/function/scraping.php');


use KRTStudio\Function\lottery;
use KRTStudio\Function\lottery_api;

use KRTStudio\Function\scraping;

$lottery_api = new lottery();

$lottery_api_check = new lottery_api();

$scraping_api = new scraping();

$mode = $_GET["mode_api"];

if($mode == "lottery_check"){
   echo $lottery_api_check->check_lottery($_GET["code"], $_GET["date"]);
}
if($mode == "lottery"){
   echo $lottery_api->get_data_lottery($_GET["date"]);
}
if($mode == "lottery_data"){
   $data = json_decode($lottery_api->get_data_lottery($_GET["date"]), true);
   print_r($data["Nearby_rank1"]);
}
if($mode == "date_lottery"){
   echo $lottery_api->get_date();
}
if($mode == "weather_country"){
   echo $scraping_api->Weather_country();
}
if($mode == "Weather_zone"){
   echo $scraping_api->Weather_zone();
}
if($mode == "oil"){
   echo $scraping_api->Oil();
}
?>