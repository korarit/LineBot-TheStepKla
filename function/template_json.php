<?php
namespace KRTStudio\Function;

class Template_json {

    public function main_menu() {
        $jayParsedAry = ([
            "size" => [
                  "width" => 2500, 
                  "height" => 1686 
               ], 
            "selected" => true, 
            "name" => "main menu", 
            "chatBarText" => "เมนูหลัก", 
            "areas" => [
                     [
                        "bounds" => [
                           "x" => 21, 
                           "y" => 8, 
                           "width" => 800, 
                           "height" => 491 
                        ], 
                        "action" => [
                              "type" => "message", 
                              "text" => "function_พยากรณ์อากาศ" 
                           ] 
                     ], 
                     [
                                 "bounds" => [
                                    "x" => 853, 
                                    "y" => 14, 
                                    "width" => 800, 
                                    "height" => 492 
                                 ], 
                                 "action" => [
                                       "type" => "message", 
                                       "text" => "function_ตรวจสอบสถานะพัสดุ" 
                                    ] 
                              ], 
                     [
                                          "bounds" => [
                                             "x" => 1693, 
                                             "y" => 15, 
                                             "width" => 783, 
                                             "height" => 491 
                                          ], 
                                          "action" => [
                                                "type" => "message", 
                                                "text" => "function_ตรวจหวย" 
                                             ] 
                                       ], 
                     [
                                                   "bounds" => [
                                                      "x" => 26, 
                                                      "y" => 577, 
                                                      "width" => 800, 
                                                      "height" => 504 
                                                   ], 
                                                   "action" => [
                                                         "type" => "message", 
                                                         "text" => "function_ราคาน้ำมัน" 
                                                      ] 
                                                ], 
                     [
                                                            "bounds" => [
                                                               "x" => 862, 
                                                               "y" => 591, 
                                                               "width" => 800, 
                                                               "height" => 495 
                                                            ], 
                                                            "action" => [
                                                                  "type" => "message", 
                                                                  "text" => "function_ราคาสินค้าอุปโภค" 
                                                               ] 
                                                         ], 
                     [
                                                                     "bounds" => [
                                                                        "x" => 1685, 
                                                                        "y" => 575, 
                                                                        "width" => 800, 
                                                                        "height" => 504 
                                                                     ], 
                                                                     "action" => [
                                                                           "type" => "message", 
                                                                           "text" => "function_อัตราแลกเปลี่ยนเงินระหว่างประเทศ" 
                                                                        ] 
                                                                  ], 
                     [
                                                                              "bounds" => [
                                                                                 "x" => 17, 
                                                                                 "y" => 1157, 
                                                                                 "width" => 792, 
                                                                                 "height" => 487 
                                                                              ], 
                                                                              "action" => [
                                                                                    "type" => "message", 
                                                                                    "text" => "function_คุณกับchatbot" 
                                                                                 ] 
                                                                           ], 
                     [
                                                                                       "bounds" => [
                                                                                          "x" => 852, 
                                                                                          "y" => 1147, 
                                                                                          "width" => 800, 
                                                                                          "height" => 496 
                                                                                       ], 
                                                                                       "action" => [
                                                                                             "type" => "message", 
                                                                                             "text" => "function_ระบบอื่นๆ" 
                                                                                          ] 
                                                                                    ], 
                     [
                                                                                                "bounds" => [
                                                                                                   "x" => 1697, 
                                                                                                   "y" => 1150, 
                                                                                                   "width" => 783, 
                                                                                                   "height" => 496 
                                                                                                ], 
                                                                                                "action" => [
                                                                                                      "type" => "message", 
                                                                                                      "text" => "function_ผู้พัฒนา" 
                                                                                                   ] 
                                                                                             ] 
                  ] 
        ]); 
 
        return json_encode($jayParsedAry);
    }
    
