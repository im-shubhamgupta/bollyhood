<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['bookmark_uid']) &&  isset($_REQUEST['bookmark_mode']) ) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'bookmark_uid' => $db->escapeStringTrim($_REQUEST['bookmark_uid']),
        'bookmark_mode' => $db->escapeStringTrim($_REQUEST['bookmark_mode']),
    );
   
    if(empty($data['uid'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['bookmark_uid'])){
        $error_msg = " Required bookmark_uid";
    }
    elseif(empty($data['bookmark_mode'])){
        $error_msg = "Required bookmark_mode";
    }
    elseif($data['bookmark_mode'] != 1 && $data['bookmark_mode'] != 2){//use in_array
        $error_msg = "Required bookmark_mode accept only 1 or 2";
    }

    if(!isset( $error_msg)){
        $Result = $db->mod_bookmark($data);
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
    $response["msg"] = "Required parameter uid,bookmark_uid,bookmark_mode";
}
echo json_encode($response);