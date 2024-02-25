<?php
//<!-- use sxrf for safe hit by session -->     
//this is use after submitting form
echoPrint($_POST);
$response = array('check'=>'error' , 'msg'=>'Access Denied');
$submit_action = isset($_POST['submit_action']) ? escapeStringTrim($_POST['submit_action']) : '';
switch($submit_action){
	case 'add_category':
		$response = array('check' => 'failed' , 'msg'=>'Something error Please try again' );

		$data = array(
			'category_name' => escapeStringTrim($_POST['category_name']),
		);
		if($_POST['id'] > 0){
			$id = escapeStringTrim($_POST['id']);
			// $data['modify_date'] = date("Y-m-d H:i:s");

			$res = executeUpdate('category',$data,array('id' => $id));
			if($res){
				$response['check'] = 'success';
				$response['msg'] = "Data Inserted Sucessfully";
			}	
		}else{
			$res = executeInsert('category',$data);
			if($res){
				$response['check'] = 'success';
				$response['msg'] = "Data Inserted Sucessfully";
			}
		}		
		// debugSql();
		redirect('category',$response);
		die;	
	break;
	case 'add_category':
		$response = array('check' => 'failed' , 'msg'=>'Something error Please try again' );
		$data = array(
			'name' => escapeStringTrim($_POST['name']),
			'email' => escapeStringTrim($_POST['name']),
			'email' => escapeStringTrim($_POST['name']),
			'mobile' => escapeStringTrim($_POST['name']),
			'name' => escapeStringTrim($_POST['name']),
		);
		if($_POST['id'] > 0){
			$id = escapeStringTrim($_POST['id']);
			// $data['modify_date'] = date("Y-m-d H:i:s");

			$res = executeUpdate('category',$data,array('id' => $id));
			if($res){
				$response['check'] = 'success';
				$response['msg'] = "Data Inserted Sucessfully";
			}	
		}else{
			$res = executeInsert('category',$data);
			if($res){
				$response['check'] = 'success';
				$response['msg'] = "Data Inserted Sucessfully";
			}
		}		
		// debugSql();
		redirect('category',$response);
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

//redirect('home',$msg);//you can set comma paramenter sessio flush


?>