<?php
require_once 'controller/casting_controller.php';
$db = new casting_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

//onlu=y individual apply
if (isset($_REQUEST['uid']) && isset($_REQUEST['casting_id']) && isset($_FILES['images']) && isset($_FILES['video'])) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'casting_id' => $db->escapeStringTrim($_REQUEST['casting_id']),
        'images' =>isset($_FILES['images']) ?  array($_FILES['images']) : '',
        'video' =>isset($_FILES['video']) ?  $_FILES['video'] : '',
        
    );
    // print_R($_FILES['images']);
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        $error_msg = "Accept POST data only";
    }
    elseif(empty($data['uid'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['casting_id'])){
        $error_msg = " Required casting_id";
    }
    if(!isset( $error_msg)){
        $Result = $db->casting_apply($data);
        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = 'Applied Sucessfully';
            // $response["result"] = $Result['result'];
        } else {
            $response["msg"] = 'Something error';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid,casting_id,images,video";
}
echo json_encode($response);