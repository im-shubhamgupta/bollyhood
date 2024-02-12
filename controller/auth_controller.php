<?php
$response = array('check'=>'error' , 'msg'=>'Access Denied');
$submit_action = isset($_REQUEST['submit_action']) ? escapeStringTrim($_REQUEST['submit_action']) : '';
switch($submit_action){
	case 'log_in':
		$response = array('check' => 'failed' , 'msg'=>'Something error Please try again' );
		$temp = array(
			'password' => escapeStringTrim($_POST['password'])
		);
		if(is_numeric($_POST['username'])){
			$temp['mobile'] = escapeStringTrim($_POST['username']);
		}else{
			$temp['email'] = escapeStringTrim($_POST['username']);
			if (!filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
				$response['msg'] = "Invalid email format";
				redirect('',$response);
			}
		}
		$password = escapeStringTrim($_POST['password']);

		$data = executeSelectSingle('backend_users',array(),$temp);
		if(count($data) > 0){
			$_SESSION['user_id'] = $data['id'];
			$_SESSION['email'] =  $data['email'];
			$_SESSION['login'] =  'y';
			// $response = '';
			$response['check'] = 'success';
            $response['msg'] = 'Login Successfully';
		}else{
			$response['msg'] = 'Please Enter correct Credentials';
		}
		// debugSql();
		redirect('home',$response);
        die;
    break;
	case 'log_out':
		$response = array('check' => 'failed' , 'msg'=>'Not Logout' );
		if(isset($_SESSION)){
			session_unset();
			session_destroy();
			$response['check'] = 'success';
            $response['msg'] = 'Logout Successfully';
		}
		redirect('',$response);
        die;
     break;
	default : 
		$response['check'] = 'error';
		$response['msg'] = 'Bad Request';
	break;	
}
// 
if(empty($_POST['submit_action'])){
	echo json_encode($response);
}
die;
?>