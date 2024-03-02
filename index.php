<?php
include_once('constant.php');

$controller = isset($_GET['controller']) ? $_GET['controller'] : '';
switch($controller){	
	case 'auth_controller':
		include_once('controller/auth_controller.php');
	break;
	case 'form-controller':
		include_once('controller/form-controller.php');
	break;
}

include_once(DIR.'/layout/header.php');

if(isset($_SESSION['login']) && $_SESSION['login']=='y'){
	include_once(DIR.'/layout/sidebar.php');
}

if(isset($_SESSION['login']) && $_SESSION['login']=='y'){
	switch ($action){
		case 'home':
			include_once('action/analytical.php');
		break;
		case 'users':
			include_once('action/all_users.php');
		break;
		case 'mod_user':
			include_once('action/mod_user.php');
		break;
		case 'banner':
			include_once('action/all_banner.php');
		break;
		case 'mod_banner':
			include_once('action/mod_banner.php');
		break;
		case 'category':
			include_once('action/all_category.php');
		break;
		case 'mod_category':
			include_once('action/mod_category.php');
		break;
		default :
			if(isset($_GET['action']) && empty($_GET['action'])){
				die("no action found");
			}elseif(isset($_GET['action']) && !empty($_GET['action'])){
				die("Error 404");
			}
			else{
				include_once('action/analytical.php');
			}
		break;
	}
}else{
	include_once('action/login.php');
}
include_once(DIR.'/layout/footer.php');
?>