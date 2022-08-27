<?php
include($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
include($_SERVER['DOCUMENT_ROOT'].'/function/market.php');

use KRTStudio\Function\Market;

$api = new Market();
?>
<html>
    <head>
        <title>Market Lift</title>
        <!-- bootstarp -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>

        <!-- jquery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
         <!-- line liff-->
         <script src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>

        <!-- jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <!-- css -->
        <style>
            .center_box{
                position: fixed;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }

            body {
                background-image: url(https://c.wallhere.com/photos/1f/4a/field_lettuce_cultivation_vegetables-559734.jpg!d);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
        <script>
            function getDataform(){
                
            }
        </script>
    </head>
    <body>
    <center><hr style="width: 40rem"></center>
            <div class="row d-flex justify-content-center">
                <div class="input-group mb-3" style="width: 30rem;">
                    <input style="width: 10rem;" type="text" class="form-control" placeholder="ค้นหา" aria-label="ค้นหา" aria-describedby="button-addon2">
                    <button class="btn btn-secondary" type="button" id="button-addon2">ค้นหา</button>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="card text-bg-dark mb-3" style="width: 40rem;">
                    <div class="card-header text-center"><h4>ราคาสินค้า</h4></div>
                    <div class="card-body">
                        <table class="table table-dark">
                            <thead>
                                <tr>
                                <th scope="col"><center>สินค้า</center></th>
                                <th scope="col"><center>ราคา</center></th>
                                <th scope="col"><center>เวลาข้อมูล</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                <th scope="row"><center>1</th>
                                <td><center>Otto</center></td>
                                <td><center>@mdo</center></td>
                                </tr>
                                <tr>
                                <th scope="row"><center>2</th>
                                <td><center>Thornton</center></td>
                                <td><center>@fat</center></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="card-footer">
                        ข้อมูลจาก : <a href="https://www.talaadthai.com" target="_blank">https://www.talaadthai.com/</a>
                    </div>
                </div>
            </div>
    </body>
</html>