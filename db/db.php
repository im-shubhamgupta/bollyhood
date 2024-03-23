<?php
function connectme(){
	global $mysqli; 
	return $mysqli;
}

//$link = connectme();
function echoPrint($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
function echoVar($data){
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}
function debugSql($query='',$sql=''){
	global $mysqli;
	//echo "<br><br>A>: ".$mysqli -> info;
	if(isset($_SESSION['sql'])){
		echo "<br><br>B>: ".$_SESSION['sql']."<br>";
	}
	//echo "<br><br>C>: ".$mysqli -> host_info;
	// echo "<br><br>D>: ".echoVar($mysqli -> get_charset());
	//echo "<br><br>E>: ".$mysqli -> server_info;
	//echo "<br><br>F>: ".mysqli_dump_debug_info($mysqli);   
	if($mysqli->error){
		echo "<br>G>: Error description: " . $mysqli->error;
	}else{
		echo '<br>G>: !!!No Error Found!!!<br>';
	}
}	 
function escapeString($s){
	global $mysqli;
 return $mysqli->real_escape_string($s);
}

function escapeStringTrim($s,$t=' '){
    global $mysqli;
 return $mysqli->real_escape_string(trim($s,$t));
}

function getAffectedRowCount($sql){ 
	global $mysqli;
	 $query =  $mysqli->query($sql);
	 return $query->num_rows;
}
function executeQuery($sql){ //direct use with foreach
	global $mysqli;
	return $mysqli->query($sql); 
}

function getResultAsArray($sql){
	global $mysqli; 
	$row = array(); 
	$query = $mysqli->query($sql);
	if($query->num_rows > 0){
		while($result = mysqli_fetch_assoc($query)){
			$row[] = $result; 
		}
    }
	return $row;
 }
 function getSingleResult($sql){
	global $mysqli; 
	$row = array(); 
	$query = $mysqli->query($sql);
	if($query->num_rows > 0){
		while($result = mysqli_fetch_assoc($query)){
			$row = $result; 
		}
    }
	return $row;
 } 
// function getSingleResultArray($sql){ 
// 	global $mysqli;
// 	 $query =  $mysqli->query($sql);
// 	 if($query->num_rows > 0){
// 	 	return $query->fetch_assoc();
// 	 }else{
// 	 	return array();
// 	 }
// }
function executeInsert($table, $data, $onduplicatekey = array()){ 
	global $mysqli; 
	$duplicaterow ='';
	$dataStr = '';
	 if (strlen($table) > 0){
    	  $dataStr = 'INSERT INTO '.$table;
    	  if (count($data) > 0){
    	 $datarow = ''; foreach ($data as $key => $value){ $datarow.="{$key} = '{$value}',"; } $datarownew = substr($datarow, 0, -1); $dataStr = $dataStr.' SET '.$datarownew;
    	  }
    	  if (count($onduplicatekey) > 0){
    	   foreach ($onduplicatekey as $dkey => $dvalue){
    	    $duplicaterow.="{$dkey} = '{$dvalue}',";
    	     } 
    	     $duplicaterownew = substr($duplicaterow, 0, -1); $dataStr = $dataStr.' ON DUPLICATE KEY UPDATE '.$duplicaterownew; 
    	} 
	} 
	// echo $dataStr;
	$_SESSION['sql'] = $dataStr;
	mysqli_set_charset($mysqli,'utf8');
	$err = $mysqli->query($dataStr);
	if($mysqli->error){
		// debugSql();
		//echo "<br>Error description: " . $mysqli->error;
	}	
	$result = $mysqli->insert_id;
	// $mysqli->close();
 	return $result;
}

function executeUpdate($table, $data, $clause){
	global $mysqli;
	$dataStr = '';
	if (strlen($table) > 0){
		if (count($data) > 0){ $datarow = '';
			foreach ($data as $key => $value){
				$datarow.="{$key} = '{$value}',"; 
			}
			 $datarownew = substr($datarow, 0, -1);
			  $dataStr = $dataStr.$datarownew; 
		}
	}
	 $row_clause = ''; $clause_array = array();
	  if (strlen($table) > 0){ if(count($clause) > 0){
		 foreach ($clause as $key => $value){ $row_clause ="{$key} = '{$value}'";
		  array_push($clause_array, $row_clause); 
		} $clausenew = implode(" AND " ,$clause_array); 
	} } 
	$_SESSION['sql'] = "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}";
	$result = mysqli_query($mysqli, "UPDATE {$table} SET {$dataStr} WHERE {$clausenew}");
	      return $result; } 

function executeSelect($table, $data = array(), $clause = array(), $orderby = "", $limit = array()){ 
	global $mysqli; 
	$dataStr = 'SELECT'; $datanew = ''; 
	if (strlen($table) > 0){
	    if (count($data) > 0){
	     	foreach ($data as $key => $value){
	     	    $datanew.=" {$value},"; }
	     	    $datan = substr($datanew, 0, -1); $dataStr = $dataStr.$datan;
	    }else{
	     	$dataStr = $dataStr.' * ' ; 
	    }
	     	$dataStr = $dataStr.' FROM '.$table ; $row_clause = ''; $clause_array = array();
	     	if(count($clause) > 0){
	     	   foreach ($clause as $key => $value){ 
	     	   	$row_clause ="{$key}='{$value}'"; array_push($clause_array, $row_clause); 
	     	   }
	     	    $clausenew = implode(" AND " ,$clause_array); $dataStr = $dataStr.' WHERE '.$clausenew; } 
	     	    if(strlen($orderby) > 0){
	     	     $dataStr = $dataStr.' ORDER BY '.$orderby;
	     	      }
	     	       if(count($limit) > 0){
	     	        foreach($limit as $key => $value){
	     	         $datalimit.=" {$value},"; } $datalimit = substr($datalimit, 0, -1); $dataStr = $dataStr.' LIMIT '.$datalimit; } 
	} 
	     	         $_SESSION['sql'] = $dataStr;
					 $report = mysqli_query($mysqli, $dataStr);
					  $result = array();
	     	          while($queryreturn = mysqli_fetch_assoc($report)){ 
	     	          	$result[] = $queryreturn; 
	     	          }
	     	          return $result;
}

function executeSelectSingle($table_name, $fields = array(), $conditions = array(), $orderby = ""){
	global $mysqli; $data = array(); if(strlen($table_name) > 0){
		$sql = ""; 
		if(count($fields) > 0){
			 $sql .= "SELECT " . implode(",", $fields) . " FROM " . $table_name; 
			}else{
				
				$sql .= "SELECT * FROM " . $table_name; 
			   } $where = array(); foreach($conditions as $key => $value){ $where[] = $key . "='" .$value."'"; 
			} 
			if(count($where) > 0){
				 $sql .= " WHERE " . implode(" AND ", $where); 
			} if(strlen($orderby) > 0){
				$sql = $sql.' ORDER BY '.$orderby; 
			}
			$sql .= " LIMIT 1";
			$_SESSION['sql'] = $sql;
			$query = mysqli_query($mysqli, $sql);
			if(mysqli_num_rows($query) > 0){
				 $data = mysqli_fetch_assoc($query);
			} }
			 return $data;
}

function executeDelete($table, $clause){ 
	global $mysqli;

	$row_clause = '';
	$clause_array = array();
	if (strlen($table) > 0){
		 if(count($clause) > 0){ foreach ($clause as $key => $value){ $row_clause ="{$key} = '{$value}'"; array_push($clause_array, $row_clause); } $clausenew = implode(" AND " ,$clause_array); } } 
	     	   $result = mysqli_query($mysqli, "DELETE FROM {$table} WHERE {$clausenew}"); return $result;
	     	   }


	     	   function executeTruncate($table){ global $mysql_connection; if (strlen($table) > 0){
	     	    $result = mysqli_query($mysql_connection, "TRUNCATE TABLE ".$table); return $result; }else{ return false; } } 

	     	    function executeQueryToArray($res){ $result = array(); if (mysqli_num_rows($res) > 0) { 

	     	    	while($row = mysqli_fetch_assoc($res)) {

	     	     $result[] = $row; } } return $result; }



	 