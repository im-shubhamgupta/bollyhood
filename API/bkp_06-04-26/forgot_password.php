<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['mobile'])) {

    $data= array(
        'mobile' => $db->escapeStringTrim($_REQUEST['mobile']),
    );
    if(empty($data['mobile'])){
        $error_msg = "Mobile no required";
    }
    if(!isset( $error_msg)){
        $Result = $db->forgot_password($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Please check Mobile no. ';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter mobile no";
}
echo json_encode($response);