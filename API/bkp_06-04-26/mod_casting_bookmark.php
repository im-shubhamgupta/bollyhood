<?php
require_once 'controller/casting_controller.php';
$db = new casting_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['casting_id']) &&  isset($_REQUEST['bookmark_mode']) ) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'casting_id' => $db->escapeStringTrim($_REQUEST['casting_id']),
        'bookmark_mode' => $db->escapeStringTrim($_REQUEST['bookmark_mode']),
    );
   
    if(empty($data['uid'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['casting_id'])){
        $error_msg = " Required casting_id";
    }
    elseif(empty($data['bookmark_mode'])){
        $error_msg = "Required bookmark_mode";
    }
    elseif($data['bookmark_mode'] != 1 && $data['bookmark_mode'] != 2){//use in_array
        $error_msg = "Required bookmark_mode accept only 1 or 2";
    }

    if(!isset( $error_msg)){
        $Result = $db->mod_casting_bookmark($data);
        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = $Result['msg'];;
        } else {
            $response["msg"] = $Result['msg'];
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid,casting_id,bookmark_mode";
}
echo json_encode($response);