<?php

if(isset($_GET['debug'])){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

session_start();
define("DB_HOSTNAME", "localhost" );
define("DB_USERNAME", "root" );
define("DB_PASSWORD", "" );
define("DB_", "self_evokewise" );

$mysqli = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_);
// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error; 
  exit();
}

ob_start();

date_default_timezone_set('Asia/Kolkata');
    
$actual_link = ((empty($_SERVER['HTTPS'])) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";


define("SITE_URL",$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/client/Github/document_container/');

?>