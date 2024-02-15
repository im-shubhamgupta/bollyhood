<?php
require_once 'include/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['id']) && isset($_REQUEST['password'])) {

    $data= array(
        'id' => $db->escapeStringTrim($_REQUEST['id']),
        'password' => $db->escapeStringTrim($_REQUEST['password']),
    );
    if(empty($data['id'])){
        $error_msg = "Id required";
    }elseif(empty($data['password'])){
        $error_msg = "Password required";
    }

    if(!isset( $error_msg)){
        $Result = $db->login($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Please check Login Credential ';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter id, password";
}
echo json_encode($response);