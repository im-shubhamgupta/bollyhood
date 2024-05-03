<?php
require_once 'controller/message_controller.php';

$db = new message_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['other_uid'])){

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'other_uid' => $db->escapeStringTrim($_REQUEST['other_uid']),
    );
    if(empty($data['uid'])){
        $error_msg = "uid required";
    }
    if(empty($data['other_uid'])){
        $error_msg = "other_uid required";
    }

    if(!isset( $error_msg)){
        $Result = $db->chat_list($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'Success';

        } else {
            $response["msg"] = 'Not  found ';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid";
}
echo json_encode($response);