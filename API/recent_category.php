<?php
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');


$Result = $db->category_recent_list();

if (!empty($Result)) {
    $response["status"] = '1';
    $response["result"] = $Result;
    $response["msg"] = 'success';

} else {
    $response["msg"] = 'Not found';
}

echo json_encode($response);