<?php
require_once 'controller/db_controller.php';
$db = new DB_Controller();
$response = array('status' => '0', 'msg'=> 'Something went wrong!!');

if (isset($_REQUEST['uid']) && isset($_REQUEST['w_mobile']) && isset($_REQUEST['purpose']) && isset($_REQUEST['booking_date'])  && isset($_REQUEST['booking_time'])  && isset($_REQUEST['category_id'])   && isset($_REQUEST['booking_uid']) ) {
   
    // print_r(str_replace('/','-',strtotime($_REQUEST['booking_date'])));
    $date_time = date('Y-m-d',strtotime(str_replace('/','-',$_REQUEST['booking_date']))).' '.date('H:i:s',strtotime($_REQUEST['booking_time']));
    $data= array(
        'uid' => $db->escapeStringTrim($_REQUEST['uid']),
        'w_mobile' => $db->escapeStringTrim($_REQUEST['w_mobile']),
        'purpose' => $db->escapeStringTrim($_REQUEST['purpose']),
        'category_id' => $db->escapeStringTrim($_REQUEST['category_id']),
        'booking_uid' => $db->escapeStringTrim($_REQUEST['booking_uid']),
        'booking_date' => $date_time,
    );
   
    if(empty($data['uid'])){
        $error_msg = " Required uid";
    }
    elseif(empty($data['w_mobile'])){
        $error_msg = " Required w_mobile";
    }
    elseif(empty($data['purpose'])){
        $error_msg = "Required purpose";
    }
    elseif(empty($_REQUEST['booking_date'])){
        $error_msg = "Required booking_date";
    }
    elseif(empty($_REQUEST['booking_time'])){
        $error_msg = "Required booking_time";
    }
    elseif(empty($_REQUEST['booking_uid'])){
        $error_msg = "Required booking_uid";
    }
    elseif(empty($_REQUEST['category_id'])){
        $error_msg = "Required category_id";
    }

    if(!isset( $error_msg)){
        $Result = $db->mod_booking($data);
        if ($Result['check'] == 'success') {
            $response["status"] = '1';
            $response["msg"] = $Result['msg'];
            // $response["result"] = $Result['result'];
        } else {
            $response["msg"] = $Result['msg'];
        }
    }else{
        $response["msg"] = $error_msg;
    }    
}else{
    $response["msg"] = "Required parameter uid,w_mobile,purpose,booking_date ,booking_time ,category_id,booking_uid  ";
}
echo json_encode($response);