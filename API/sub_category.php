<?php  
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if ( isset($_REQUEST['category_id']) ) {
    $data= array(
        'category_id' => $db->escapeStringTrim($_REQUEST['category_id']),
    );

    if(empty($data['category_id'])){
        $error_msg = "category_id required";
    }

    if(!isset( $error_msg)){
        $Result = $db->sub_category_list($data);

        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Not found';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter category_id";
}

echo json_encode($response);