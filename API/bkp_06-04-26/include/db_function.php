<?php
include_once('constant.php');
class DB_Function extends DB {
		
		// protected $conn;
		public $exeutedSql ='';
		public $mysqli_error ='';
		
		
		// constructor
		// function __construct() {
			// echo $this->checkResponse_Impl();
			// require_once 'DB_Connect.php';
			// // connecting to database
			// $db = new DB();
			// $conn = $db->Db_Connect();
			// $conn = $this->Db_Connect();
		// }
		
		// destructor
		function __destruct() {
			// $mysqli = $this->Db_Connect();
			// $mysqli->close();
		}
	
		//$link = connectme();
	   public function echoPrint($data)
		{
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	   public function echoVar($data)
		{
			echo "<pre>";
			print_r($data);
			echo "</pre>";
		}
	   public function debugSql()
		{
			echo "<br>".$this->exeutedSql;
			echo "<br>".$this->mysqli_error;
		}
	   public function escapeString($s)
		{
			$mysqli = $this->Db_Connect();
			return $mysqli->real_escape_string($s);
		}
	
	   public function escapeStringTrim($s, $t = ' ')
		{
			return $this->Db_Connect()->real_escape_string(trim($s, $t));
		}
		public function escapeStringTrimSpace($s, $t = ' ')
		{
			// preg_replace('/\s+/', ' ', trim(escapeString($_POST['medicine_name'])));
			return preg_replace('/\s+/', ' ', $this->Db_Connect()->real_escape_string(trim($s, $t)));
		}
	
	   public function getAffectedRowCount($sql)
		{
			$mysqli = $this->Db_Connect();
			$query =  $mysqli->query($sql);
			$this->exeutedSql = $sql; //store for debug
			return $query->num_rows;
		}
	   public function executeQuery($sql)
		{ //direct use with foreach
			$mysqli = $this->Db_Connect();
			return $mysqli->query($sql);
		}
	
	   public function getResultAsArray($sql)
		{
			$mysqli = $this->Db_Connect();
			$row = array();
			$this->exeutedSql = $sql;
			$query = $mysqli->query($sql);
			if ($query->num_rows > 0) {
				while ($result = mysqli_fetch_assoc($query)) {
					$row[] = $result;
				}
			}
			return $row;
		}
	public  function getSingleResult($sql){
				$mysqli = $this->Db_Connect();
				$row = array();
				$query = $mysqli->query($sql);
				if ($query->num_rows > 0) {
					while ($result = mysqli_fetch_assoc($query)) {
						$row = $result;
					}
				}
				return $row;
			}
		//public function getSingleResultArray($sql){ 
		// 	$mysqli = $this->Db_Connect();
		// 	 $query =  $mysqli->query($sql);
		// 	 if($query->num_rows > 0){
		// 	 	return $query->fetch_assoc();
		// 	 }else{
		// 	 	return array();
		// 	 }
		// }
	   public function executeInsert($table, $data, $onduplicatekey = array())
		{
			$mysqli = $this->Db_Connect();
			$dataStr = '';
			$duplicaterow ='';
			if (strlen($table) > 0) {
				$dataStr = 'INSERT INTO ' . $table;
				if (count($data) > 0) {
					$datarow = '';
					foreach ($data as $key => $value) {
						$datarow .= "{$key} = '{$value}',";
					}
					$datarownew = substr($datarow, 0, -1);
					$dataStr = $dataStr . ' SET ' . $datarownew;
				}
				if (count($onduplicatekey) > 0) {
					foreach ($onduplicatekey as $dkey => $dvalue) {
						$duplicaterow .= "{$dkey} = '{$dvalue}',";
					}
					$duplicaterownew = substr($duplicaterow, 0, -1);
					$dataStr = $dataStr . ' ON DUPLICATE KEY UPDATE ' . $duplicaterownew;
				}
			}
			// echo $dataStr;
			$this->exeutedSql = $dataStr;
			mysqli_set_charset($mysqli, 'utf8');
			$err = $mysqli->query($dataStr);
			if ($mysqli->error) {
				$this->mysqli_error = "Error description: " . $mysqli->error;
			}
			$result = $mysqli->insert_id;
			$mysqli->close();
			return $result;
		}
	
	   public function executeUpdate($table, $data, $clause)
		{
			$mysqli = $this->Db_Connect();
			$dataStr = '';
			if (strlen($table) > 0) {
				if (count($data) > 0) {
					$datarow = '';
					foreach ($data as $key => $value) {
						$datarow .= "{$key} = '{$value}',";
					}
					$datarownew = substr($datarow, 0, -1);
					$dataStr = $dataStr . $datarownew;
				}
			}
			$row_clause = '';
			$clause_array = array();
			if (strlen($table) > 0) {
				if (count($clause) > 0) {
					foreach ($clause as $key => $value) {
						$row_clause = "{$key} = '{$value}'";
						array_push($clause_array, $row_clause);
					}
					$clausenew = implode(" AND ", $clause_array);
				}
			}
			$this->exeutedSql= "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}";
			$result = mysqli_query($mysqli, "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}");
			return $result;
		}
	
	   public function executeSelect($table, $data = array(), $clause = array(), $orderby = "", $limit = array())
		{
			$mysqli = $this->Db_Connect();
			$dataStr = 'SELECT';
			$datanew = '';
			if (strlen($table) > 0) {
				if (count($data) > 0) {
					foreach ($data as $key => $value) {
						$datanew .= " {$value},";
					}
					$datan = substr($datanew, 0, -1);
					$dataStr = $dataStr . $datan;
				} else {
					$dataStr = $dataStr . ' * ';
				}
				$dataStr = $dataStr . ' FROM ' . $table;
				$row_clause = '';
				$clause_array = array();
				if (count($clause) > 0) {
					foreach ($clause as $key => $value) {
						$row_clause = "{$key}='{$value}'";
						array_push($clause_array, $row_clause);
					}
					$clausenew = implode(" AND ", $clause_array);
					$dataStr = $dataStr . ' WHERE ' . $clausenew;
				}
				if (strlen($orderby) > 0) {
					$dataStr = $dataStr . ' ORDER BY ' . $orderby;
				}
				if (count($limit) > 0) {
					$datalimit = '';
					foreach ($limit as $key => $value) {
						$datalimit .= " {$value},";
					}
					$datalimit = substr($datalimit, 0, -1);
					$dataStr = $dataStr . ' LIMIT ' . $datalimit;
				}
			}
			$this->exeutedSql = $dataStr;
			$report = mysqli_query($mysqli, $dataStr);
			$result = array();
			while ($queryreturn = mysqli_fetch_assoc($report)) {
				$result[] = $queryreturn;
			}
			return $result;
		}
	
	   public function executeSelectSingle($table_name, $fields = array(), $conditions = array(), $orderby = "")
		{
			$mysqli = $this->Db_Connect();
			$data = array();
			if (strlen($table_name) > 0) {
				$sql = "";
				if (count($fields) > 0) {
					$sql .= "SELECT " . implode(",", $fields) . " FROM " . $table_name;
				} else {
	
					$sql .= "SELECT * FROM " . $table_name;
				}
				$where = array();
				foreach ($conditions as $key => $value) {
					$where[] = $key . "='" . $value . "'";
				}
				if (count($where) > 0) {
					$sql .= " WHERE " . implode(" AND ", $where);
				}
				if (strlen($orderby) > 0) {
					$sql = $sql . ' ORDER BY ' . $orderby;
				}
				$sql .= " LIMIT 1";
				$this->exeutedSql = $sql;
				$query = mysqli_query($mysqli, $sql);
				if (mysqli_num_rows($query) > 0) {
					$data = mysqli_fetch_assoc($query);
				}
			}
			return $data;
		}
	
	   public function executeDelete($table, $clause)
		{
			$mysqli = $this->Db_Connect();
	
			$row_clause = '';
			$clause_array = array();
			if (strlen($table) > 0) {
				if (count($clause) > 0) {
					foreach ($clause as $key => $value) {
						$row_clause = "{$key} = '{$value}'";
						array_push($clause_array, $row_clause);
					}
					$clausenew = implode(" AND ", $clause_array);
				}
			}
			$this->exeutedSql = "DELETE FROM {$table} WHERE {$clausenew}";
			$result = mysqli_query($mysqli, "DELETE FROM {$table} WHERE {$clausenew}");
			return $result;
		}
	
	
	   public function executeTruncate($table)
		{
			global $mysql_connection;
			if (strlen($table) > 0) {
				$result = mysqli_query($mysql_connection, "TRUNCATE TABLE " . $table);
				return $result;
			} else {
				return false;
			}
		}
	
	   public function executeQueryToArray($res)
		{
			$result = array();
			if (mysqli_num_rows($res) > 0) {
				while ($row = mysqli_fetch_assoc($res)) {
					$result[] = $row;
				}
			}
			return $result;
		}
		public function detect_separator($string) {
			if (strpos($string, '/') !== false) {
				return '/';
			} elseif (strpos($string, '\\') !== false) {
				return '\\';
			}else{
				return '/';
			}
		}
		public static function remove_last_words_from_url($url, $parse) {
			// Split the URL into individual words
			$fn = new DB_Function();//obj
			$seperator = $fn->detect_separator($url);
			$words = explode($seperator, $url);
			// Remove the last two words
			if (count($words) >= $parse) {
				array_splice($words, -$parse);
			}
			$new_url = implode('/', $words);
			return $new_url;
		}
		public function separator_to_array($string, $separator = ','){
			$this->echoPrint($string);
			//Explode on comma
			$vals = explode($separator, $string);
			//Trim whitespace
			foreach($vals as $key => $val) {
				$vals[$key] = trim($val);
			}
			//Return empty array if no items found
			return array_diff($vals, array(""));
		}

		public function uploadSingleImage($FILES,$params=array()){
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
				if(!empty($result['file_type']) && !empty($result['img_name']) && !empty($result['file_size'])){
					$result['check'] = true;
				}
			}
			return $result;
		}
		public function uploadCustomFile($FILES,$params=array()){
			// echo "<pre>";
			// print_r($FILES);
			// print_r($params);
			$flag = false;
			$response['check'] = false;
			$response['msg'] = "Something error";
			// $result = array();
			if(!empty($FILES)){
				$imageFileType = strtolower(pathinfo(basename($FILES['name']),PATHINFO_EXTENSION));
				$valid_imgname = date('YmdHis')."_".rand('1000','9999').".".$imageFileType;
		
				$result['file_ext'] = !empty($imageFileType) ? $imageFileType : '';
				$result['file_name'] = !empty($valid_imgname) ? $valid_imgname : '';
				$result['file_size'] = !empty($FILES['size']) ? $FILES['size'] : '0';
				
				//file type not set then skip
				if(isset($params['file_type']) && !empty($params['file_type'])){
					if(in_array($imageFileType, $params['file_type'])){
						$flag = true;
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
				}else{
					$flag = true;
				}
				if(isset($params['file_upload']) && !empty($params['file_upload']) && !empty($valid_imgname) && $flag == true){
					if (move_uploaded_file($FILES["tmp_name"], $params['file_upload'].$valid_imgname)){
						$flag = true;
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
				if(!empty($result['file_type']) ){
					if(!empty($result['file_type']) && ($result['file_type']) && $result['file_type']['check'] == true && $result['check'] == true &&  $flag== true && !empty($result['file_name']) && !empty($result['file_size']) ){
						$response['check'] = true;
					}
				}
				else{//if file type not defined
					if(!empty($result['file_type']) && $result['check'] == true &&  $flag== true && !empty($result['file_name']) && !empty($result['file_size']) ){
						$response['check'] = true;
					}

				}
				
			}
		
			return $result;
			
		
		}
}		
?>
