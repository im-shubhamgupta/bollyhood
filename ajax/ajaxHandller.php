<?php
include('../constant.php');
$ajax_action = isset($_POST['ajax_action']) ? $_POST['ajax_action'] :'';
$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again!!' );
switch($ajax_action){
	case 'add_user':
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);

		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );
		$temp = array(
			'name' => escapeStringTrim($_POST['name']),
			'email' => escapeStringTrim($_POST['email']),
			'mobile' => escapeStringTrim($_POST['mobile']),
			'status' => escapeStringTrim($_POST['status']),
			'cat_id' => escapeStringTrim($_POST['cat_id']),
			'image' => escapeStringTrim($_POST['user_image']),
			'modify_date' => date("Y-m-d H:i:s")
		);
		// $temp['image'] = 'no_image.png';

		$image = $_FILES['image'];
		$image_flag = 0;
		if(isset($_FILES['image']) && !empty(($_FILES['image']['name']) )){
			$imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']),PATHINFO_EXTENSION));
			$valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType; 
			if(in_array($imageFileType, VALID_IMG_EXT)){
				$image_flag = 1;
			}else{
				$response['msg'] = "Accept only .png, .jpg, .jpeg Extension Image only";
			}   
		}
		if($image_flag == 1) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], '../resources/image/users/'.$valid_imgname)) {
				$temp['image'] = $valid_imgname;
			}
		}
		$id = isset($_POST['id'])?escapeString($_POST['id']):'';
		$id_sql = !empty($id) ? " AND id != $id " :  '';
		$mob = getAffectedRowCount("SELECT `id` from  users where mobile = '".$temp['mobile']."' $id_sql ");
		if(!empty($mob)){
			$response['check'] = 'already';
			$response['msg'] = 'Mobile no Already Exist';
		}
		$email = getAffectedRowCount("SELECT `id` from  users where email = '".$temp['email']."' $id_sql ");
		if(!empty($email)){
			$response['check'] = 'already';
			$response['msg'] = 'Email Already Exist';
		}
		// print_r($temp);
		// print_r($id);
		if($response['check'] != 'already'){
			if(!empty($id)){
				$up = executeUpdate('users',$temp,array('id'=> $id));
				if($up){	
					$response['check'] = 'success';
					$response['msg'] = 'Data Updated Successfully';
				}
			}else{
				$temp['create_date'] = date("Y-m-d H:i:s");
				$temp['password'] = 123456;
				$insert = executeInsert('users',$temp);
				if($insert > 0){	
					$response['check'] = 'success';
					$response['msg'] = 'Data Inserted Successfully';
				}
			}
			
		}
		echo json_encode($response);
		die;
	break; 

	case 'add_banner':

		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );

		$image_flag = 0;
		if(isset($_FILES['banner_image']) && !empty(($_FILES['banner_image']['name']) )){
			$imageFileType = strtolower(pathinfo(basename($_FILES['banner_image']['name']),PATHINFO_EXTENSION));
			$valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType; 
			if(in_array($imageFileType, VALID_IMG_EXT)){
				$image_flag = 1;
			}else{
				$response['msg'] = "Accept only .png, .jpg, .jpeg Extension Image only";
			}   
		}
		if($image_flag == 1) {
			$id = isset($_POST['id'])?escapeString($_POST['id']):'';
				$data['banner_image'] =  $valid_imgname;
				$data['create_date'] =  date('Y-m-d H:i:s');
			if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], '../resources/image/banners/'.$valid_imgname)) {
				if($id > 0){
					$update = executeUpdate('banners',$data,array('id'=>$id));
					if($update){
						$response['check'] = 'success';
						$response['msg'] = 'Data Updated Successfully';
					}

				}else{
					$insert = executeInsert('banners',$data);
					if($insert){
						$response['check'] = 'success';
						$response['msg'] = 'Data Inserted Successfully';
					}
				}
			}else{
				$response['msg'] = 'Something problem on image uploading'; 
			}
		}
		echo json_encode($response);
		die;
	break;	
	case "delete_banner":
		$id = escapeString($_POST['id']);
		if(!empty($id)){
			$del = executeDelete('banners',array('id'=>$id));
			if($del){
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			}else{
				$response['msg'] = 'Error Happend';
			}
		}else{
			$response['msg'] = 'Delete id not found';
		}
	break;
	case "delete_user":
		$id = escapeString($_POST['id']);
		if(!empty($id)){
			$del = executeDelete('users',array('id'=>$id));
			if($del){
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			}else{
				$response['msg'] = 'Error Happend';
			}
		}else{
			$response['msg'] = 'Delete id not found';
		}
	break;
	case "delete_category":
		$id = escapeString($_POST['id']);
		if(!empty($id)){
			$del = executeDelete('category',array('id'=>$id));
			if($del){
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			}else{
				$response['msg'] = 'Error Happend';
			}
		}else{
			$response['msg'] = 'Delete id not found';
		}
	break;	
	case 'mod_expertise':

		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );
		$temp = array(
			'name' => escapeStringTrim($_POST['name']),
			'mobile' => escapeStringTrim($_POST['mobile']),
			'reviews' => escapeStringTrim($_POST['reviews']),
			'jobs_done' => escapeStringTrim($_POST['jobs_done']),
			'description' => escapeStringTrim($_POST['description']),
			'work_links' => escapeStringTrim($_POST['work_links']),
			'categories' => trim(implode(',',$_POST['cat_id']),','),
			'modify_date' => date("Y-m-d H:i:s")
		);
		$temp['user_image'] = escapeStringTrim($_POST['user_image']);

		$image = $_FILES['image'];
		$image_flag = 0;
		// print_r($_FILES);
		if(isset($_FILES['image']) && !empty(($_FILES['image']['name']) )){
			$imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']),PATHINFO_EXTENSION));
			$valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType; 
			if(in_array($imageFileType, VALID_IMG_EXT)){
				$image_flag = 1;
			}else{
				$response['msg'] = "Accept only .png, .jpg, .jpeg Extension Image only";
			}   
		}
		if($image_flag == 1) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], '../resources/image/expertise/'.$valid_imgname)) {
				$temp['user_image'] = $valid_imgname;
			}
		}
		$id = isset($_POST['id'])?escapeString($_POST['id']):'';
		
			// print_R($temp);
			if(!empty($id)){
				$up = executeUpdate('expertise',$temp,array('id'=> $id));
				if($up){	
					$response['check'] = 'success';
					$response['msg'] = 'Data Updated Successfully';
				}
			}else{
				$temp['create_date'] = date("Y-m-d H:i:s");
				$insert = executeInsert('expertise',$temp);
				if($insert > 0){	
					$response['check'] = 'success';
					$response['msg'] = 'Data Inserted Successfully';
				}
			}
			
		echo json_encode($response);
		die;
	break;
	case "delete_expertise":
		$id = escapeString($_POST['id']);
		if(!empty($id)){
			$del = executeDelete('expertise',array('id'=>$id));
			if($del){
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			}else{
				$response['msg'] = 'Error Happend';
			}
		}else{
			$response['msg'] = 'Delete id not found';
		}
	break;
	default:
		echo json_encode(array('check' => 'failed' , 'msg'=>'Bad Request' ));
	break;
}
echo json_encode($response);
