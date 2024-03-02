<?php
//verify OTP by this api 
require_once 'include/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['mobile']) && isset($_REQUEST['otp'])  ) {

    $data= array(
        'mobile' => $db->escapeStringTrim($_REQUEST['mobile']),
        'otp' => $db->escapeStringTrim($_REQUEST['otp']),
    );
    if(empty($data['mobile'])){
        $error_msg = "Mobile no required";
    }
    if(empty($data['otp'])){
        $error_msg = "otp required";
    }
    if(strlen($data['otp']) != '6'){
        $error_msg = "otp must br in 6 digits";
    }

    if(!isset( $error_msg)){
        $Result = $db->send_otp($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Please check Mobile no or otp ';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter mobile , otp";
}
echo json_encode($response);