<?php
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