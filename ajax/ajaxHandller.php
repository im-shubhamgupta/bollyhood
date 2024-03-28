<?php
include('../constant.php');
$ajax_action = isset($_POST['ajax_action']) ? $_POST['ajax_action'] : '';
$response = array('check' => 'failed', 'msg' => 'Something error, Please try again!!');
switch ($ajax_action) {
	case 'add_user':

		$response = array('check' => 'failed', 'msg' => 'Something error, Please try again');
		$temp = array(
			'name' => escapeStringTrim($_POST['name']),
			'email' => escapeStringTrim($_POST['email']),
			'mobile' => escapeStringTrim($_POST['mobile']),
			'status' => escapeStringTrim($_POST['status']),
			'cat_id' => escapeStringTrim($_POST['cat_id']),
			'image' => escapeStringTrim($_POST['user_image']),
			'is_subscription' => (isset($_POST['is_subscription']) && $_POST['is_subscription'] == 'on') ? '1' : '0',
			'modify_date' => date("Y-m-d H:i:s")
		);
		// $temp['image'] = 'no_image.png';

		$image = $_FILES['image'];
		$image_flag = 0;
		if (isset($_FILES['image']) && !empty(($_FILES['image']['name']))) {
			$imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION));
			$valid_imgname = date('YmdHis') . "_" . rand('1000', '9999') . "." . $imageFileType;
			if (in_array($imageFileType, VALID_IMG_EXT)) {
				$image_flag = 1;
			} else {
				$response['msg'] = "Accept only .png, .jpg, .jpeg Extension Image only";
			}
		}
		if ($image_flag == 1) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], '../resources/image/users/' . $valid_imgname)) {
				$temp['image'] = $valid_imgname;
			}
		}
		$id = isset($_POST['id']) ? escapeString($_POST['id']) : '';
		$id_sql = !empty($id) ? " AND id != $id " :  '';
		$mob = getAffectedRowCount("SELECT `id` from  users where mobile = '" . $temp['mobile'] . "' $id_sql ");
		if (!empty($mob)) {
			$response['check'] = 'already';
			$response['msg'] = 'Mobile no Already Exist';
		}
		$email = getAffectedRowCount("SELECT `id` from  users where email = '" . $temp['email'] . "' $id_sql ");
		if (!empty($email)) {
			$response['check'] = 'already';
			$response['msg'] = 'Email Already Exist';
		}
		// print_r($temp);
		// print_r($id);
		if ($response['check'] != 'already') {
			if (!empty($id)) {
				$up = executeUpdate('users', $temp, array('id' => $id));
				if ($up) {
					$response['check'] = 'success';
					$response['msg'] = 'Data Updated Successfully';
				}
			} else {
				$temp['create_date'] = date("Y-m-d H:i:s");
				$temp['password'] = 123456;
				$insert = executeInsert('users', $temp);
				if ($insert > 0) {
					$response['check'] = 'success';
					$response['msg'] = 'Data Inserted Successfully';
				}
			}
		}
		echo json_encode($response);
		die;
		break;

	case 'add_banner':

		$response = array('check' => 'failed', 'msg' => 'Something error, Please try again');

		$image_flag = 0;
		if (isset($_FILES['banner_image']) && !empty(($_FILES['banner_image']['name']))) {
			$imageFileType = strtolower(pathinfo(basename($_FILES['banner_image']['name']), PATHINFO_EXTENSION));
			$valid_imgname = date('YmdHis') . "_" . rand('1000', '9999') . "." . $imageFileType;
			if (in_array($imageFileType, VALID_IMG_EXT)) {
				$image_flag = 1;
			} else {
				$response['msg'] = "Accept only .png, .jpg, .jpeg Extension Image only";
			}
		}
		if ($image_flag == 1) {
			$id = isset($_POST['id']) ? escapeString($_POST['id']) : '';
			$data['banner_image'] =  $valid_imgname;
			$data['create_date'] =  date('Y-m-d H:i:s');
			if (move_uploaded_file($_FILES["banner_image"]["tmp_name"], '../resources/image/banners/' . $valid_imgname)) {
				if ($id > 0) {
					$update = executeUpdate('banners', $data, array('id' => $id));
					if ($update) {
						$response['check'] = 'success';
						$response['msg'] = 'Data Updated Successfully';
					}
				} else {
					$insert = executeInsert('banners', $data);
					if ($insert) {
						$response['check'] = 'success';
						$response['msg'] = 'Data Inserted Successfully';
					}
				}
			} else {
				$response['msg'] = 'Something problem on image uploading';
			}
		}
		echo json_encode($response);
		die;
		break;
	case "delete_banner":
		$id = escapeString($_POST['id']);
		if (!empty($id)) {
			$del = executeDelete('banners', array('id' => $id));
			if ($del) {
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			} else {
				$response['msg'] = 'Error Happend';
			}
		} else {
			$response['msg'] = 'Delete id not found';
		}
		break;
	case "delete_user":
		$id = escapeString($_POST['id']);
		if (!empty($id)) {
			$del = executeDelete('users', array('id' => $id));
			if ($del) {
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			} else {
				$response['msg'] = 'Error Happend';
			}
		} else {
			$response['msg'] = 'Delete id not found';
		}
		break;
	case "delete_category":
		$id = escapeString($_POST['id']);
		if (!empty($id)) {
			$del = executeDelete('category', array('id' => $id));
			if ($del) {
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			} else {
				$response['msg'] = 'Error Happend';
			}
		} else {
			$response['msg'] = 'Delete id not found';
		}
		break;
	case 'mod_expertise':
		// ini_set('display_errors', 1);
		// ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);

		$response = array('check' => 'failed', 'msg' => 'Something error, Please try again');
		$temp = array(
			'name' => escapeStringTrim($_POST['name']),
			'mobile' => escapeStringTrim($_POST['mobile']),
			'reviews' => escapeStringTrim($_POST['reviews']),
			'jobs_done' => escapeStringTrim($_POST['jobs_done']),
			'description' => escapeStringTrim($_POST['description']),
			// 'work_links' => escapeStringTrim($_POST['work_links']),
			'is_verify' => (isset($_POST['is_verify']) && $_POST['is_verify'] == 'on') ? '1' : '0',
			'categories' => trim(implode(',', $_POST['cat_id']), ','),
			'modify_date' => date("Y-m-d H:i:s")
		);
		$temp['user_image'] = escapeStringTrim($_POST['user_image']);

		// echoprint($_POST);
		// die;
		$image = $_FILES['image'];
		$image_flag = 0;
		// print_r($_FILES);
		if (isset($_FILES['image']) && !empty(($_FILES['image']['name']))) {
			$imageFileType = strtolower(pathinfo(basename($_FILES['image']['name']), PATHINFO_EXTENSION));
			$valid_imgname = date('YmdHis') . "_" . rand('1000', '9999') . "." . $imageFileType;
			if (in_array($imageFileType, VALID_IMG_EXT)) {
				$image_flag = 1;
			} else {
				$response['msg'] = "Accept only .png, .jpg, .jpeg Extension Image only";
			}
		}
		if ($image_flag == 1) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], '../resources/image/expertise/' . $valid_imgname)) {
				$temp['user_image'] = $valid_imgname;
			}
		}
		$id = isset($_POST['id']) ? escapeString($_POST['id']) : '';

		if (!empty($id)) {
			$up = executeUpdate('expertise', $temp, array('id' => $id));

			if (!empty($_POST['worklink_name'])) {
				executeDelete('expertise_worklink', array('expertise_id' => $id));

				foreach ($_POST['worklink_name'] as $k => $val) {
					$work_arr = array(
						'expertise_id' => $id,
						'worklink_name' => $_POST['worklink_name'][$k],
						'worklink_url' => $_POST['worklink_url'][$k],
						'date_added' => date("Y-m-d H:i:s"),
					);
					$exp_insert = executeInsert('expertise_worklink', $work_arr);
				}
			}
			if ($up) {
				$response['check'] = 'success';
				$response['msg'] = 'Data Updated Successfully';
			}
		} else {
			$temp['create_date'] = date("Y-m-d H:i:s");
			$insert = executeInsert('expertise', $temp);

			//insert_worklinks
			if (!empty($_POST['worklink_name'])) {
				foreach ($_POST['worklink_name'] as $k => $val) {
					$work_arr = array(
						'expertise_id' => $insert,
						'worklink_name' => $_POST['worklink_name'][$k],
						'worklink_url' => $_POST['worklink_url'][$k],
						'date_added' => date("Y-m-d H:i:s"),
					);
					// print_R($work_arr);
					$exp_insert = executeInsert('expertise_worklink', $work_arr);
				}
			}
			if ($insert > 0) {
				$response['check'] = 'success';
				$response['msg'] = 'Data Inserted Successfully';
			}
		}

		echo json_encode($response);
		die;
		break;
	case "delete_expertise":
		$id = escapeString($_POST['id']);
		if (!empty($id)) {
			$del = executeDelete('expertise', array('id' => $id));
			if ($del) {
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			} else {
				$response['msg'] = 'Error Happend';
			}
		} else {
			$response['msg'] = 'Delete id not found';
		}
		break;
	case "delete_sub_category":
		$id = escapeString($_POST['id']);
		if (!empty($id)) {
			$del = executeDelete('sub_category', array('sub_cat_id' => $id));
			if ($del) {
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			} else {
				$response['msg'] = 'Error Happend';
			}
		} else {
			$response['msg'] = 'Delete id not found';
		}
		break;
	case "delete_subscription_plan":
		$id = escapeString($_POST['id']);
		if (!empty($id)) {
			$del = executeDelete('subscription_plan', array('plan_id' => $id));
			if ($del) {
				$response['check'] = 'success';
				$response['msg'] = 'Delete Successfully';
			} else {
				$response['msg'] = 'Error Happend';
			}
		} else {
			$response['msg'] = 'Delete id not found';
		}
		break;		
	case 'add_sub_category':
		// echoPrint($_POST);
		$sub_cat_id = isset($_POST['id'])?  escapeString($_POST['id']) : '' ;
		$temp = array(
			'category_id' => escapeString($_POST['category_id']),
			'sub_cat_name' => escapeString($_POST['sub_cat_name']),
			'modify_date' => date('Y-m-d H:i:s')
		);
		if ($sub_cat_id > 0) {
			$temp['modify_date'] =
				$update = executeUpdate('sub_category', $temp, array('sub_cat_id' => $sub_cat_id));
			if ($update) {
				$response['check'] = 'success';
				$response['msg'] = 'Data Updated Successfully';
			}
		} else {
			$temp['create_date'] = date('Y-m-d H:i:s');
			$insert = executeInsert('sub_category', $temp);
			if ($insert) {
				$response['check'] = 'success';
				$response['msg'] = 'Data Inserted Successfully';
			}
		}
		echo json_encode($response);
		die;
		break;
	case 'mod_subscription_plan':
			// echoPrint($_POST);
			$plan_id = isset($_POST['id'])?  escapeString($_POST['id']) : '' ;
			$temp = array(
				'type' => escapeStringTrim($_POST['type']),
				'title' => escapeStringTrim($_POST['title']),
				'price' => escapeStringTrim($_POST['price']),
				'description' => escapeStringTrim($_POST['description']),
			);
			//  {
				$temp['date_added'] = date('Y-m-d H:i:s');
				$insert = executeInsert('subscription_plan', $temp);
				if ($insert) {
					$response['check'] = 'success';
					$response['msg'] = 'Data Inserted Successfully';
				}
			// }
			echo json_encode($response);
			die;
			break;
	case 'mod_cms_readme':
		// echoPrint($_POST);
		$type = isset($_POST['id'])?  escapeString($_POST['id']) : '' ;
		$description = ($_POST['description']) ? escapeString($_POST['description']) : ''; 
		
		$check = executeSelectSingle('cms_readme',array(),array('type'=>$type));
		// print_r($check);
		if(empty($check)){
			executeInsert('cms_readme',array('type'=>$type,'description'=> $description,'create_date'=>date('Y-m-d H:i:s'),'modify_date'=>date('Y-m-d H:i:s')));
			$response['check'] = 'success';
			$response['msg'] = 'Data Inserted Successfully';
		}else{
			executeUpdate('cms_readme',array('description'=> $description,'modify_date'=>date('Y-m-d H:i:s')),array('type'=>$type));
			$response['check'] = 'success';
			$response['msg'] = 'Data Updated Successfully';
		}
		echo json_encode($response);
		die;
		break;		
	default:
		echo json_encode(array('check' => 'failed', 'msg' => 'Bad Request'));
		break;
}
echo json_encode($response);