    public function weather_menu(string $token) {
        $jayParsedAry = array(
        "replyToken" => $token, 
        "messages" => [
                    [
                        "type" => "imagemap", 
                        "baseUrl" => "https://i.imgur.com/Q7mHpmJ.png", 
                        "altText" => "Menu พยากรณ์อากาศ", 
                        "baseSize" => [
                        "width" => 1040, 
                        "height" => 1472 
                        ], 
                        "actions" => [
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 48, 
                                    "y" => 272, 
                                    "width" => 440, 
                                    "height" => 378 
                                ], 
                                "text" => "weathers_พยากรณ์อากาศรายชั่วโมง" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 557, 
                                    "y" => 274, 
                                    "width" => 440, 
                                    "height" => 387 
                                ], 
                                "text" => "weathers_พยากรณ์อากาศรายวัน" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 52, 
                                    "y" => 678, 
                                    "width" => 431, 
                                    "height" => 383 
                                ], 
                                "text" => "weathers_พยากรณ์อากาศรายพื้นที่" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 554, 
                                        "y" => 678, 
                                        "width" => 434, 
                                        "height" => 382 
                                    ], 
                                    "text" => "weathers_พยากรณ์อากาศรายภาค" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 59, 
                                    "y" => 1088, 
                                    "width" => 924, 
                                    "height" => 374 
                                ], 
                                "text" => "weathers_พยากรณ์อากาศทั่วประเทศ" 
                            ] 
                        ] 
                    ] 
                ] 
            ); 
 
        return json_encode($jayParsedAry);
    }

    public function weather_zone_menu(string $token) {
        $jayParsedAry = array(
        "replyToken" => $token, 
        "messages" => [
                [
                        "type" => "imagemap", 
                        "baseUrl" => "https://i.imgur.com/kHREvN1.png", 
                        "altText" => "menu พยากรณ์อากาศรายภาค", 
                        "baseSize" => [
                            "width" => 1040, 
                            "height" => 1472 
                    ], 
                    "actions" => [
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 25, 
                                    "y" => 319, 
                                    "width" => 479, 
                                    "height" => 126 
                                ], 
                                "text" => "forecastzone_ภาคเหนือตอนบน" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 23, 
                                    "y" => 536, 
                                    "width" => 481, 
                                    "height" => 119 
                                ], 
                                "text" => "forecastzone_ภาคเหนือตอนล่าง" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                "x" => 21, 
                                "y" => 782, 
                                "width" => 483, 
                                "height" => 124 
                                ], 
                                "text" => "forecastzone_ภาคตะวันออกเฉียงเหนือตอนบน" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 14, 
                                    "y" => 994, 
                                    "width" => 479, 
                                    "height" => 140 
                                ], 
                                "text" => "forecastzone_ภาคตะวันออกเฉียงเหนือตอนล่าง" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 25, 
                                    "y" => 1239, 
                                    "width" => 479, 
                                    "height" => 136 
                                ], 
                                "text" => "forecastzone_ภาคกลาง" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 556, 
                                    "y" => 312, 
                                    "width" => 452, 
                                    "height" => 149 
                                ], 
                                "text" => "forecastzone_ภาคตะวันออก" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 557, 
                                    "y" => 538, 
                                    "width" => 463, 
                                    "height" => 124 
                                ], 
                                "text" => "forecastzone_ภาคใต้ฝั่งตะวันออกตอนบน" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 556, 
                                    "y" => 760, 
                                "width" => 466, 
                                "height" => 152 
                                ], 
                                "text" => "forecastzone_ภาคใต้ฝั่งตะวันออกตอนล่าง" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 557, 
                                    "y" => 997, 
                                    "width" => 458, 
                                    "height" => 139 
                                ], 
                                "text" => "forecastzone_ภาคใต้ฝั่งตะวันตก" 
                            ], 
                            [
                                "type" => "message", 
                                "area" => [
                                    "x" => 552, 
                                    "y" => 1243, 
                                    "width" => 461, 
                                    "height" => 137 
                                ], 
                                "text" => "forecastzone_กรุงเทพและปริมณฑล" 
                            ] 
                        ] 
                ]
            ]); 
 
 
        return json_encode($jayParsedAry);
    }

    public function weather_country_menu(string $token) {

        $jayParsedAry = array(
          "replyToken" => $token, 
          "messages" => [
                [
                   "type" => "imagemap", 
                   "baseUrl" => "https://i.imgur.com/bRWebpf.png", 
                   "altText" => "This is menu", 
                   "baseSize" => [
                      "width" => 1040, 
                      "height" => 1472 
                   ], 
                   "actions" => [
                        [
                            "type" => "message", 
                            "area" => [
                                "x" => 11, 
                                "y" => 341, 
                                "width" => 495, 
                                "height" => 421 
                            ], 
                            "text" => "weathers_country_radar" 
                        ], 
                        [
                            "type" => "message", 
                            "area" => [
                                "x" => 14, 
                                "y" => 795, 
                                "width" => 490, 
                                "height" => 424 
                            ], 
                            "text" => "weathers_country_rainhard" 
                        ], 
                        [
                            "type" => "message", 
                            "area" => [
                                "x" => 537, 
                                "y" => 339, 
                                "width" => 486, 
                                "height" => 419 
                            ], 
                            "text" => "weathers_country_forecastday" 
                        ], 
                        [
                            "type" => "message", 
                            "area" => [
                                "x" => 538, 
                                "y" => 794, 
                                "width" => 483, 
                                "height" => 425 
                            ], 
                            "text" => "weathers_country_rain_zone" 
                        ] 
                      ] 
                ] 
            ]); 
               
        return json_encode($jayParsedAry);
    }


    public function express_menu(string $token) {
        $jayParsedAry = array(
        "replyToken" => $token, 
        "messages" => [
            [
                "type" => "imagemap", 
                "baseUrl" => "https://i.imgur.com/Lt3Bh00.png", 
                "altText" => "This is an menu", 
                "baseSize" => [
                        "width" => 1040, 
                        "height" => 600 
                    ], 
                "actions" => [
                            [
                            "type" => "uri", 
                            "area" => [
                                "x" => 18, 
                                "y" => 222, 
                                "width" => 295, 
                                "height" => 266 
                            ], 
                            "linkUri" => "https://tmd.go.th" 
                            ], 
                            [
                            "type" => "uri", 
                            "area" => [
                                "x" => 365, 
                                "y" => 222, 
                                "width" => 304, 
                                "height" => 266 
                                ], 
                            "linkUri" => "https://tmd.go.th" 
                            ], 
                            [
                                "type" => "uri", 
                                "area" => [
                                    "x" => 722, 
                                    "y" => 220, 
                                    "width" => 303, 
                                    "height" => 271 
                            ], 
                                "linkUri" => "https://tmd.go.th" 
                            ] 
                        ] 
            ]
        ]); 
 
        return json_encode($jayParsedAry);
    }

    public function lottery_answer($token, $code, $date, $answer){
        $jayParsedAry = array(
            "replyToken" => $token, 
            "messages" => [
                [
                    "type" => "flex", 
                    "altText" => "this is a flex message", 
                    "contents" => [
                    "type" => "bubble", 
                    "size" => "mega", 
                    "header" => [
                            "type" => "box", 
                            "layout" => "vertical", 
                            "contents" => [
                                [
                                "type" => "text", 
                                "text" => "ตรวจสลากกินแบ่งรัฐบาล", 
                                "size" => "xl", 
                                "weight" => "bold", 
                                "align" => "center", 
                                "gravity" => "top", 
                                "offsetTop" => "-8px", 
                                "color" => "#FFFFFF" 
                                ], 
                                [
                                    "type" => "separator", 
                                    "color" => "#FFFFFF", 
                                    "margin" => "none" 
                                ] 
                            ], 
                            "height" => "67px", 
                            "backgroundColor" => "#009EFF" 
                    ], 
                    "body" => [
                            "type" => "box", 
                            "layout" => "vertical", 
                            "contents" => [
                                [
                                "type" => "text", 
                                "text" => "งวดวันที่ : $date", 
                                "size" => "md", 
                                "color" => "#17D900" 
                                ], 
                                [
                                    "type" => "text", 
                                    "text" => "เลขสลาก : $code", 
                                    "size" => "md", 
                                    "color" => "#FFB600" 
                                ], 
                                [
                                    "type" => "text", 
                                    "text" => "ผลการตรวจ : $answer", 
                                    "size" => "md", 
                                    "color" => "#FF8383" 
                                ] 
                            ] 
                        ], 
                    "footer" => [
                                "type" => "box", 
                                "layout" => "vertical", 
                                "contents" => [
                                [
                                    "type" => "separator", 
                                    "margin" => "none" 
                                ], 
                                [
                                    "type" => "text", 
                                    "text" => "ข้อมูลจาก https://news.sanook.com/lotto/", 
                                    "size" => "sm", 
                                    "align" => "center", 
                                    "color" => "#0091FF" 
                                ], 
                                [
                                    "type" => "separator" 
                                ] 
                                ], 
                                    "backgroundColor" => "#E0E0E0" 
                                ] 
                    ]
            ]]); 
 
        return json_encode($jayParsedAry);
    }

    public function oil_menu(string $token) {
        $json = "";
        return json_encode($jayParsedAry);
    }

    public function market_menu(string $token) {
        $json = "";
        return json_encode($jayParsedAry);
    }

    public function exchange_menu(string $token) {
        $json = "";
        return json_encode($jayParsedAry);
    }

    public function developer_menu(string $token) {
        $json = "";
        return json_encode($jayParsedAry);
    }
}
?>