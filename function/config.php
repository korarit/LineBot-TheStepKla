<?php
namespace KRTStudio\Function;

class Config {

    //DataBase
    public function DataBase(string $get){
        $config['host'] = "127.0.0.1";
        $config['user'] = "root";
        $config['password'] = "";
        $config['database'] = "chatbot_thestepkla";

        return $config[$get];
    }

    public function BotLine(string $get){
        $config['channel_access'] = "";
        $config['channel_secret'] = "";

        return $config[$get];
    }

    public function Config (string $get){
        $config['Key_tmd'] = "";

        return $config[$get];
    }

    //สำหรับการแสดงผลผ่าน liff
    public function Liff (string $get){
        $config["lottery"] = "";

        return $config[$get];
    }
}
?>
