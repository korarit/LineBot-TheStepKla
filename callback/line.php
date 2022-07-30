<?php
//set time zone to thai
date_default_timezone_set('Asia/Bangkok');


//line sdk

//ใช้ flie autoload สำหรับเรียกใช้ line sdk , config สำหรับ การตั้งค่า , function ที่เขียนเสริมขึ้นมา
include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/function/database.php');

//function ที่เขียนเอง
include_once($_SERVER['DOCUMENT_ROOT'].'/function/Line.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/function/weather.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/function/template_json.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/function/lottery.php');


use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;

use LINE\LINEBot\MessageBuilder\FlexMessageBuilder;

use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;

use LINE\LINEBot\MessageBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\CarouselColumnTemplateBuilder;

use LINE\LINEBot\RichMenuBuilder;

//my funtion
use KRTStudio\Function\Config;
use KRTStudio\Function\Line\LineMessage;

use KRTStudio\Function\Weather;
use KRTStudio\Function\Weather_Message;

use KRTStudio\Function\Template_json;

use KRTStudio\Function\Database\User;
use KRTStudio\Function\Database\Check;

use KRTStudio\Function\lottery_api;

//get lottery_api
$api_lottery = new lottery_api();


//get template_menu
$template_menu = new Template_json();

//get line user
$user_chatbot = new User();

//check user
$check_user = new Check();

//use line json
$send_line_json = new LineMessage();

//ใช้ api ของกรมอุตุนิยมวิทยา
$weater_api = new Weather();

//สร้าง genaration message
$Weather_Message = new Weather_Message();

//use line bot sdk
$getConfig = new Config();
$httpClient = new CurlHTTPClient($getConfig->BotLine('channel_access'));
$bot = new LINEBot($httpClient, ['channelSecret' => $getConfig->BotLine('channel_secret')]);

//get input data
$data = file_get_contents('php://input');
$data_json = json_decode($data,true);

//logs line data
file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);

//function//

//ดึง ประเภท
$type = $data_json['events'][0]['type'];

//user_id
$user_id = $data_json['events'][0]['source']['userId'];

if($type == "follow"){

    $token = $data_json['events'][0]['replyToken'];

    $msg = array(
    "replyToken" => $token, 
    "messages" => [
            [
                "type" => "flex", 
                "altText" => "this is a flex message", 
                "contents" => [
                "type" => "bubble", 
                "header" => [
                    "type" => "box", 
                    "layout" => "vertical", 
                    "contents" => [
                        [
                            "type" => "text", 
                            "text" => "สมัครใช้งาน chatbot", 
                            "size" => "xl", 
                            "weight" => "bold" 
                        ], 
                        [
                            "type" => "text", 
                            "text" => "พัฒนาโดย นายกรฤต แสงทอง", 
                            "size" => "xs" 
                        ] 
                    ], 
                    "backgroundColor" => "#CFD4FF" 
                ], 
                "body" => [
                                "type" => "box", 
                                "layout" => "vertical", 
                                "contents" => [
                                    [
                                        "type" => "text", 
                                        "text" => "ข้อตกลงใช้บริการ", 
                                        "size" => "lg" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "- ทางเราไม่รับผิดชอบในข้อมูลที่ผิดพลาด", 
                                        "size" => "xs" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "- ทางเราไม่มีการเก็บข้อมูลการใช้งานเชิงลึกต่างๆ", 
                                        "size" => "xs" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "โดยจะมีการเก็บแค่ user id และ ชื่อ function ที่", 
                                        "size" => "xs" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "ใช้งานกับ chatbot ล่าสุดเท่านั้น ", 
                                        "size" => "xs" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "- ทางเราขอเก็บ log เพื่อใช้ในการพัฒนาระบบโดย", 
                                        "size" => "xs" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "จะเก็บแค่ ส่วนที่มีปัญหา เพื่อใช้ในการตรวจสอบ", 
                                        "size" => "xs" 
                                    ] 
                                ] 
                            ], 
                "footer" =>  [
                                    "type" => "box", 
                                    "layout" => "vertical", 
                                    "contents" => [
                                        [
                                            "type" => "button", 
                                            "action" => [
                                                    "type" => "message", 
                                                    "label" => "สมัครใช้งาน", 
                                                    "text" => "register_yes" 
                                                    ], 
                                            "offsetTop" => "xs", 
                                            "margin" => "xs", 
                                            "style" => "primary" 
                                        ] 
                                    ] 
                                ] 
                ] 
            ] 
        ] 
    ); 
 

    //ตรวจสอบว่า สมัครหรือยัง
    if($check_user->check_login($user_id) == "no"){
        $user_chatbot->user_add($user_id);
        $results = $send_line_json->sendMessageOnJson(json_encode($msg));
        file_put_contents('logerror.txt', json_encode($msg).$results . PHP_EOL, FILE_APPEND);
    }else{
        $msg = new TextMessageBuilder('คุณลงทะเบียนไปแล้ว');
        $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
    }
}

