<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid'])) {

    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
       
    );
    if(empty($data['uid'])){
        $error_msg = "uid required";
    }
    
    if(!isset( $error_msg)){
        $Result = $db->check_subscription($data);

        if ($Result['is_subscription']==1) {
            $response["status"] = '1';
            $response["msg"] = 'success';
            $response["result"] = $Result;

        } else {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'You have not subscription to purchase this Plan';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter mobile no,old_password,new_password";
}
echo json_encode($response);