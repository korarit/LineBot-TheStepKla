<?php
namespace KRTStudio\Function;
include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');

use voku\helper\HtmlDomParser;
use voku\helper\UTF8;

class Market {

    public function search_data ($search) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://cms.talaadthai.com/wp-json/tlt/v1/product_search?q=".$search."&per_page=1&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authority: cms.talaadthai.com",
            "sec-ch-ua-platform: 'Windows'",
            "origin: https://www.talaadthai.com",
            "referer: https://www.talaadthai.com/",
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

    public function search_data_num ($search) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://cms.talaadthai.com/wp-json/tlt/v1/product_search?q=".$search."&per_page=1&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authority: cms.talaadthai.com",
            "sec-ch-ua-platform: 'Windows'",
            "origin: https://www.talaadthai.com",
            "referer: https://www.talaadthai.com/",
        ),
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response["max_num_pages"];
        }
    }

    public function get_data ($subcat, $amount) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://cms.talaadthai.com/wp-json/tlt/v1/products_from_subcat_id?id=".$subcat."&per_page=".$amount."&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authority: cms.talaadthai.com",
            "sec-ch-ua-platform: 'Windows'",
            "origin: https://www.talaadthai.com",
            "referer: https://www.talaadthai.com/",
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

    public function get_num_page ($subcat, $amount) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://cms.talaadthai.com/wp-json/tlt/v1/products_from_subcat_id?id=".$subcat."&per_page=".$amount."&page=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "accept: application/json",
            "authority: cms.talaadthai.com",
            "sec-ch-ua-platform: 'Windows'",
            "origin: https://www.talaadthai.com",
            "referer: https://www.talaadthai.com/",
        ),
        ));

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response["max_num_pages"];
        }
    }

}
?>