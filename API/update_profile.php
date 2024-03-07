<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['name']) && isset($_REQUEST['mobile']) && isset($_REQUEST['email']) && isset($_REQUEST['cat_id']) ) {

    $data= array(
        'id' => $db->escapeStringTrim($_REQUEST['uid']),
        'name' => $db->escapeStringTrim($_REQUEST['name']),
        'mobile' => $db->escapeStringTrim($_REQUEST['mobile']),
        'email' => $db->escapeStringTrim($_REQUEST['email']),
        'cat_id' => $db->escapeStringTrim($_REQUEST['cat_id']),
    );
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        $error_msg = "This is POST API";
    }
    elseif(empty($data['id'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['name'])){
        $error_msg = " Required name";
    }
    elseif(empty($data['mobile'])){
        $error_msg = "Required mobile";
    }
    elseif(strlen($data['mobile']) > 10 || strlen($data['mobile']) < 10 ){
        $error_msg = "Mobile no should be 10 digits";
    }
    elseif(empty($data['email'])){
        $error_msg = "Required email";
    }
    elseif(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
        $error_msg = "Invalid Email Format";
    }
    elseif(empty($data['cat_id'])){
        $error_msg = "Required cat_id";
    }

    if(!isset( $error_msg)){
        $Result = $db->update_profile($data);
        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = 'Profile udpated Successfully';
            $response["result"] = $Result['result'];
        } else {
            $response["msg"] = $Result['msg'];
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid,name,email,mobile, cat_id";
}
echo json_encode($response);