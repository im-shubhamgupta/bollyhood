<?php
include('../constant.php');
$ajax_action = isset($_POST['ajax_action']) ? $_POST['ajax_action'] :'';
$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again!!' );


function check_image($FILES,$params=array()){
	echo "<pre>";
	// print_r($FILES);
	// print_r($params);
	$result['check'] = false;
	$result['msg'] = "Something error";
	$result = array();
	if(!empty($FILES)){
		// echo $FILES['name'];
		$imageFileType = strtolower(pathinfo(basename($FILES['name']),PATHINFO_EXTENSION));
		$valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType;

		$result['file_ext'] = !empty($imageFileType) ? $imageFileType : '';
		$result['img_name'] = !empty($valid_imgname) ? $valid_imgname : '';
		$result['file_size'] = !empty($FILES['size']) ? $FILES['size'] : '0';

		if(isset($params['file_type']) && !empty($params['file_type'])){
			if(in_array($imageFileType, $params['file_type'])){
				$result['check'] = true;
				$result['msg'] = $imageFileType." Extension Matched";
				$result['file_type'] = array(
					'check' => true,
					'msg' => $imageFileType." Extension Matched",
				);
			}else{
				$result['file_type'] = array(
					'check' => false,
					'msg' => "Accept only ".implode(', ',$params['file_type'])." Extension Image only",
				);
				$result['check'] = false;
				$result['msg'] = "Accept only ".implode(', ',$params['file_type'])." Extension Image only";
			}	
		}
		if(isset($params['file_upload']) && !empty($params['file_upload']) && ($result['check']) && !empty($valid_imgname)){
			if (move_uploaded_file($FILES["tmp_name"], $params['file_upload'].$valid_imgname)){
				$result['check'] = true;
				$result['msg'] = "File Uploaded";
				$result['file_upload'] = array(
					'check' => true,
					'msg' => "File Uploaded",
				);
			}else{
				$result['file_upload'] = array(
					'check' => false,
					'msg' => "Problem on Image uploading",
				);
				$result['check'] = false;
				$result['msg'] = "Image not Uploaded";
			}	
		}

		
		// $result['file_tmp_name'] = !empty($FILES['tmp_name']) ? $FILES['tmp_name'] : '';
		if(!empty($result['file_type']) && !empty($result['img_name']) && !empty($result['file_size']) ){
			$result['check'] = true;
		}
		

	}

	return $result;
	

}
switch($ajax_action){
	case 'add_user':

		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );
		$temp = array(
			'name' => escapeStringTrim($_POST['name']),
			'email' => escapeStringTrim($_POST['email']),
			'mobile' => escapeStringTrim($_POST['mobile']),
			'status' => escapeStringTrim($_POST['status']),
			'cat_id' => escapeStringTrim($_POST['cat_id']),
			'modify_date' => date("Y-m-d H:i:s")
		);
		$temp['image'] = 'no_image.png';
		$image_flag = 0;

		$image = $_FILES['image'];
		
		$params = array();
		$params['file_type'] = VALID_IMG_EXT;
		$params['file_upload'] = '../resources/image/users/';
		
		$img_data = check_image($image,$params);
		print_r($img_data);
		die;

		
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
	default:
		echo json_encode(array('check' => 'failed' , 'msg'=>'Bad Request' ));
	break;
}
echo json_encode($response);
