<?php
require_once 'controller/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['expertise_id'])) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'expertise_id' => $db->escapeStringTrim($_REQUEST['expertise_id']),
    );
   
    if(empty($data['uid'])){
        $error_msg = "Required uid";
    }
    elseif(empty($data['expertise_id'])){
        $error_msg = " Required expertise_id";
    }

    if(!isset( $error_msg)){
        $Result = $db->expertise_book($data);
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
    $response["msg"] = "Required parameter uid,expertise_id";
}
echo json_encode($response);