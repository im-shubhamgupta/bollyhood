<?php  
require_once 'controller/db_controller.php';

$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

// if (isset($_REQUEST['current_page']) && isset($_REQUEST['per_page']) ) {

$data['current_page'] = !empty($_REQUEST['current_page']) ? $_REQUEST['current_page'] : '0';
$data['per_page'] = !empty($_REQUEST['per_page']) ? $_REQUEST['per_page'] : '15';

    $Result = $db->category_list($data);

    if (!empty($Result)) {
        $response["status"] = '1';
        $response["result"] = $Result;
        $response["msg"] = 'success';

    } else {
        $response["msg"] = 'Not found';
    }
// }else{
//     $response["msg"] = "Required parameter current_page,per_page";
// }

echo json_encode($response);