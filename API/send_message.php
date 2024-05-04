<?php
require_once 'controller/message_controller.php';
$db = new message_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');
if($_SERVER['REQUEST_METHOD'] != 'POST'){
    $response["msg"] = "This is POST API";
    echo json_encode($response); die();
}

if (isset($_REQUEST['uid']) && isset($_REQUEST['other_uid'])){// && isset($_REQUEST['text']) && isset($_FILES['image'])//$_FILES['image']

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'other_uid' => $db->escapeStringTrim($_REQUEST['other_uid']),
        'text' => $db->escapeStringTrim($_REQUEST['text']),
        'image' =>isset($_FILES['image']) ?  $_FILES['image'] : '',
    );
    
    if(empty($data['uid'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['other_uid'])){
        $error_msg = " Required ither_uid";
    }
    elseif($data['uid'] == $data['other_uid']){
        $error_msg = " Both uid cant't be same";
    }
    elseif(empty($data['text']) &&  empty($_FILES['image'])){
        $error_msg = "Required Text or image";
    }

    if(!isset( $error_msg)){
        $Result = $db->send_message($data);
        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = 'send message Successfully';
            // $response["result"] = $Result['result'];
        } else {
            $response["msg"] = $Result['msg'];
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Total parameter uid,other_uid,text,image";
}
echo json_encode($response);