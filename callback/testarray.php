<?php
$reply_weather = array(
    "replyToken" => 10, 
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
                         "text" => "พยากรณ์อากาศ", 
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
                            "contents" => [
                               [
                                  "type" => "box", 
                                  "layout" => "vertical", 
                                  "contents" => [
                                    [
                                        "type" => "text", 
                                        "text" => "วันที่", 
                                        "weight" => "bold", 
                                        "size" => "md" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "สภาพอากาศ" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "ปริมาณฝน" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "อุณหภูมิต่ำสุด" 
                                    ], 
                                    [
                                        "type" => "text", 
                                        "text" => "อุณหภูมิสูงสุด" 
                                    ], 
                                    [
                                        "type" => "separator" 
                                    ] 
                                  ] 
                                ], 
                                [
                                    "type" => "box", 
                                    "layout" => "vertical", 
                                    "contents" => [
                                    ] 
                                ] 
                            ] 
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

print_r($reply_weather);
?>