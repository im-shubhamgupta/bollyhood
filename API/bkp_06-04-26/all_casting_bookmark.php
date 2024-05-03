<?php
require_once 'controller/casting_controller.php';

$db = new casting_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid'])) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
    );
    if(empty($data['uid'])){
        $error_msg = "uid required";
    }
   
    if(!isset( $error_msg)){
        $Result = $db->all_casting_bookmark($data);
        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Not Found';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid";
}
echo json_encode($response);