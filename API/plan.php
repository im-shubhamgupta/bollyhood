<?php
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

// if (isset($_REQUEST['uid'])) {

    // $data= array(
    //     'id' => $db->escapeStringTrim($_REQUEST['uid']),
    // );
    // if(empty($data['id'])){
    //     $error_msg = "uid required";
    // }
   
    if(!isset( $error_msg)){
        $Result = $db->all_subscription_plans();
        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Not Found';
        }
    }else{
        $response["msg"] = $error_msg;
    }    
// }else{
//     $response["msg"] = "Required parameter id";
// }
echo json_encode($response);