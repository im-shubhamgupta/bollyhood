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
			'category_image' => escapeStringTrim($_POST['category_image']),
		);
		$image = isset($_FILES['image']) ? $_FILES['image'] : '';
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
			if (move_uploaded_file($_FILES["image"]["tmp_name"], 'resources/image/category/'.$valid_imgname)) {
				$data['category_image'] = $valid_imgname;
			}
		}
		// print_R($data);
		if($_POST['id'] > 0){
			$id = escapeStringTrim($_POST['id']);
			$data['modify_date'] = date("Y-m-d H:i:s");

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
			'category_image' => escapeStringTrim($_POST['category_image']),
		);
		print_R($_POST);
		print_R($_FILES);
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
			if (move_uploaded_file($_FILES["image"]["tmp_name"], '../resources/image/category/'.$valid_imgname)) {
				$temp['category_image'] = $valid_imgname;
			}
		}
		die;
		if($_POST['id'] > 0){
			$id = escapeStringTrim($_POST['id']);
			$data['modify_date'] = date("Y-m-d H:i:s");

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
		// redirect('category',$response);
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