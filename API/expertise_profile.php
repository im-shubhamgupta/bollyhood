<?php
require_once 'include/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['id'])) {

    $data= array(
        'id' => $db->escapeStringTrim($_REQUEST['id']),
    );
    if(empty($data['id'])){
        $error_msg = "id required";
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
    $response["msg"] = "Required parameter id";
}
echo json_encode($response);