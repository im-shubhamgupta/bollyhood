<?php

class DB_Function {
		
	// global $mysqli;

	public $sql ='';
	public $conn = global $mysqli;
	public $mysqli_error ='';
	
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
   	public function debugSql()
	{
		echo "<br>".$this->sql;
		echo "<br>".$this->mysqli_error;
	}
   	public function escapeString($s)
	{
		$mysqli = $this->Db_Connect();
		return $mysqli->real_escape_string($s);
	}

   	public function escapeStringTrim($s, $t = ' ')
	{
		return $this->$conn->real_escape_string(trim($s, $t));
	}

   	public function getAffectedRowCount($sql)
	{
		$mysqli = $this->$conn;
		$query =  $mysqli->query($sql);
		$this->sql = $sql; //store for debug
		return $query->num_rows;
	}
   	public function executeQuery($sql)
	{ //direct use with foreach
		$mysqli = $this->$conn;
		return $mysqli->query($sql);
	}

   	public function getResultAsArray($sql)
	{
		$mysqli = $this->$conn;
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
			$mysqli = $this->$conn;
			$row = array();
			$query = $mysqli->query($sql);
			if ($query->num_rows > 0) {
				while ($result = mysqli_fetch_assoc($query)) {
					$row = $result;
				}
			}
			return $row;
		}
   	public function executeInsert($table, $data, $onduplicatekey = array())
	{
		$mysqli = $this->$conn;;
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
		$this->sql = $dataStr;
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
		$mysqli = $this->$conn;
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
		$_SESSION['sql'] = "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}";
		$result = mysqli_query($mysqli, "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}");
		return $result;
	}

    public function executeSelect($table, $data = array(), $clause = array(), $orderby = "", $limit = array())
	{
		$mysqli = $this->$conn;
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
		$_SESSION['sql'] = $dataStr;
		$report = mysqli_query($mysqli, $dataStr);
		$result = array();
		while ($queryreturn = mysqli_fetch_assoc($report)) {
			$result[] = $queryreturn;
		}
		return $result;
	}

    public function executeSelectSingle($table_name, $fields = array(), $conditions = array(), $orderby = "")
	{
		$mysqli = $this->$conn;
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
			$_SESSION['sql'] = $sql;
			$query = mysqli_query($mysqli, $sql);
			if (mysqli_num_rows($query) > 0) {
				$data = mysqli_fetch_assoc($query);
			}
		}
		return $data;
	}

    public function executeDelete($table, $clause)
	{
		$mysqli = $this->$conn;
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
		$mysql_connection = $this->$conn;
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
}		
	 