<?php
if(isset($_GET['debug'])){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// require_once __DIR__ . '/resources/vendor/autoload.php';

// use Dotenv\Dotenv;

// $dotenv = Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// print_r($_SERVER);  //worked
// print_r(getenv());  //worked

$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $env = parse_ini_file($envFile);//use file()
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}
else{
  die("sorry .env file not found");  
}

session_start();

define("DB_HOSTNAME", getenv('DB_HOST'));
define("DB_USERNAME", getenv('DB_USERNAME'));
define("DB_PASSWORD", getenv('DB_PASSWORD'));
define("DB_",getenv('DB_DATABASE'));

if(!empty(DB_HOSTNAME) ||  !empty(DB_USERNAME) || !empty(DB_PASSWORD) || !empty(DB_)){

  $mysqli = new mysqli(DB_HOSTNAME,DB_USERNAME,DB_PASSWORD,DB_);
  // Check connection
  if ($mysqli -> connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli -> connect_error; 
    exit();
  }
}else{
  die("sorry, Credential not Found"); 
}

ob_start();
// ob_start("ob_gzhandler");

date_default_timezone_set('Asia/Kolkata');
    
$actual_link = ((empty($_SERVER['HTTPS'])) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

define("SITE_URL",$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/client/Github/bollyhood/admin/');

$custom_path = isset(parse_url(SITE_URL)['path']) && !empty(parse_url(SITE_URL)['path']) ? rtrim(parse_url(SITE_URL)['path'],'/') : '';

$real_path = isset(pathinfo($_SERVER['REQUEST_URI'])['dirname']) && !empty(pathinfo($_SERVER['REQUEST_URI'])['dirname']) ? pathinfo($_SERVER['REQUEST_URI'])['dirname'] : '';
// echo "<br>".
// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";

// if(!stripos($_SERVER['REQUEST_URI'],$custom_path)){
//   die("Please set url path"); 
// }
// if($custom_path != $real_path){
//   die("Please set url path"); 
// }



?>