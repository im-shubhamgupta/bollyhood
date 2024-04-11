<?php
require_once 'include/db_controller.php';
// include 'include/constant.php';
$db = new DB_Controller();
// $db = new DB_Function();

if (true) {


    $db->escapeStringTrim(456);

    $Result = $db->get_company_list(1);

    if ($Result != false) {
        $response["status"] = '1';
        $response["result"] = $Result;
        echo json_encode($response);
    } else {

        $response["status"] = '0';
        $response["error_msg"] = "Not Found";
        echo json_encode($response);
    }
}
