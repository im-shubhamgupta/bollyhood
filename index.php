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
	case 'doc_controller':
		include_once('controller/document_controller.php');
	break;
}


include_once(DIR.'/layout/header.php');

//if(isset($_SESSION['login']) && $_SESSION['login']=='y'){

	
// }
//echo 123445; die;
// echoPrint($_SESSION);  
if(isset($_SESSION['login']) && $_SESSION['login']=='y'){
	include_once(DIR.'/layout/sidebar.php');
	$db = new DB_Function();
	switch ($action){
		// case 'login':
		// 	include_once('action/login.php');
		// break;
		case 'home':
			include_once('action/analytical.php');
		break;
		case 'all_data':
			include_once('action/all_data.php');
		break;
		case 'form':
			include_once('action/add_data.php');
		break;
		case 'add_document':
			include_once('action/mod_document.php');
		break;
		case 'all_document':
			include_once('action/all_document.php');
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
			}else{
				echo "hello";
				include_once('action/analytical.php');
			}
		break;
	}
}else{
	include_once('action/login.php');
}
include_once(DIR.'/layout/footer.php');
?>