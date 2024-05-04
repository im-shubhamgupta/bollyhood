<?php
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid'])) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'is_online' => 0
    );
    if(empty($data['uid'])){
        $error_msg = "uid required";
    }
   
    
    if(!isset( $error_msg)){
        $Result = $db->logout($data);
        if (!empty($Result)) {
            $response["status"] = '1';
            $response["msg"] = 'Logout Sucessfully';

        } else {
            $response["msg"] = 'Something Error';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid";
}
echo json_encode($response);