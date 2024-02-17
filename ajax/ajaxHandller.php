<?php
include('../constant.php');
// echoPrint($_REQUEST);
$ajax_action = isset($_POST['ajax_action']) ? $_POST['ajax_action'] :'';
if(isset($_SESSION['login']) && $_SESSION['login']=='y'){
$db= new DB_Function();	
switch($ajax_action){
	case 'check_category_exist':
		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );
		$category_name = $_POST['category_name'];
		$id = $_POST['id'];
		if($id > 0){//update case
			 $sql = "SELECT * from category where category_name = '".$category_name."' and id!='".$id."'";
		}else{
			$sql = "SELECT * from category where category_name = '".$category_name."' ";
		}
		 $result = $db->getAffectedRowCount($sql);
		if($result > 0){
			$response['check'] = 'already';
            $response['msg'] = 'Category already exist';
		}else{
			$response['check'] = 'success';
            $response['msg'] = '';
		}
		echo json_encode($response);
		break;
		
	case 'get_all_category_data':

		$requestData= $_REQUEST;
		// $table ='';
		$columns = array( 
			// 0 =>'id',
			// 1 =>'type',
			// 2 =>'name',
			// 3 =>'create_date',
			// 4 =>'create_date',
		);
		$sql="SELECT * from category where 1 "; 
		$totalData = $db->getAffectedRowCount($sql);
		$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.

		if($requestData['search']['value'] ) {  

			$sql.=" AND ( 1 ";
			$sql.=" OR `type` LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR `name` LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR `create_date` LIKE '%".$requestData['search']['value']."%' ";
			$sql.= " )";
		}
		$totalFiltered = $db->getAffectedRowCount($sql);  

		//$sql .=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$i=1;
		// $arr = executeQuery($sql);
		$arr = $db->getResultAsArray($sql);
		// echoPrint($arr);
		foreach($arr as $list) {  // preparing an array
			$td = array();
			// $td[] = $list['id'];
			$td[] = $list['type'];
			$td[] = $list['name'];

			$data[] = $td;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside ,
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
		);
		
		echo json_encode($json_data);
	break;
	case 'add_category_data':
		$response = array('check' => 'failed' , 'msg'=>'Something error, Please try again' );
		$temp = array(
			'type' => $db->escapeStringTrim($_POST['type']),
			'name' => $db->escapeStringTrim($_POST['category']),
			'create_date' => date("Y-m-d H:i:s")
		); 

		$insert = $db->executeInsert('category',$temp);

		// $data = executeSelectSingle('category',array(),$temp);
		if(!empty($insert) > 0){	
			$response['check'] = 'success';
            $response['msg'] = 'Data Inserted Successfully';
		}
		// debugSql();
		
		echo json_encode($response);
		die;
	break; 
	default:
		echo json_encode(array('check' => 'failed' , 'msg'=>'Bad Request' ));
	break;
}
}else{
	echo json_encode(array('check' => 'failed' , 'msg'=>'Login failed' ));
}
