<?php
namespace KRTStudio\Function;

class Config {

    public function DataBase(string $get){
        $config['host'] = "127.0.0.1";
        $config['user'] = "root";
        $config['password'] = "123";
        $config['database'] = "chatbot_thestepkla";

        return $config[$get];
    }

    public function BotLine(string $get){
        $config['channel_access'] = "niompLkqys/F1P6+SNra8o1s7dzq7/3Ucc/vfNw2ESKR5doLdo3XxdavGeqd84IXX38XCy/X2MlH6hljZ+3ABq355iK5scpeWTmTmCdWaH1okViUE+cJctIdFCkgH4a77kXfTSEdbPmGUV4DvUKVtgdB04t89/1O/w1cDnyilFU=";
        $config['channel_secret'] = "f9157d498c895dcd37a14f094b9b3b2f";

        return $config[$get];
    }

    public function Config (string $get){
        $config['Key_tmd'] = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImIyYTFkNjY4M2MwYTBmMzcwNDNhMmNkZTA1ODUyMTliOGZhYjdiMjQzZWYzNDAyMTY2ZGY0MDQ4ZTA3MGVmYzAxNGRlMThmYmYxYTQzM2YyIn0.eyJhdWQiOiIyIiwianRpIjoiYjJhMWQ2NjgzYzBhMGYzNzA0M2EyY2RlMDU4NTIxOWI4ZmFiN2IyNDNlZjM0MDIxNjZkZjQwNDhlMDcwZWZjMDE0ZGUxOGZiZjFhNDMzZjIiLCJpYXQiOjE2Mjg5MzI0MjgsIm5iZiI6MTYyODkzMjQyOCwiZXhwIjoxNjYwNDY4NDI4LCJzdWIiOiI5NTQiLCJzY29wZXMiOltdfQ.WpR-KbNJrJm6rmcWdHHyKG-COOL1bBA_wulgD1o7-5axdOWgNhEKx4TQiUNefXE9MqCtC1bRR7-nHTyaN7awhMS6reU2qciV4ULJRKOKTRV5ap1JdpZxakkU0QvE4TMgxhLTEZYiZdl4t_Y7UiIxAQo-75hXMNu-rGoM5KknRp2NAZbnEOnrFMAVBUwi0H7woj1XH9lUXWZ8W87-vHdOO7_ng1KtH21QCGVR1xmnr2vfp3Z766BxXlb_CODOIf3RFFyZWDcZwZxgibmSOad-YAl4R5SU21zetJyMFNS_6X5W5_3S-3AVpHiyn1XoXXkryPSRyzIIFkjTyDc0dj8bC-G5im9iyN-jB47PXfVSaDa1M7t3EGOnGpJdlBO_W1WiHLRNznFAmptL35yFEvPXy9x744vAzXRxTWFGepTjpiyXKE7mOPiajaFfjdKp05WCEfYXZxfM1evIbPieNTUd1KLVhqEi0e433V5-JkEt7udCmX-p6iCj1QNdTzc1ckDnXzdR_LVDNqtYa7y5YdEBwAs8qJGt-SArsvol0riCS-CWkYlOc5PkOGgX9ia4aDpnVcMXMVBEJRkPUT1jRBw6_lUG3kelBbMVJcDoPH32fg33RXz4EYugUY4wS7YiPFrpIzQ-5WCnexjeWGr6PmNqIe8yc-QqGnv246vlyjmU0IU";

        return $config[$get];
    }

    public function Liff (string $get){
        $config["lottery"] = "1657289658-V54BPEBB";

        return $config[$get];
    }
}
?>