<?php
require_once 'include/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

// if (isset($_REQUEST['uid'])) {

    // $data= array(
    //     'uid' => $db->escapeStringTrim($_REQUEST['uid']),
    // );
    // if(empty($data['uid'])){
    //     $error_msg = "uid required";
    // }
   
    // if(!isset( $error_msg)){
        $Result = $db->all_casting();
        if (!empty($Result)) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'success';

        } else {
            $response["msg"] = 'Not found';
        }
    // }else{
    //     $response["msg"] = $error_msg;
    // }    
// }else{
//     $response["msg"] = "Required parameter id";
// }
echo json_encode($response);