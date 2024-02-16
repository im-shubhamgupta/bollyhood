<?php
//<!-- use sxrf for safe hit by session -->     
//this is use after submitting form
echoPrint($_POST);
$response = array('check'=>'error' , 'msg'=>'Access Denied');
if(isset($_SESSION['login']) && $_SESSION['login']=='y'){
	$db = new DB_Function();
	$submit_action = isset($_POST['submit_action']) ? $db->escapeStringTrim($_POST['submit_action']) : '';
	switch($submit_action){
		case 'add_category':
			$response = array('check' => 'failed' , 'msg'=>'Something error Please try again' );

			$data = array(
				'category_name' => $db->escapeStringTrim($_POST['category_name']),
			);
			if($_POST['id'] > 0){
				$id = $db->escapeStringTrim($_POST['id']);
				// $data['modify_date'] = date("Y-m-d H:i:s");

				$res = $db->executeUpdate('category',$data,array('id' => $id));
				if($res){
					$response['check'] = 'success';
					$response['msg'] = "Data Inserted Sucessfully";
				}	
			}else{
				$res = $db->executeInsert('category',$data);
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

echo json_encode($response);
}

//redirect('home',$msg);//you can set comma paramenter sessio flush


?>