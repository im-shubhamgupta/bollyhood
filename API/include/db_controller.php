<?php
include_once('constant.php');
class DB_Controller extends DB_Function{
    
    private $functions = NULL;
		private $conn = NULL;

		public function __construct() {
			// $this->conn = new DB();
			// $this->functions = new functions($this->db);
		}
            
    public function get_company_list($id){
        
        // $db = new DB();
        // $conn = $db->Db_Connect();
        // $conn = $this->Db_Connect(); 
        $conn = $this->Db_Connect(); 
        $ComSql = "SElECT * from companies where `id`='$id'";
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
  

}