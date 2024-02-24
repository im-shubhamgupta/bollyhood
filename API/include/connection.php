<?php

class DB {
//    public $mysqli = NULL;
    
    public function __construct() { //call when create object
      // $this->mysqli = $this->db_Connect(); // Initiate Database connection store in variable
    }
    protected function Db_Connect() {
        require_once ("../config.php");
        return $conn = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_);
        //  $this->mysqli = $conn;
        //   if($conn){
        //     echo "connecteed";
        //   }else{
        //     echo "failed";
        //   }
        //$this->mysqli->query('SET CHARACTER SET utf8');
    }
    public function checkResponse_Impl() {
        $mysqli =  $this->Db_Connect();
        if (mysqli_ping($mysqli)){
            echo "Database Connection : Success";
        }else {
            echo "Database Connection : Error";
        }
    }
		
}
