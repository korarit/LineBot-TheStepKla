<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/function/config.php');

use KRTStudio\Function\Config;

$config = new Config();

$data = json_decode(file_get_contents("https://api.exchangerate.host/symbols"), true);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>อัตราแลกเปลี่ยน</title>
        <link rel="icon" href="https://iconape.com/wp-content/files/wd/369553/svg/money-logo-icon-png-svg.png" type="image/x-icon">

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

         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>

         <style>
            .center_box{
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            body {
                background-image: url(https://cdn.wallpapersafari.com/97/50/eRwDMy.jpg);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }

        </style>
        <script>
            //เรียกใช้ line liff
            async function main (){
                await liff.init({ liffId: "<?php echo $config->Liff("oil"); ?>" });
            }
            main();

            //ตรวจสอบว่าใช้ ios android หรือ เว็ป
            function Check_OS (){
                if(liff.getOS() == "web") {
                        swal("กรุณาใช้โทรศัพท์มือถือ!", "เนื่องระบบทำมาสำหรับโทรศัพท์!", "error");
                        liff.closeWindow();
                }
            }
        
        //function สำหรับดึงข้อมูลจาก API
        function GetRate(Rate1, Rate2, data) {
            var requestURL = 'https://api.exchangerate.host/convert?from='+Rate1+'&to='+Rate2;
            var request = new XMLHttpRequest();
            request.open('GET', requestURL);
            request.responseType = 'json';
            request.send();

            request.onload = function() {
               document.cookie = "exchangerate="+request.response.result+";";
               console.log(request.response.result);
            }
        }

        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }
            return "";
        }


        //ดึงสกุลเงินที่ 1 แล้วแปลงเป็นสกุลที่2
        function getForeign1(){
            //ดึงสกุลเงิน
            let Rate1 = document.getElementById("Rate1").value;
            let Rate2 = document.getElementById("Rate2").value;

            

            //ดึงจำนวน
            let Amount1 = document.getElementById("Amount1").value;

            //ดึงข้อมูลจาก API
            let datas = GetRate(Rate1, Rate2, 1);
            let data = getCookie("exchangerate");

            //คำนวณ
            var exchange = Amount1*data;
            console.log(data);
            document.getElementById("Amount2").value = exchange;
            document.cookie = "exchangerate=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        }
        //ดึงสกุลเงินที่ 2 แล้วแปลงเป็นสกุลที่1
        function getForeign2(){
            //ดึงสกุลเงิน
            let Rate1 = document.getElementById("Rate1").value;
            let Rate2 = document.getElementById("Rate2").value;

            //ดึงจำนวน
            let Amount2 = document.getElementById("Amount2").value;

            //ดึงข้อมูลจาก API
            let datas = GetRate(Rate1, Rate2, 2);
            let data = getCookie("exchangerate");

            //คำนวณ
            var exchange = Amount2*data;
            console.log(data);
            document.getElementById("Amount1").value = exchange;
            document.cookie = "exchangerate=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        }

        //ดึงจำนวนเงินของสกุลเงินที่ 1 แล้วแปลงเป็นสกุลที่2
        function get_amount1(){
            //ดึงสกุลเงิน
            let Rate1 = document.getElementById("Rate1").value;
            let Rate2 = document.getElementById("Rate2").value;

            //ดึงจำนวน
            let Amount1 = document.getElementById("Amount1").value;

            //ดึงข้อมูลจาก API
            let datas = GetRate(Rate1, Rate2, 1);
            let data = getCookie("exchangerate");

            //คำนวณ
            let exchange = (Amount1*data);
            console.log(data);
            document.getElementById("Amount2").value = exchange;
            document.cookie = "exchangerate=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        }

        //ดึงจำนวนเงินของสกุลเงินที่ 2 แล้วแปลงเป็นสกุลที่ 1
        function get_amount2(){
            //ดึงสกุลเงิน
            let Rate1 = document.getElementById("Rate1").value;
            let Rate2 = document.getElementById("Rate2").value;

            //ดึงจำนวน
            let Amount2 = document.getElementById("Amount2").value;

            //ดึงข้อมูลจาก API
            let datas = GetRate(Rate2, Rate1, 2);
            let data = getCookie("exchangerate");

            
            //คำนวณ
            var exchange = Amount2*data;
            console.log(data);
            document.getElementById("Amount1").value = exchange;
            document.cookie = "exchangerate=; expires=Thu, 01 Jan 1970 00:00:00 UTC";
        }
        $(document).ready(function(){
            $("#Amount1").on("input", function(){
                // Print entered value in a div box
                get_amount1();
            });
            $("#Amount2").on("input", function(){
                // Print entered value in a div box
                get_amount2();
            });
            $(function () {
                $('select').selectpicker();
            });
        });
        </script>
    </head>
    <body onload="Check_OS()">
        <div class="center_box">
            <div class="card text-bg-dark mb-3" style="width: 30rem;">
                <div class="card-header">
                    <center><h4 style="display: inline;">อัตราแลกเปลี่ยนเงินระหว่างประเทศ</h4></center>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input id="Amount1" value="10" type="number" aria-label="First name" class="form-control">&nbsp;

                        <input id="Rate1" onchange="getForeign1()" class="form-control" list="datalistOptions1" placeholder="เลือกสกุลเงิน....">
                        <datalist id="datalistOptions1">
                            <?php
                            foreach($data["symbols"] as $item){
                                echo '<option value="'.$item["code"].'">'.$item["code"].'</option>';
                            }
                            ?>
                        </datalist>
                    </div>
                    <hr>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input id="Amount2" type="number" aria-label="First name" class="form-control">&nbsp;

                        <input id="Rate2" onchange="getForeign2()" class="form-control" list="datalistOptions2" placeholder="เลือกสกุลเงิน....">
                        <datalist id="datalistOptions2">
                            <option selected>เลือกสกุลเงิน</option>
                            <?php
                            foreach($data["symbols"] as $item){
                                echo '<option value="'.$item["code"].'">'.$item["code"].'</option>';
                            }
                            ?>
                        </datalist>
                    </div>
                </div>
                <div class="card-footer">
                    ข้อมูลจาก https://exchangerate.host/
                </div>
                <div>
                </div>
            </div>
        </div>
    </body>
</html>