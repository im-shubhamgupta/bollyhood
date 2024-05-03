<?php
require_once 'controller/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['old_password']) && isset($_REQUEST['new_password']) ) {

    $data= array(
        'id' => $db->escapeStringTrim($_REQUEST['uid']),
        'new_password' => $db->escapeStringTrim($_REQUEST['new_password']),
        'old_password' => $db->escapeStringTrim($_REQUEST['old_password']),
    );
    if(empty($data['id'])){
        $error_msg = "uid required";
    }
    if(empty($data['new_password'])){
        $error_msg = "new password required";
    }
    if(empty($data['old_password'])){
        $error_msg = "old password required";
    }
    if(!isset( $error_msg)){
        $Result = $db->change_password($data);

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
    $response["msg"] = "Required parameter mobile no,old_password,new_password";
}
echo json_encode($response);