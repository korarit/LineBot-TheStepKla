<?php
namespace KRTStudio\Function;
include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

use voku\helper\HtmlDomParser;
use voku\helper\UTF8;

class scraping {

    public function Oil (){
        //ดึง content จาก eppo.go.th/templates/eppo_v15_mixed/eppo_oil/eppo_oil_gen_new.php
        $flie = file_get_contents("http://www.eppo.go.th/templates/eppo_v15_mixed/eppo_oil/eppo_oil_gen_new.php");
        $dom = HtmlDomParser::str_get_html($flie);

        //list ดึง class oil_price_colum_name_odd จาก html
        $data_1 = $dom->getElementByClass("oil_price_colum_name_odd");
        //list ดึง class oil_price_colum_name_even จาก html
        $data_2 = $dom->getElementByClass("oil_price_colum_name_even");

        //list ชื่อน้ำมัน ของ class oil_price_colum_name_odd
        $oil_name_1 = ["gasoline_95","Gasohol_91","E85","Diesel","B7_Pro"];
        //list ชื่อน้ำมัน ของ class oil_price_colum_name_even
        $oil_name_2 = ["gasohol_95","E20","Diesel_B7","Diesel_B20","DATE_USE"];

        //list ชื่อปั้มน้ำมันที่่มีข้อมูล
        $gas_station = ["PTT","Bangchak","Shell","ESSO","CALTEX","IRPC","PT","SUBCO","PURE","SUBCO_2"];

        $json = [];
        $i_1 = 0;
        $station_1 = 0;
        foreach ($data_1 as $datas){
            foreach($datas->getElementByClass("oil_price_colum") as  $item){
                $get_oil = $oil_name_1[$i_1];
                $get_station = $gas_station[$station_1];

                $json[$get_oil][$get_station] = $item->text;

                if($station_1 < 9){
                    $station_1++;
                }else{
                    $station_1 = 0;
                }
            }
            $i_1++;
        }

        $i_2 = 0;
        $station_2 = 0;
        foreach ($data_2 as $datas){
            foreach($datas->getElementByClass("oil_price_colum") as  $item){
                $get_oil = $oil_name_2[$i_2];
                $get_station = $gas_station[$station_2];

                $json[$get_oil][$get_station] = $item->text;

                if($station_2 < 9){
                    $station_2++;
                }else{
                    $station_2 = 0;
                }
            }
            $i_2++;
        }

        //สร้างไฟล์ oil_price.json ใน path api
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/oil_price.json', json_encode($json));

        return json_encode($json);
    }

    public function Weather_country (){
        //ดึง content จาก https://www.tmd.go.th/index.php
        $page = file_get_contents("https://www.tmd.go.th/index.php");

        //เริ่มตัด html ไฟล์
        $start_cut = strpos($page, '<table border="0" cellpadding="0" cellspacing="0" width="780px">');
        $page = substr($page, $start_cut);
        $stop_cut = strpos($page, "</table>");
        $pages = substr($page,0, $stop_cut);

        //ดึงข้อมูล จาก tr
        $start_cut2 = strpos($pages, '<td>HPC-พยากรณ์ฝนเชิงพื้นที่</td>
        </tr>');
        $page2 = substr($pages, $start_cut2);
        $stop_cut2 = strpos($pages, "</tr>");
        $data = substr($page2, $stop_cut2);
        //$jsondata = json_encode($data_1);

        //ดึง ข้อมูลจาก tag A
        $dom = HtmlDomParser::str_get_html($data);
        $datas = $dom->getElementsByTagName("a");


        //ดึงลิ้งรูปจาก href
        $json = [];
        $i = 0;
        $name = ["radar","all_area","rain_area_hard","bangkok","rain_forecast"];

        foreach($datas as $item){
            $text = $item->getAttribute("href");
            $text_replaces = str_replace("./", "", $text);

            $text_replacess = str_replace("\\", "/", $text_replaces);

            $text_replace = str_replace("programs//", "programs/", $text_replacess);

            $json[$name[$i]] = $text_replace;

            $i++;
        }

        $json["all_area"] = "https://tmd.go.th/".$json["all_area"];
        $json["bangkok"] = "https://tmd.go.th/".$json["bangkok"];
        $json["rain_area_hard"] = "https://tmd.go.th/".$json["rain_area_hard"];

        //สร้างไฟล์ weather.json ใน path api
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/weather.json', json_encode($json));

        return json_encode($json);
    }

    public function Weather_zone (){
        //ดึง content จาก https://www.tmd.go.th/index.php
        $page = file_get_contents("https://www.tmd.go.th/index.php");

        //เริ่มตัด html ไฟล์
        $start_cut = strpos($page, '<table width="780">');
        $page = substr($page, $start_cut);
        $stop_cut = strpos($page, "</table>");
        $pages = substr($page,0, $stop_cut);

        //ดึงข้อมูล จาก tr
        $start_cut2 = strpos($pages, '<table width="780">
        <tbody><tr>
        <td>');
        $page2 = substr($pages, $start_cut2);
        $stop_cut2 = strpos($pages, '</div>				
        </td>
        </tr>
        <tr>
        <td align="center">');
        $data = substr($page2, $stop_cut2);
        //$jsondata = json_encode($data_1);

        //ดึง ข้อมูลจาก tag A
        $dom = HtmlDomParser::str_get_html($data);
        $datas = $dom->getElementsByTagName("div");

        //echo count($datas);

        //ดึงลิ้งรูปจาก href
        $json = [];
        $i = 0;
        $name = ["upper_north","lower_north","upper_ne","lower_ne","central","eastern","upper_se","lower_se","sw","bangkok"];

        foreach($datas as $item){
            $text = $item->innerHtml();

            $text_replacess = str_replace('<img src="', "", $text);

            $text_replace = str_replace('" width="750px">', "", $text_replacess);

            $json[$name[$i]] = "https://tmd.go.th".$text_replace;

                $i++;
            }
        //สร้างไฟล์ weather.json ใน path api
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/weather_zone.json', json_encode($json));

        return json_encode($json);
    }
}
?>