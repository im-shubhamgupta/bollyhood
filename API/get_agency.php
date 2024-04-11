<?php
require_once 'controller/casting_controller.php';

$db = new casting_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

        $Result = $db->all_cating_apply();

        if ($Result) {
            $response["status"] = '1';
            $response["result"] = $Result;
            $response["msg"] = 'Success';

        } else {
            $response["msg"] = 'Not  found ';
        }

echo json_encode($response);