<?php
function sessionSet($set){
	if(is_array($set)){

	
	}
}
function url($path){
	return SITE_URL.$path;
}
function urlAction($path){
	return SITE_URL.'?action='.$path;
}
function urlController($path){
	return SITE_URL.'?controller='.$path;
}
function asset($path){
	return RESOURCE_URL.$path;
}
function redirect($route='',$response=''){  
	if(!empty($response)){
		$_SESSION['flash'] = $response;
	}
	$action = ($route) ? '?action='.$route : '';
	header('location:'.SITE_URL.$action); //you can add timing for delay
	//echo "<script>window.location()</script>";
	die;
}
// function sessionflush($msg){
// 	$_SESSION['msg'] = $msg;
// }
function sessionFlash(){
	if(isset($_SESSION['flash'])){
		echo $_SESSION['flash']['msg'];
		unset($_SESSION['flash']);
		//after return not possiblle to unset
	}
}
function sessionFlashClear($msg=''){
	// if(empty($msg)){
		unset($_SESSION['flash']);
		// ($_SESSION['msg'] == $msg && isset($_SESSION['msg'])) ? unset($_SESSION['msg'] : '';
	// }else{
	// 	// (isset($_SESSION['msg'])) ? unset($_SESSION['msg'] : '';
	// }
}	
function uploadCustomFile($FILES,$params=array()){
	// echo "<pre>";
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
		$result['file_name'] = !empty($valid_imgname) ? $valid_imgname : '';
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
		if(!empty($result['file_type']) && !empty($result['file_name']) && !empty($result['file_size']) ){
			$result['check'] = true;
		}
	}

	return $result;
	

}
		