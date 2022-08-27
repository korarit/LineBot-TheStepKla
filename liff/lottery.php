<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');

use KRTStudio\Function\Config;

$config = new Config();
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ตรวจหวย</title>

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
        <!-- css -->
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
                await liff.init({ liffId: "<?php echo $config->Liff("lottery"); ?>" });
            }
            main();

            function Check_OS (){
                if(liff.getOS() == "web") {
                    swal("กรุณาใช้ line โทรศัพท์มือถือ!", "ระบบทำมาสำหรับโทรศัพท์!", "error");
                    liff.closeWindow();
                }
            }
            
            async function send_lottery(number, date){
                liff.sendMessages([
                        {
                        type: "text",
                        text: "checklottery_ตรวจสลากรัฐบาล,"+number+","+date,
                        },
                ]).then(() => {
                    liff.closeWindow();
                });
            }

            function get_form(){
                let date = document.getElementById("date_lottery_select").value;
                let number = document.getElementById("lottery_number_input").value;
                send_lottery(number, date);
                //document.getElementById("valueInput").innerHTML = date+" , "+number;
            }

        </script>
    </head>
    <body onload="Check_OS()">
        <div class="center_box">
            <div class="card text-bg-light mb-3" style="width: 35rem;height: 25rem;">
                <div class="card-header text-center"><h5>ตรวจสลากกินแบ่งรัฐบาล</h5></div>
                <div class="card-body">

                    <div class="center_box">
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <select class="form-select form-select-lg mb-3" aria-label=".form-select-lg example" style="width: 400px; height:50px;" id="date_lottery_select">
                                    <?php
                                        $data = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'].'/api/json/date_lottery.json'), true);
                                        foreach($data["date"] as $item){
                                            echo '<option value="'.$item[1].'">'.$item[0].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
            
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="mb-3">
                                    <input maxlength="6" type="text" class="form-control form-control-lg" id="lottery_number_input" placeholder="หมายเลขสลากกินแบ่งรัฐบาล" style="width: 400px;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-grid gap-2 col-8 mx-auto">
                                <button type="button" onclick="get_form()" class="btn btn-outline-dark btn-lg">ตรวจสลากกินแบ่งรัฐบาล</button>
                            </div>
                        </div>
                        <div id="valueInput">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    แหล่งที่มา : <a href="https://news.sanook.com/lotto/" target="_blank">https://news.sanook.com/lotto/</a>
                </div>
            </div>
        </div>
    </body>
</html>