//เช็คว่า เป็น type massage
if($type == 'message'){

    $get_user_id = $data_json['events'][0]['source']['userId'];

    //ดึง ประเภท ของข้อความ
    $type_massage = $data_json['events'][0]['message']['type'];

    //เช็คว่าเป็น ข้อความแบบ text
    if($type_massage == 'text'){

        //ดึงข้อความ
        $message = $data_json['events'][0]['message']['text'];

        //token
        $token = $data_json['events'][0]['replyToken'];

        //เรียกใช้ function weather จาก text
        if($message == 'register_yes') {
            $user_chatbot->user_register($get_user_id);
            $bot->linkRichMenu($get_user_id, "richmenu-e67bca2eb0fecb96b2f374562550106a");
        }
        elseif(str_contains($message, 'checklottery_ตรวจสลากรัฐบาล')) {
            $explode_message = explode(",", $message);

            //ดึงข้อมูลการได้รางวัล
            $answer = $api_lottery->check_lottery($explode_message[1], $explode_message[2]);
            $text_date = $api_lottery->get_datetext($explode_message[2]);

            //ส่งข้อความ
            $msg = $template_menu->lottery_answer($token, $explode_message[1], $text_date, $answer);

            $get_error = $send_line_json->sendMessageOnJson($msg);
            file_put_contents('log_check.txt', $get_error, FILE_APPEND);
        }
        elseif(str_contains($message, 'weathers_')) {

            $function_class = str_replace("weathers_","",$message);

            if($check_user->check_register($get_user_id) == "1"){
                if($function_class == "พยากรณ์อากาศรายวัน"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weather_day");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                elseif($function_class == "พยากรณ์อากาศรายชั่วโมง"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weather_hour");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                elseif($function_class == "พยากรณ์อากาศรายภาค"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weather_zone");

                    $msg = $template_menu->weather_zone_menu($token);
                    $send_line_json->sendMessageOnJson($msg);
                }
                elseif(str_contains($function_class, 'พยากรณ์อากาศรายพื้นที่{"type":')){

                    $user_chatbot->user_update_subfunction($get_user_id, "weather_area");

                    $days = date("Y-m-d");
                    $Hours = date("H");

                    $json = str_replace("พยากรณ์อากาศรายพื้นที่","",$function_class);
                    $array_data = json_decode($json, true);
                    if($array_data["type"] == "hour"){
                        //เอาตำบล
                        if($array_data["province"] != "" && $array_data["amphoe"] != "" && $array_data["district"] != ""){
                           $getweather = $weater_api->Hour_Area_Weather($array_data["province"], $array_data["amphoe"], $array_data["district"], $days, $Hours, $array_data["duration"]);

                           $genaration_message = $Weather_Message->Hour_Message($getweather, $token);

                           $results = $send_line_json->sendMessageOnJson($genaration_message);
                           file_put_contents('log_weather.txt', $results, FILE_APPEND);
                        }
                        //ไม่เอาตำบล
                        elseif($array_data["province"] != "" && $array_data["amphoe"] != "" && $array_data["district"] == ""){
                            $getweather = $weater_api->Hour_Area_Weather($array_data["province"], $array_data["amphoe"], "", $days, $Hours, $array_data["duration"]);
                            
                            $genaration_message = $Weather_Message->Hour_Message($getweather, $token);

                            $results = $send_line_json->sendMessageOnJson($genaration_message);
                            file_put_contents('log_weather.txt', $results, FILE_APPEND);
                        }
                        //ไม่เอาตำบล และ อำเภอ
                        elseif($array_data["province"] != "" && $array_data["amphoe"] == "" && $array_data["district"] == ""){
                            $getweather = $weater_api->Hour_Area_Weather($array_data["province"], "", "", $days, $Hours, $array_data["duration"]);
                            
                            $genaration_message = $Weather_Message->Hour_Message($getweather, $token);

                            $results = $send_line_json->sendMessageOnJson($genaration_message);
                            file_put_contents('log_weather.txt', $results, FILE_APPEND);
                        }
                    }
                    if($array_data["type"] == "day"){
                        //เอาตำบล
                        if($array_data["province"] != "" && $array_data["amphoe"] != "" && $array_data["district"] != ""){
                            $getweather = $weater_api->Day_Area_Weather($array_data["province"], $array_data["amphoe"], $array_data["district"], $days, $array_data["duration"]);
                            
                            $genaration_message = $Weather_Message->Day_Message($getweather, $token);

                            $results = $send_line_json->sendMessageOnJson($genaration_message);
                            file_put_contents('log_weather.txt', $results, FILE_APPEND);
                        }
                        //ไม่เอาตำบล
                        elseif($array_data["province"] != "" && $array_data["amphoe"] != "" && $array_data["district"] == ""){
                            $getweather = $weater_api->Day_Area_Weather($array_data["province"], $array_data["amphoe"], $array_data["district"], $days, $array_data["duration"]);
                            
                            $genaration_message = $Weather_Message->Day_Message($getweather, $token);

                            $results = $send_line_json->sendMessageOnJson($genaration_message);
                            file_put_contents('log_weather.txt', $results, FILE_APPEND);
                        }
                        //ไม่เอาตำบล และ อำเภอ
                        elseif($array_data["province"] != "" && $array_data["amphoe"] == "" && $array_data["district"] == ""){
                            $getweather = $weater_api->Day_Area_Weather($array_data["province"], $array_data["amphoe"], $array_data["district"], $days, $array_data["duration"]);
                            
                            $genaration_message = $Weather_Message->Day_Message($getweather, $token);

                            $results = $send_line_json->sendMessageOnJson($genaration_message);
                            file_put_contents('log_weather.txt', $results, FILE_APPEND);
                        }
                    }
                    file_put_contents('log_test.txt', $json, FILE_APPEND);
                }
                elseif($function_class == "พยากรณ์อากาศทั่วประเทศ"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weather_country");

                    $msg = $template_menu->weather_country_menu($token);
                    $send_line_json->sendMessageOnJson($msg);
                }
            }else{
                $msg = new TextMessageBuilder('คุณไม่ได้สมัครสมาชิก เพื่อใช้ chatbot');
                $bot->replyMessage($token, $msg);
            }
            file_put_contents('logerror.txt', $function_class . PHP_EOL, FILE_APPEND);
        }
        elseif(str_contains($message, 'forecastzone_')) {

            $function_class = str_replace("forecastzone_", "", $message);

            if($check_user->check_register($get_user_id) == "1"){
                if($function_class == "ภาคเหนือตอนบน"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_upper_n");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["upper_north"], $get_data["upper_north"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคเหนือตอนล่าง"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_lower_n");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["lower_north"], $get_data["lower_north"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคตะวันออกเฉียงเหนือตอนบน"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_upper_ne");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["upper_ne"], $get_data["upper_ne"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคตะวันออกเฉียงเหนือตอนล่าง"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_lower_ne");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["lower_ne"], $get_data["lower_ne"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคกลาง"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_central");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["central"], $get_data["central"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคตะวันออก"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_eastern");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["eastern"], $get_data["eastern"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคใต้ฝั่งตะวันออกตอนบน"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_upper_se");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["upper_se"], $get_data["upper_se"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคใต้ฝั่งตะวันออกตอนล่าง"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_lower_se");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["lower_se"], $get_data["lower_se"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "ภาคใต้ฝั่งตะวันตก"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_sw");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["sw"], $get_data["sw"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "กรุงเทพและปริมณฑล"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_zone_bangkok");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather_zone.json'), true);
                    $msg = new ImageMessageBuilder($get_data["bangkok"], $get_data["bangkok"]);
                    $check_error = $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);

                    file_put_contents('logweather_zone.txt', $check_error . PHP_EOL, FILE_APPEND);
                }
            }else{
                $msg = new TextMessageBuilder('คุณไม่ได้สมัครสมาชิก เพื่อใช้ chatbot');
                $bot->replyMessage($token, $msg);
            }
            file_put_contents('logerror.txt', $function_class . PHP_EOL, FILE_APPEND);
        }
        elseif(str_contains($message, 'weathers_country_')) {

            $function_class = str_replace("weathers_country_", "", $message);

            if($check_user->check_register($get_user_id) == "1"){
                if($function_class == "radar"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_country_radar");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather.json'), true);
                    $msg = new TextMessageBuilder($get_data["radar"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "rainhard"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_country_rainhard");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather.json'), true);
                    $msg = new ImageMessageBuilder($get_data["rain_area_hard"], $get_data["rain_area_hard"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
                if($function_class == "forecastday"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_country_forecastday");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather.json'), true);
                    $msg = new ImageMessageBuilder($get_data["all_area"], $get_data["all_area"]);
                    $get_error = $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);

                    file_put_contents('logerror.txt', $get_error . PHP_EOL, FILE_APPEND);
                }
                if($function_class == "rain_zone"){

                    $user_chatbot->user_update_subfunction($get_user_id, "weathers_country_rain_zone");

                    $get_data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/weather.json'), true);
                    $msg = new TextMessageBuilder($get_data["rain_forecast"]);
                    $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
                }
            }else{
                $msg = new TextMessageBuilder('คุณไม่ได้สมัครสมาชิก เพื่อใช้ chatbot');
                $bot->replyMessage($token, $msg);
            }
        }
        elseif(str_contains($message, 'register_')) {

            $function_class = substr($message, 9);

            if($function_class == "yes"){
                
                $user_chatbot->user_register($get_user_id);

                $msg = new TextMessageBuilder('คุณได้สมัครสมาชิก เพื่อใช้ chatbot');
                $bot->replyMessage($data_json['events'][0]['replyToken'], $msg);
            }
        }
        elseif(str_contains($message, 'function_')) {

            $function_class = substr($message, 9);

            if($check_user->check_register($get_user_id) == "1"){
                if($function_class == "พยากรณ์อากาศ"){

                    $user_chatbot->user_update_function($get_user_id, "weather_status");

                    $msg = $template_menu->weather_menu($token);
                    $send_line_json->sendMessageOnJson($msg);
                }
                if($function_class == "ตรวจสอบสถานะพัสดุ"){

                    $user_chatbot->user_update_function($get_user_id, "express_track");

                    $msg = $template_menu->express_menu($token);
                    $send_line_json->sendMessageOnJson($msg);
                }
                if($function_class == "ตรวจหวย"){

                    $user_chatbot->user_update_function($get_user_id, "check_lottery");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                if($function_class == "ราคาน้ำมัน"){

                    $user_chatbot->user_update_function($get_user_id, "oil_price");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                if($function_class == "ราคาสินค้าอุปโภค"){

                    $user_chatbot->user_update_function($get_user_id, "market_price");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                if($function_class == "อัตราแลกเปลี่ยนเงินระหว่างประเทศ"){

                    $user_chatbot->user_update_function($get_user_id, "exchange_money");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                if($function_class == "คุณกับchatbot"){

                    $user_chatbot->user_update_function($get_user_id, "chatbot");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                if($function_class == "ระบบอื่นๆ"){

                    $user_chatbot->user_update_function($get_user_id, "other");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
                if($function_class == "ผู้พัฒนา"){

                    $user_chatbot->user_update_function($get_user_id, "developer");

                    $msg = new TextMessageBuilder('กรุณาส่ง location');
                    $bot->replyMessage($token, $msg);
                }
            }else{
                $msg = new TextMessageBuilder('คุณไม่ได้สมัครสมาชิก เพื่อใช้ chatbot');
                $bot->replyMessage($token, $msg);
            }
            file_put_contents('logerror.txt', $function_class . PHP_EOL, FILE_APPEND);
        }
    }
    if($type_massage == 'location'){

        $lat = $data_json['events'][0]['message']['latitude'];
        $lon = $data_json['events'][0]['message']['longitude'];

        $token = $data_json['events'][0]['replyToken'];

        $day = date("Y-m-d");

        if($check_user->check_register($user_id) == "1"){

            if($user_chatbot->user_sub_function($user_id) == "weather_day"){
                $jsons = array(
                    "replyToken" => $token, 
                    "messages" => [
                        [
                            "type" => "flex", 
                            "altText" => "this is a flex message", 
                            "contents" => [
                                "type" => "bubble", 
                                "body" => [
                                "type" => "box", 
                                "layout" => "vertical", 
                                "contents" => [
                                    [
                                            "type" => "button", 
                                            "action" => [
                                                "type" => "postback", 
                                                "label" => "3วันล่วงหน้า", 
                                                "data" => '{"lat" : '.$lat.', "lon" : '.$lon.', "duration" : 3, "date" : "'.$day.'", "type" : "day", "functions" : "weather"}'
                                            ], 
                                            "color" => "#ff0000", 
                                            "style" => "primary" 
                                    ], 
                                    [
                                            "type" => "button", 
                                            "action" => [
                                                "type" => "postback", 
                                                "label" => "7วันล่วงหน้า", 
                                                "data" => '{"lat" : '.$lat.', "lon" : '.$lon.', "duration" : 7, "date" : "'.$day.'", "type" : "day", "functions" : "weather"}'
                                            ], 
                                            "color" => "#ffdc00", 
                                            "style" => "primary" 
                                    ], 
                                    [
                                            "type" => "button", 
                                            "action" => [
                                            "type" => "postback", 
                                            "label" => "10วันล่วงหน้า", 
                                                "data" => '{"lat" : '.$lat.', "lon" : '.$lon.', "duration" : 10, "date" : "'.$day.'", "type" : "day", "functions" : "weather"}'
                                            ], 
                                            "color" => "#bad9ef", 
                                            "style" => "primary" 
                                    ] 
                                ] 
                                ] 
                            ] 
                        ] 
                    ] 
                );
                $results = $send_line_json->sendMessageOnJson(json_encode($jsons));
                file_put_contents('logerror.txt', json_encode($jsons) . $results . PHP_EOL, FILE_APPEND);
            }
            if($user_chatbot->user_sub_function($user_id) == "weather_hour"){
                $jsons = array(
                    "replyToken" => $token, 
                    "messages" => [
                        [
                            "type" => "flex", 
                            "altText" => "this is a flex message", 
                            "contents" => [
                                "type" => "bubble", 
                                "body" => [
                                "type" => "box", 
                                "layout" => "vertical", 
                                "contents" => [
                                    [
                                            "type" => "button", 
                                            "action" => [
                                                "type" => "postback", 
                                                "label" => "3ชั่วโมงล่วงหน้า", 
                                                "data" => '{"lat" : '.$lat.', "lon" : '.$lon.', "duration" : 3, "date" : "'.$day.'", "type" : "hour", "functions" : "weather"}'
                                            ], 
                                            "color" => "#ff0000", 
                                            "style" => "primary" 
                                    ], 
                                    [
                                            "type" => "button", 
                                            "action" => [
                                                "type" => "postback", 
                                                "label" => "6ชั่วโมงล่วงหน้า", 
                                                "data" => '{"lat" : '.$lat.', "lon" : '.$lon.', "duration" : 7, "date" : "'.$day.'", "type" : "hour", "functions" : "weather"}'
                                            ], 
                                            "color" => "#ffdc00", 
                                            "style" => "primary" 
                                    ], 
                                    [
                                            "type" => "button", 
                                            "action" => [
                                            "type" => "postback", 
                                            "label" => "9ชั่วโมงล่วงหน้า", 
                                                "data" => '{"lat" : '.$lat.', "lon" : '.$lon.', "duration" : 10, "date" : "'.$day.'", "type" : "hour", "functions" : "weather"}'
                                            ], 
                                            "color" => "#bad9ef", 
                                            "style" => "primary" 
                                    ] 
                                ] 
                                ] 
                            ] 
                        ] 
                    ] 
                );
                $results = $send_line_json->sendMessageOnJson(json_encode($jsons));
                file_put_contents('logerror.txt', $results . PHP_EOL, FILE_APPEND);
            }
            
            $resultss = $user_chatbot->user_sub_function($user_id);
            file_put_contents('logerror.txt', $resultss . PHP_EOL, FILE_APPEND);
        }else{
            $msg = new TextMessageBuilder('คุณไม่ได้สมัครสมาชิก เพื่อใช้ chatbot');
            $bot->replyMessage($token, $msg);
        }

    }
}
if($type == 'postback'){

    //reply token
    $token = $data_json['events'][0]['replyToken'];

    //ดึงข้อมูลจาก postback
    $postback_data = str_replace("\\", "", $data_json['events'][0]['postback']['data']);
    file_put_contents('logpostback.txt', $postback_data . PHP_EOL, FILE_APPEND);

    
    $get_json = json_decode($postback_data,true);
    $get_function = $get_json['functions'];
    if($get_function == "weather"){

        //ดึงพิกัด
        $lat = $get_json['lat'];
        $lon = $get_json['lon'];

        //get type of weather
        $type_weather = $get_json['type'];

        //ดึงจำนวนกการพยากรณ์
        $duration = $get_json['duration'];

        //ดึงวันที่ล่าสุด
        $date = $get_json['date'];
        $hour_weather = date("H");
        if($type_weather == "day"){

            $get_weather = $weater_api->Day_Weather($lat, $lon, $date, $hour, $duration);
            file_put_contents('logweather.txt', $get_weather . PHP_EOL, FILE_APPEND);

            //ดึงข้อมูลเรียงวัน
            $weather_json = json_decode($get_weather,true);
            $weather_data = $weather_json["WeatherForecasts"][0]['forecasts'];

            $reply_weather = array(
                "replyToken" => $token, 
                "messages" => [
                    [
                         "type" => "flex", 
                         "altText" => "ข้อมูลการพยากรณ์อากาศ", 
                         "contents" => [
                            "type" => "bubble", 
                            "header" => [
                               "type" => "box", 
                               "layout" => "vertical", 
                               "contents" => [
                                  [
                                     "type" => "text", 
                                     "text" => "พยากรณ์อากาศรายวัน", 
                                     "weight" => "bold", 
                                     "align" => "center", 
                                     "gravity" => "top", 
                                     "size" => "lg", 
                                     "margin" => "xs" 
                                  ] 
                               ], 
                               "backgroundColor" => "#99d4ff", 
                               "cornerRadius" => "sm", 
                               "paddingAll" => "lg", 
                               "offsetTop" => "none" 
                            ], 
                            "body" => [
                                        "type" => "box", 
                                        "layout" => "vertical", 
                                        "contents" => [] 
                                     ], 
                            "styles" => [
                                            "header" => [
                                                            "separator" => true 
                                            ] 
                                        ] 
                        ] 
                    ] 
                ] 
            );
            
            $day = date("Y-m-d");

            //loop เพื่อส่งเป็นข้อความ
            $i = 0;
            foreach($weather_data as $weather_loop){

                $tomorrow = date('d / m / Y',strtotime($day . "+$i days"));

                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["type"] = "box";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["layout"] = "vertical";

                //วันที่
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["text"] = "วันที่".$tomorrow;
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["weight"] = "bold";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["size"] = "md";

                //สภาพอากาศ
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][1]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][1]["text"] = "สภาพอากาศ ".$weater_api->Cond_to_text($weather_loop["data"]["cond"]);

                //ปริมาณฝนสะสม
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][2]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][2]["text"] = "ปริมาณฝน ".$weather_loop["data"]["rain"]." มิลลิเมตร";

                //อุณหภมูิต่ำสุด
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][3]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][3]["text"] = "อุณหภูมิต่ำสุด ".$weather_loop["data"]["tc_min"]." องศา";

                //อุณหภมูิสูงสุด
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][4]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][4]["text"] = "อุณหภูมิสูงสุด ".$weather_loop["data"]["tc_max"]." องศา";

                //ขีดใต้
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][5]["type"] = "separator";

                $i++;
            }

            $results = $send_line_json->sendMessageOnJson(json_encode($reply_weather));
            file_put_contents('logerror.txt', json_encode($reply_weather) . $results . PHP_EOL, FILE_APPEND);

        }
        if($type_weather == "hour"){

            $get_weather = $weater_api->Hour_Weather($lat, $lon, $date, $hour_weather, $duration);
            file_put_contents('logweather.txt', $get_weather . PHP_EOL, FILE_APPEND);

            //ดึงข้อมูลเรียงวัน
            $weather_json = json_decode($get_weather,true);
            $weather_data = $weather_json["WeatherForecasts"][0]['forecasts'];

            $day = date("d / m / Y");

            $reply_weather = array(
                "replyToken" => $token, 
                "messages" => [
                    [
                         "type" => "flex", 
                         "altText" => "ข้อมูลการพยากรณ์อากาศ", 
                         "contents" => [
                            "type" => "bubble", 
                            "header" => [
                               "type" => "box", 
                               "layout" => "vertical", 
                               "contents" => [
                                  [
                                     "type" => "text", 
                                     "text" => "พยากรณ์อากาศรายชั่วโมง", 
                                     "weight" => "bold",  
                                     "gravity" => "top", 
                                     "size" => "lg", 
                                     "margin" => "xs" 
                                  ],
                                  [
                                    "type" => "text", 
                                    "text" => "วันที่ ".$day
                                  ] 
                               ], 
                               "backgroundColor" => "#99d4ff", 
                               "cornerRadius" => "sm", 
                               "paddingAll" => "lg", 
                               "offsetTop" => "none" 
                            ], 
                            "body" => [
                                        "type" => "box", 
                                        "layout" => "vertical", 
                                        "contents" => [] 
                                     ], 
                            "styles" => [
                                            "header" => [
                                                            "separator" => true 
                                            ] 
                                        ] 
                        ] 
                    ] 
                ] 
            );
            
            $Hour = date("H");

            //loop เพื่อส่งเป็นข้อความ
            $i = 0;
            foreach($weather_data as $weather_loop){

                $next_hours = date('H', strtotime("+$i hours"));

                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["type"] = "box";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["layout"] = "vertical";

                //วันที่
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["text"] = "เวลา ".$next_hours.".00น";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["weight"] = "bold";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][0]["size"] = "md";

                //สภาพอากาศ
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][1]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][1]["text"] = "สภาพอากาศ ".$weater_api->Cond_to_text($weather_loop["data"]["cond"]);

                //ปริมาณฝนสะสม
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][2]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][2]["text"] = "ปริมาณฝน ".$weather_loop["data"]["rain"]." มิลลิเมตร";

                //อุณหภมูิ
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][3]["type"] = "text";
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][3]["text"] = "อุณหภูมิ ".$weather_loop["data"]["tc"]." องศา";

                //ขีดใต้
                $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][4]["type"] = "separator";

                $i++;
            }

            $results = $send_line_json->sendMessageOnJson(json_encode($reply_weather));
            file_put_contents('logerror.txt', json_encode($reply_weather) . $results . PHP_EOL, FILE_APPEND);

        }
    }

}

?>
