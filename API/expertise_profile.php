<?php
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['id']) && isset($_REQUEST['uid']) ) {

    $data= array(
        'id' => $db->escapeStringTrim($_REQUEST['id']),//expertise_id
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
    );
    if(empty($data['id'])){
        $error_msg = "id required";
    }
    elseif(empty($data['uid'])){
        $error_msg = "uid required";
    }
   
    if(!isset( $error_msg)){
        $Result = $db->get_expertise_profile($data);
        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Please check input';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter id,uid";
}
echo json_encode($response);