<?php
namespace KRTStudio\Function;
include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

use voku\helper\HtmlDomParser;
use voku\helper\UTF8;

class lottery {

  public Function get_data_lottery($date){
    $file = file_get_contents("https://news.sanook.com/lotto/check/$date/");
    $dom = HtmlDomParser::str_get_html($file);

    //list ดึง lottocheck__table จาก html
    $data_r1 = $dom->getElementByClass("lottocheck__table");
    $data_r2 = $dom->getElementByClass("lottocheck__sec--nearby");
    $data_r3 = $dom->getElementByClass("lottocheck__sec");


    //$data = $data_r1->getElementsByTagName("strong");

    $i = 0;
    $json = [];
    $datajson = [];
    $name = ["rank1","fist3_1","fist3_2","3back_1","3back_2","2back"];

    foreach($data_r1 as $item){
        $data = $item->getElementsByTagName("strong");
        foreach($data as $items){
            $json[$name[$i]] = $items->text;
            $i++;
        }
    }

    $datajson["rank1"] = $json["rank1"];
    $datajson["fist3"] = [$json["fist3_1"],$json["fist3_2"]];
    $datajson["3back"] = [$json["3back_1"],$json["3back_2"]];
    $datajson["2back"] = $json["2back"];

    foreach($data_r2 as $item){
        $data = $item->getElementsByTagName("strong");
        foreach($data as $items){
            $json["Nearby_rank1"][] = $items->text;
            $i++;
        }
    }
    $datajson["Nearby_rank1"] = $json["Nearby_rank1"];
    //echo json_encode($json);

    $name_rank = ["rank2","rank3","rank4","rank5"];
    $i2 = 0;
    $i3 = 1;
    foreach($data_r3[1] as $item){
        $data = $item->getElementByClass("lotto__number");
        foreach($data as $items){
            $json["rank2"][] = $items->text;
            $i++;
        }
    }
    foreach($data_r3[2] as $item){
        $data = $item->getElementByClass("lotto__number");
        foreach($data as $items){
            $json["rank3"][] = $items->text;
            $i++;
        }
    }
    foreach($data_r3[3] as $item){
        $data = $item->getElementByClass("lotto__number");
        foreach($data as $items){
            $json["rank4"][] = $items->text;
            $i++;
        }
    }
    foreach($data_r3[4] as $item){
        $data = $item->getElementByClass("lotto__number");
        foreach($data as $items){
            $json["rank5"][] = $items->text;
            $i++;
        }
    }

    $datajson["rank2"] = $json["rank2"];
    $datajson["rank3"] = $json["rank3"];
    $datajson["rank4"] = $json["rank4"];
    $datajson["rank5"] = $json["rank5"];

    return json_encode($datajson);
    //echo json_encode($datajson);
    //file_put_contents('log.txt', $dom, FILE_APPEND);
  }

  public function get_date(){
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

    //สร้างไฟล์ date_lottery.json ใน path api
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/date_lottery.json', json_encode($json));

    return json_encode($json);
  }
}

class lottery_api {
  public function check_lottery($code , $date){
    $lottery = new lottery();

    //ดึงข้อมูล จาก sanook.com
    $data = json_decode($lottery->get_data_lottery($date), true);

    if($code == $data["rank1"]){
      return "คุณถูกรางวัลที่ 1";
    }
    elseif(in_array($code, $data["Nearby_rank1"])){
      return "คุณถูกรางวัลใกล้เคียงรางวัลที่ 1";
    }
    elseif(in_array($code, $data["rank2"])){
      return "คุณถูกรางวัลที่ 5";
    }
    elseif(in_array($code, $data["rank3"])){
      return "คุณถูกรางวัลที่ 3";
    }
    elseif(in_array($code, $data["rank4"])){
      return "คุณถูกรางวัลที่ 4";
    }
    elseif(in_array($code, $data["rank5"])){
      return "คุณถูกรางวัลที่ 5";
    }
    elseif(str_contains($code, $data["fist3"][0]) || str_contains($code, $data["fist3"][1])){
      return "คุณถูกรางวัล 3 ตัวหน้า";
    }
    elseif(str_contains($code, $data["3back"][0]) || str_contains($code, $data["3back"][1])){
      return "คุณถูกรางวัล 3 ตัวท้าย";
    }
    elseif(str_contains($code, $data["2back"])){
      return "คุณถูกรางวัล 2 ตัวท้าย";
    }
    else{
      return "คุณไม่ถูกรางวัล";
    }
  }

  public function get_datetext($date){
    $lottery = new lottery();


    $i = 0;
    $text_date = "";
    //ดึงวันที่
    $data = json_decode($lottery->get_date(), true);
    foreach($data["date"] as $item){
      if ($item[1] == $date) {
        $text_date = $item[0];
      }
      $i++;
    }
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/log.text', $text_date . PHP_EOL, FILE_APPEND);

    return $text_date;
  }
}
?>