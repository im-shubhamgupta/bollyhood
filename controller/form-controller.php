<?php
//<!-- use sxrf for safe hit by session -->     
//this is use after submitting form
// include_once('../constant.php');
//set condition of session 
$response = array('check'=>'error' , 'msg'=>'Access Denied');
$submit_action = isset($_POST['submit_action']) ? escapeStringTrim($_POST['submit_action']) : '';
switch($submit_action){
	case 'add_form':
		$msg = 'Something Went Wrong Please try again';
		$response = array();
		$response = array('check' => 'failed' , 'msg'=>'Something error Please try again' );

		$data = array(
			'text' => escapeStringTrim($_POST['text']),
			'source' => escapeStringTrim($_POST['source']),
			'category' => escapeStringTrim($_POST['category']),
		);
		if($_POST['id'] > 0){
			$id = escapeStringTrim($_POST['id']);
			$text = escapeStringTrim($_POST['text']);
			$data['modify_date'] = date("Y-m-d H:i:s");

			$sql= "SELECT * from record_data where `text` = '".$text."' and id!= '$id' ";
			$res = getSingleResult($sql);
			if(count($res) > 0 ){
				// $msg = "Text is already exist";
				$response['msg'] = "Text is already exist";
				$_SESSION['temp_POST'] = $_POST; 
				redirect('form',$response);
			}else{
				$update = executeUpdate('record_data',$data,array('id'=>$id));
				if($update){
					$response['check'] = 'success';
					$response['msg'] = "Data updated Sucessfully";
					// $msg ="Data updated Sucessfully";
				}
			}	
		}else{
			$text = escapeStringTrim($_POST['text']);
			$sql= "SELECT * from record_data where `text` = '".$text."'";
			$res = getSingleResult($sql);
			if(count($res) > 0 ){
				// $msg = "Text is already exist";
				$response['msg'] =  "Text is already exist";
				$_SESSION['temp_POST'] = $_POST; 
				redirect('form',$response);
			}else{
				$data['create_date'] = date("Y-m-d H:i:s");
				$insert = executeInsert('record_data',$data);
				if($insert){
				// $msg ="Data Inserted Sucessfully";
				$response['check'] = 'success';
				$response['msg'] = "Data Inserted Sucessfully";
				}
			}	
		}
		//echo debugSql();
		redirect('all_data',$response);
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