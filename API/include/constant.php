<?php
include_once(__DIR__."/connection.php");
header('Content-type: application/json; charset=utf-8');


//define("PATH_URL",$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/client/Github/bollyhood/');
define("PATH_URL",(empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]".'/admin/');



define("IMAGE_PATH",PATH_URL.'resources/image/');

define("BANNER_IMAGE_PATH",PATH_URL.'resources/image/banners/');
define("USER_IMAGE_PATH",PATH_URL.'resources/image/users/');
define("VALID_IMG_EXT", array('png','jpg','jpeg','PNG','JPG','JPEG'));


include_once(__DIR__."/db_function.php");
include_once(__DIR__."/db_controller.php");

?>