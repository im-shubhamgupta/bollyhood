<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['mobile']) && isset($_REQUEST['new_password']) ) {

    $data= array(
        'mobile' => $db->escapeStringTrim($_REQUEST['mobile']),
        'new_password' => $db->escapeStringTrim($_REQUEST['new_password']),
    );
    if(empty($data['mobile'])){
        $error_msg = "Mobile no required";
    }
    if(empty($data['new_password'])){
        $error_msg = "password required";
    }
    if(!isset( $error_msg)){
        $Result = $db->reset_password($data);

        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = $Result['msg'];

        } else {
            $response["msg"] = $Result['msg'];
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter mobile no,new_password";
}
echo json_encode($response);