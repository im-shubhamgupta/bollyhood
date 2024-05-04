<?php
//verify OTP by this api 
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['mobile']) && isset($_REQUEST['otp']) && isset($_REQUEST['is_online'])) {

    $data= array(
        'mobile' => $db->escapeStringTrim($_REQUEST['mobile']),
        'otp' => $db->escapeStringTrim($_REQUEST['otp']),
        'fcmtoken' => isset($_REQUEST['fcmtoken']) ? $db->escapeStringTrim($_REQUEST['fcmtoken']) : '',
        'is_online' => ($_REQUEST['is_online']!='') ? $db->escapeStringTrim($_REQUEST['is_online']) : '0',
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
            $response["msg"] = 'Login Sucessfully';

        } else {
            $response["msg"] = 'Please check Mobile no or otp ';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter mobile , otp,fcmtoken, is_online";
}
echo json_encode($response);