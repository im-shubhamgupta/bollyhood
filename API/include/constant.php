<?php
include_once(__DIR__."/connection.php");
header('Content-type: application/json; charset=utf-8');


define("PATH_URL",(empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]");

define("IMAGE_PATH",PATH_URL.'/admin/resources/image/');
define("BANNER_IMAGE_PATH",IMAGE_PATH.'banners/');


include_once(__DIR__."/db_function.php");
include_once(__DIR__."/db_controller.php");

?>