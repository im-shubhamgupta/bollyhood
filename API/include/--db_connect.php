<?php
class DB_Connect {
    private $conn;

    public function connect() {
        //require_once 'config.php';
        $conn = new mysqli("localhost","root","","psoft_crm_demo");

        return $conn;
    }
}