<?php
require_once 'include/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['name']) &&isset($_REQUEST['mobile']) && isset($_REQUEST['email']) && isset($_REQUEST['password'])  && isset($_REQUEST['user_type']) && isset($_REQUEST['categories']) && isset($_REQUEST['sub_categories']) ) {

    $data= array(
        'name' => $db->escapeStringTrim($_REQUEST['name']),
        'mobile' => $db->escapeStringTrim($_REQUEST['mobile']),
        'email' => $db->escapeStringTrim($_REQUEST['email']),
        'password' => $db->escapeStringTrim($_REQUEST['password']),
        // 'cat_id' =>(isset($_REQUEST['cat_id']) && !empty($_REQUEST['cat_id']) )?  $db->escapeStringTrim($_REQUEST['cat_id']) : NULL,
        // 'cat_id' => NULL,
        'user_type' => $db->escapeStringTrim($_REQUEST['user_type']),
        'categories' => $db->escapeStringTrim($_REQUEST['categories']),
        'sub_categories' => $db->escapeStringTrim($_REQUEST['sub_categories']),
    );
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        $error_msg = "This is POST API";
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
    elseif(empty($data['password'])){
        $error_msg = "Required password";
    } 
    elseif(empty($_FILES['image']['name'])){
        $error_msg = "Required User Image";
    }

    if(!isset( $error_msg)){
        $Result = $db->sign_up($data);
        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = 'Registration Successfully';

        } else {
            $response["msg"] = $Result['msg'];
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter name,email,mobile, password,user_type,categories,sub_categories";
}
echo json_encode($response);