<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['expertise_id']) && isset($_REQUEST['bookmark_mode']) ) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'expertise_id' => $db->escapeStringTrim($_REQUEST['expertise_id']),
        'bookmark_mode' => $db->escapeStringTrim($_REQUEST['bookmark_mode']),
    );
   
    if(empty($data['uid'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['expertise_id'])){
        $error_msg = " Required expertise_id";
    }
    elseif(empty($data['bookmark_mode'])){
        $error_msg = "Required bookmark_mode";
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
    $response["msg"] = "Required parameter uid,expertise_id,bookmark_mode";
}
echo json_encode($response);