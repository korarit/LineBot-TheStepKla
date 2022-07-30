<?php
namespace KRTStudio\Function\Notification;

class notify {

    public function line_notify($message, $token){
        $chOne = curl_init();
	    curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
	    curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
	    curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
	    curl_setopt( $chOne, CURLOPT_POST, 1); 
	    curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=".$message); 
	    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$token.'', );
	    curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers); 
	    curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1); 
	    $result = curl_exec( $chOne ); 

	    //Result error 
	    if(curl_error($chOne)) { 
		    return 'error:' . curl_error($chOne); 
	    } else { 
		    $result_ = json_decode($result, true); 
		    return "status : ".$result_['status']; echo "message : ". $result_['message'];
	    } 
	    curl_close($chOne);
    }

    public function Discord($message, $token, $name){
        $url = "https://discordapp.com/api/webhooks/".$token;
        $headers = [ 'Content-Type: application/json; charset=utf-8' ];
        $POST = [ 'username' => $name, 'content' => $message ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POST));
        $response   = curl_exec($ch);

    }
}
?>