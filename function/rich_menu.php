<?php
namespace KRTStudio\Function;

include_once($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;

use LINE\LINEBot\RichMenuBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBoundsBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuAreaBuilder;
use LINE\LINEBot\RichMenuBuilder\RichMenuSizeBuilder;

use LINE\LINEBot\Event\Things\ThingsResultAction;

use KRTStudio\Function\Config;

class RichMenu {

    private $rAction;

    public function create_richmenu_generic ($mname,$mchatbar,$mimage,$nrow,$ncol,$textList){
        $height = 1686;
        $width = 2500;
        $sizeBuilder = new RichMenuSizeBuilder($height, $width);
        $selected = false;
        $rich_name = $mname;
        $rich_chatBarText = $mchatbar;
        $xstep = $width / $ncol;
        $ystep = $height / $nrow;
        $nitem = $nrow * $ncol;
        $areaList = [];
        for ($i = 0; $x <= $nrow; $i++) {
            $y = $ystep*$x;
            for ($j = 0; $x <= $ncol; $j++) {
                $x = $xstep*$j;
                $rbound = new RichMenuAreaBoundsBuilder($x,$y,$xstep,$ystep);
                $actionComp = $textList[$ncol*$i+$j];
                if (str_contains($actionComp, '://')){
                    $this->rAction = new ThingsResultAction('uri', $actionComp);
                } else {
                    $this->rAction = new ThingsResultAction('message', $actionComp);
                }
                $ar = new RichMenuAreaBuilder($this->rAction, $rbound);

                $areaList = array_push($areaList, $ar);
            }
        }
        $rich_menu = new RichMenuBuilder($sizeBuilder, $selected, $rich_name, $rich_chatBarText, $areaList);
        $menuId = $line_bot_api->createRichMenu($rich_menu);
        $contentType = 'image/jpeg';
        $img = fopen($mimage,'rb');
        $line_bot_api->uploadRichMenuImage($menuId,$img,$contentType);

        return $menuId;
    }

    public function add_richmenu ($mname,$mchatbar,$mimage,$nrow,$ncol,$textList) {
        $config = new Config();
        $menu_id = $this->create_richmenu_generic($mname,$mchatbar,$mimage,$nrow,$ncol,$textList);

        $conn = new \mysqli($config->DataBase('host'), $config->DataBase('user'), $config->DataBase('password'), $config->DataBase('database'));
        $conn->query("INSERT INTO rich_menu (name, rich_id, image, row, col, textList) VALUES ($mname, $menu_id, $mimage, $nrow, $ncol, $textList)");
        $conn->close();

        return $menu_id;
    }

    public function postmenu($id,$line_id){
        $config = new Config();
        $httpClient = new CurlHTTPClient($config->BotLine('channel_access'));
        $bot = new LINEBot($httpClient, ['channelSecret' => $config->BotLine('channel_secret')]);
        $bot->linkRichMenu($line_id,$id);
        return 'done';

    }
}
?>