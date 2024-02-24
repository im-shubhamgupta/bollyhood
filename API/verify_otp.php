<?php
require_once 'include/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['otp']) ) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'otp' => $db->escapeStringTrim($_REQUEST['otp']),
    );
    if(empty($data['uid'])){
        $error_msg = "uid required";
    }

    if(!isset( $error_msg)){
        $Result = $db->send_otp($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Please check uid ';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid";
}
echo json_encode($response);