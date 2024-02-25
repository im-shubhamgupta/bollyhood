<?php
include('../constant.php');
$ajax_action = isset($_POST['ajax_action']) ? $_POST['ajax_action'] :'';
switch($ajax_action){
	case 'fetch_all_users':
		$requestData= $_REQUEST;
		$columns = array( 
			0 =>'id',
			1 =>'category_name',
			2 =>'create_date',
		);
		$sql="SELECT * from users where 1 "; 
		$totalData = getAffectedRowCount($sql);
		$totalFiltered = $totalData;  

		if($requestData['search']['value'] ) {  
			$sql.=" AND ( 1 ";
			$sql.=" OR `name` LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR `email` LIKE '%".$requestData['search']['value']."%' ";
			$sql.=" OR `mobile` LIKE '%".$requestData['search']['value']."%' ";
			$sql.= " )";
		}
		$totalFiltered = getAffectedRowCount($sql); 

		//$sql .="ORDER BY id desc"; 

		$sql .=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
		$i=1;
		$arr = executeQuery($sql);
		foreach($arr as $list) {  // preparing an array
			$td = array();
			$td[] = $i;
			$td[] = $list['name'];
			$td[] = $list['email'];
			$td[] = $list['mobile'];
			$td[] = $list['status'] == '1' ? 'Active' : 'Deactive' ;
			$td[] = $date=date('d-m-Y',strtotime($list["create_date"]));
			$td[] = '<span><a href="'.urlAction('mod_user&id='.$list['id']).'" class="btn btn-success btn-sm btn-icon waves-effect waves-themed">
                            <i class="fal fa-edit"></i>
                                                    </a></span>';
			$data[] = $td;
			$i ++;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside ,
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
		);

		echo json_encode($json_data);  
		die;
	break; 
 
	default:
		echo json_encode(array('check' => 'failed' , 'msg'=>'Bad Request' ));
	break;
}
