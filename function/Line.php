<?php
namespace KRTStudio\Function\Line;

include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');

use KRTStudio\Function\Config;

class LineMessage {
    
    function sendMessageOnJson($replyJson){
        $config = new Config();

        $ch = curl_init("https://api.line.me/v2/bot/message/reply");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $config->BotLine('channel_access'))
            );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function Create_richMenu($replyJson){
        $config = new Config();

        $ch = curl_init("https://api.line.me/v2/bot/richmenu");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $config->BotLine('channel_access'))
            );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $replyJson);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function upload_richMenu($image, $rich_id){
        $config = new Config();

        $ch = curl_init("https://api.line.me/v2/bot/richmenu/".$rich_id."/content");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: image/png',
            'Authorization: Bearer ' . $config->BotLine('channel_access'))
            );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $image);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}

?>