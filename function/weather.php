<?php
namespace KRTStudio\Function;

include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');

use KRTStudio\Function\Config;

class Weather {

    public function Day_Weather ($lat, $lon, string $date, $hour, $duration) {
        $configs = new Config();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/at?lat=".$lat."&lon=".$lon."&fields=tc_min,tc_max,rain,cond&date=".$date."&duration=".$duration,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer ". $configs->Config("Key_tmd"),
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function Day_Area_Weather ($province, $amphoe, $tambon, string $date, $duration) {
        $configs = new Config();
        $curl = curl_init();

        $url = null;

        //เอาตำบล
        if($province != "" && $amphoe != "" && $tambon != ""){
            $url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/place?province=$province&amphoe=$amphoe&tambon=$tambon&fields=tc_max,tc_min,rh,rain,cond&date=$date&duration=$duration";
        }
        //ไม่เอาตำบล
        elseif($province != "" && $amphoe != "" && $tambon == ""){
            $url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/place?province=$province&amphoe=$amphoe&fields=tc_max,tc_min,rh,rain,cond&date=$date&duration=$duration";
        }
        //ไม่เอาตำบล และ อำเภอ
        elseif($province != "" && $amphoe == "" && $tambon == ""){
            $url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/place?province=$province&fields=tc_max,tc_min,rh,rain,cond&date=$date&duration=$duration";
        }

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer ". $configs->Config("Key_tmd"),
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function Hour_Weather ($lat, $lon, string $date, $hour, $duration) {
        $configs = new Config();
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/at?lat=".$lat."&lon=".$lon."&fields=tc,rain,cond&date=".$date."&hour=".$hour."&duration=".$duration,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer ".$configs->Config("Key_tmd"),
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function Hour_Area_Weather ($province, $amphoe, $tambon, string $date, $hour, $duration) {
        $configs = new Config();
        $curl = curl_init();

        $url = null;
        //เอาตำบล
        if($province != "" && $amphoe != "" && $tambon != ""){
            $url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/place?province=$province&amphoe=$amphoe&tambon=$tambon&fields=tc,rh,rain,cond&date=$date&hour=$hour&duration=$duration";
        }
        //ไม่เอาตำบล
        elseif($province != "" && $amphoe != "" && $tambon == ""){
            $url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/place?province=$province&amphoe=$amphoe&fields=tc,rh,rain,cond&date=$date&hour=$hour&duration=$duration";
        }
        //ไม่เอาตำบล และ อำเภอ
        elseif($province != "" && $amphoe == "" && $tambon == ""){
            $url = "https://data.tmd.go.th/nwpapi/v1/forecast/location/hourly/place?province=$province&fields=tc,rh,rain,cond&date=$date&hour=$hour&duration=$duration";
        }

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authorization: Bearer ".$configs->Config("Key_tmd"),
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function Cond_to_text ($cond) {
        if($cond == 1){
            return 'ท้องฟ้าแจ่มใส';
        }
        if($cond == 2){
            return 'มีเมฆบางส่วน';
        }
        if($cond == 3){
            return 'เมฆเป็นส่วนมาก';
        }
        if($cond == 4){
            return 'มีเมฆมาก';
        }
        if($cond == 5){
            return 'ฝนตกเล็กน้อย';
        }
        if($cond == 6){
            return 'ฝนปานกลาง';
        }
        if($cond == 7){
            return 'ฝนตกหนัก';
        }
        if($cond == 8){
            return 'ฝนฟ้าคะนอง';
        }
        if($cond == 9){
            return 'อากาศหนาวจัด';
        }
        if($cond == 10){
            return 'อากาศหนาว';
        }
        if($cond == 11){
            return 'อากาศเย็น';
        }
        if($cond == 12){
            return 'อากาศร้อนจัด';
        }
    }
}

class Weather_Message {
    public function Day_Message($weather, $token) {

        $weather_api = new Weather();
        
        //ดึงข้อมูลพยากรณ์อากาศ
        $weather_json = json_decode($weather,true);
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
            $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][1]["text"] = "สภาพอากาศ ".$weather_api->Cond_to_text($weather_loop["data"]["cond"]);

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

        return json_encode($reply_weather);
    }

    public function Hour_Message($weather, $token){

        $weather_api = new Weather();

        //ดึงข้อมูลเรียงวัน
        $weather_json = json_decode($weather,true);
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
            $reply_weather["messages"][0]["contents"]["body"]["contents"][$i]["contents"][1]["text"] = "สภาพอากาศ ".$weather_api->Cond_to_text($weather_loop["data"]["cond"]);

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

        return json_encode($reply_weather);
    }
}
?>