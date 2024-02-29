<?php
include('../constant.php');
$ajax_action = isset($_POST['ajax_action']) ? $_POST['ajax_action'] :'';
switch($ajax_action){
	case 'add_user':
		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );
		$temp = array(
			'name' => escapeStringTrim($_POST['name']),
			'email' => escapeStringTrim($_POST['email']),
			'mobile' => escapeStringTrim($_POST['mobile']),
			'status' => escapeStringTrim($_POST['status']),
			'cat_id' => escapeStringTrim($_POST['cat_id']),
			'create_date' => date("Y-m-d H:i:s")
		);

		$name = executeSelectSingle('users',array('id'),array('mobile' => $temp['mobile']));
		if(!empty($name)){
			$response['check'] = 'already';
			$response['msg'] = 'Mobile no Already Exist';
		}
		$email = executeSelectSingle('users',array('id'),array('email' => $temp['email']));
		if(!empty($email)){
			$response['check'] = 'already';
			$response['msg'] = 'Email Already Exist';
		}

		if($response['check'] != 'already'){
			$insert = executeInsert('users',$temp);
			if(!empty($insert) > 0){	
				$response['check'] = 'success';
				$response['msg'] = 'Data Inserted Successfully';
			}
		}
		// debugSql();
		
		echo json_encode($response);
		die;
	break; 
	default:
		echo json_encode(array('check' => 'failed' , 'msg'=>'Bad Request' ));
	break;
}
