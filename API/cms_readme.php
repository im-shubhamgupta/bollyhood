<?php  
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if ( isset($_REQUEST['type']) ) {
    $data= array(
        'type' => $db->escapeStringTrim($_REQUEST['type']),
    );

    if(empty($data['type'])){
        $error_msg = "type required";
    }

    if(!isset( $error_msg)){
        $Result = $db->cms_readme_list($data);

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
    $response["msg"] = "Required parameter type";
}

echo json_encode($response);