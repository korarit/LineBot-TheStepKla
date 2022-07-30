<?php
namespace KRTStudio\Function\Delivery;

class Flash {

    public function get_dataflash($code){
        $url = "https://www.flashexpress.co.th/tools/get-route/";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
        "Content-Type: application/json;charset=utf-8"
        );
        $data = array("search" => $code);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    public function get_state($code){
        $json = get_dataflash($code);
        $data = json_decode($json);

        $state = $data['message']['list'][0]['state_text'];

        return $state;

    }

    public function get_routes($code){
        $json = get_dataflash($code);
        $data = json_decode($json);

        $routes = $data['message']['list'][0]['routes'];

        return $routes;
    }
}

class Kerry {

    public function get_datakerry(string $code){
        $url = "https://th.kerryexpress.com/th/track/?track=YTJkYTAyMjFhZTQzMWY5OWViYTkyNjg1MjI2YTI4MzJmSHg4ZGRiNGEyNjNlNjY1MmRhNmY3OTI1MjQyZjkyOTE3ZTVmSHg4U0hQNTEyMTUwODkyMmZIeDg3YTlhZmQzNTNkNjFhZDA2YWZhMTMyNmQwNmQzZGQyYWZIeDhhNjc4NzE2OTZhNjlhZGViNjYyMGJkM2Q3OTM2MTc2MQ%253D%253D";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "accept: application/json",
            "Content-Type: application/json",
            "kett-lang: th",
            "origin: https://th.kerryexpress.com",
            "referer: https://th.kerryexpress.com/th/track/v2/?track=MjM2MzdhNzEyMmI1NzJiMmNkMWMyNDExNzBjZjJjZTdmSHg4NTc3ZjRmM2QzZmY5NmMxZDFiZDdhYjc0OTJhOTU0ZTNmSHg4U0hQNTEyMTUwODkyMmZIeDhhMWFhYjg0ZWQ5ZDYwYTAzYjU0ZGQwOTQzZDE3N2NhY2ZIeDg0ZGIzZDkwOGRhNzAwODg5MGE5NjYyMjExMWUxYmMzNA%253D%253D",
            "accept-language: th,en;q=0.9,en-GB;q=0.8,en-US;q=0.7",
            "content-length: 31",
            "sec-ch-ua-platform: 'Windows'",
            "sec-ch-ua-mobile: ?0",
            "sec-ch-ua: ' Not A;Brand';v='99', 'Chromium';v='101', 'Microsoft Edge';v='101'",
        );
        $data = array("tracking_no" => $code);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }

    public function get_lastcode(string $code){
        $json = get_datakerry($code);
        $data = json_decode($json);

        $idx = $data['icon']['current_idx'];

        return $idx;
    }

    public function get_code(string $code){
        $json = get_datakerry($code);
        $data = json_decode($json);

        $code = $data['icon']['display'];

        return $code;
    }

    public function get_status(string $code){
        $json = get_datakerry($code);
        $data = json_decode($json);

        $routes = $data['ref']['shipment_status'];

        return $routes;
    }
}

class best {
    public function get_data ($code){
        $curl = curl_init();

        $data = array("expressids" => $code, "picverifycode" => "");

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.best-inc.co.th/express/expresslistinfo',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>  json_encode($data),
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'content-type: application/x-www-form-urlencoded',
            'accept-language: th,en;q=0.9,en-GB;q=0.8,en-US;q=0.7'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
?>