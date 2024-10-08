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
		case 'bookings':
			include_once('action/all_booking.php');
		break;
		case 'expertise':
			include_once('action/all_expertise.php');
		break;
		case 'mod_expertise':
			include_once('action/mod_expertise.php'); 
		break;
		case 'sub_category':
			include_once('action/all_sub_category.php');
		break;
		case 'mod_sub_category':
			include_once('action/mod_sub_category.php');
		break;
		case 'plans':
			include_once('action/all_plans.php');
		break;
		case 'mod_plan':
			include_once('action/mod_plan.php');
		break;
		case 'casting':
			include_once('action/all_casting.php');
		break;
		case 'mod_casting':
			include_once('action/mod_casting.php');
		break;
		case 'casting_apply':
			include_once('action/casting_apply.php');
		break;
		case 'applied_users':
			include_once('action/applied_users.php');
		break;
		
		case 'user_details':
			include_once('action/user_details.php');
		break;
		case 'privacy-policy':
			include_once('action/privacy-policy.php');
		break;
		case 'terms-condition':
			include_once('action/terms-condition.php');
		break;
		case 'about-us':
			include_once('action/about-us.php');
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