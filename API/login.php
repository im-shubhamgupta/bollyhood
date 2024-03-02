<?php
require_once 'include/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['id'])) {

    $data= array(
        'id' => $db->escapeStringTrim($_REQUEST['id']),
        // 'password' => $db->escapeStringTrim($_REQUEST['password']),
    );
    if(empty($data['id'])){
        $error_msg = "Id required";
    }
   

    if(!isset( $error_msg)){
        $Result = $db->login($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'Login Sucessfully';

        } else {
            $response["msg"] = 'User is not exist';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter id";
}
echo json_encode($response);