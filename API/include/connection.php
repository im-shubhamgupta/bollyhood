<?php

class DB {
    public $mysqli = NULL;
    // public $conf = NULL;
    
    public function __construct() {
        $this->mysqli = $this->db_Connect(); // Initiate Database connection store in variable
    }
    protected function Db_Connect() {
        require_once ("../config.php");
        return $this->mysqli = new mysqli("localhost","root","","client_bollyhood");
        //$this->mysqli = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_);
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