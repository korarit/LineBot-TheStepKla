<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');

use KRTStudio\Function\Config;

$config = new Config();

$logo = ["PTT" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_1.png",
        "Bangchak" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_2-2.png",
        "Shell" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_3.png",
        "ESSO" => "	http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_4.png",
        "CALTEX" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_5.png",
        "IRPC" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_6.png",
        "PT" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_7.png",
        "SUBCO" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_8.png",
        "PURE" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_9.png",
        "SUBCO_2" => "http://www.eppo.go.th/epposite/templates/eppo_v15_mixed/images/oil-content/oil_10.png"];

$text_station = ["PTT" => "PTT","Bangchak" => "Bangchak","Shell" => "Shell","ESSO" => "ESSO","CALTEX" => "CALTEX","IRPC" => "IRPC","PT" => "PT","SUBCO" => "SUBCO","PURE" => "PURE","SUBCO_2" => "SUBCO"];

$data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/oil_price.json'), true);
//echo ($data[$_GET["gas_station"]]["gasoline_95"]);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ราคาน้ำมัน</title>

         <!-- line liff-->
         <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>

         <!-- jquery -->
         <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
 
         <!-- CSS bootstrap only -->
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
         <!-- JavaScript bootstrap Bundle with Popper -->
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
         
         <!-- sweert alert-->
         <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
         <style>
            .center_box{
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            body {
                background-image: url(https://images.unsplash.com/photo-1555231955-348aa2312e19?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }

        </style>
        <script>
            async function main (){
                await liff.init({ liffId: "<?php echo $config->Liff("oil"); ?>" });
            }
            main();

            function Check_OS (){
                if(liff.getOS() == "web") {
                        swal("กรุณาใช้ line โทรศัพท์มือถือ!", "เนื่องระบบทำมาสำหรับโทรศัพท์!", "error");
                        liff.closeWindow();
                }
            }

    
        </script>
    </head>
    <body>
        <div class="center_box">
            <div class="card text-bg-dark mb-3" style="width: 30rem;">
                <div class="card-header">
                    <center><h3 style="display: inline;">ราคาน้ำมัน</h3>&nbsp;&nbsp;<img style="display: inline;" height="30px" src="<?php echo $logo[$_GET["gas_station"]]; ?>"></center>
                </div>
                <div class="card-body">
                    <table class="table table-dark table-striped text-center">
                        <thead>
                          <tr>
                            <th scope="col">ประเภท</th>
                            <th scope="col">ราคา</th>
                          </tr>
                        </thead>
                        <tbody>
                            <?php

                            $name_oil = ["gasoline_95","Gasohol_91","E85","Diesel","B7_Pro","gasohol_95","E20","Diesel_B7","Diesel_B20", ""];
                            $text_oil = ["น้ำมันเบนซิน 95","แก๊สโซฮอล์ 91","เบนซิน E85","ดีเซล","ดีเซล B7 พรีเมียม","แก๊สโซฮอล์ 95","เบนซิน E20","ดีเซล B7","ดีเซล B20", ""];

                            $i = 0;
                            foreach ($data[$_GET["gas_station"]] as $item){
                                if($i < 9){
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $text_oil[$i];?></th>
                                    <th><?php echo $item;?> บาท</th>
                                </tr>
                            <?php
                                }
                            $i++;
                            }
                            ?>
                        </tbody>                         
                      </table>
                </div>
                <div class="card-footer">
                    <h5>มีผลบังคับใช้ตั้งแต่ <?php echo $data[$_GET["gas_station"]]["DATE_USE"]; ?></h5>
                </div>
                <div>
                </div>
            </div>
        </div>
    </body>
</html>