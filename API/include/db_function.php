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
	
				
		public function get_company_list($id){
            $db = new DB();
			$conn = $db->Db_Connect();
			// $conn = $this->Db_Connect();
            $ComSql = "SELECT * from companies where `id`='$id'";
            $Cquery = $conn->query($ComSql);
            if($Cquery->num_rows>0){
                $row = $Cquery->fetch_assoc();
                $response['id']=$row['id'];
                $response['name']=$row['name'];
                return $response;
            }else{
                return '';
            }
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
			// $mysqli = $this->Db_Connect();
			// global $conn;
			return $this->Db_Connect()->real_escape_string(trim($s, $t));
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
			//echo $dataStr;
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
}		
			
?>
