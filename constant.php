<?php
include_once("config.php");

$action = isset($_GET['action']) ? $_GET['action'] : '' ;
define("RESOURCE_URL",SITE_URL.'resources/');
define("DIR",__DIR__);//constant path

define("FILE_NAME", basename(parse_url($actual_link)['path'],'.php') );//remove.php


define("RESOURCE_VERSION",1);

define("IMAGE_PATH",SITE_URL.'resources/image/');
define("BANNER_IMAGE_PATH",SITE_URL.'resources/image/banners/');
define("USER_IMAGE_PATH",SITE_URL.'resources/image/users/');
define("EXPERTISE_IMAGE_PATH",SITE_URL.'resources/image/expertise/');
define("CATEGORY_IMAGE_PATH",SITE_URL.'resources/image/category/');
define("COMPANY_LOGO_PATH",SITE_URL.'resources/image/casting/');
define("COMPANY_DOC_PATH",SITE_URL.'resources/image/casting/document/');
define("CASTING_APPLY_IMAGES",SITE_URL.'resources/image/casting/apply/');
define("CASTING_APPLY_VIDEO",SITE_URL.'resources/image/casting/video/');

define("VALID_IMG_EXT", array('png','jpg','jpeg','PNG','JPG','JPEG'));
define("VALID_DOC_EXT", array('pdf'));

define('IMAGE_URL',DIR."/resources/css/img/");

const CAT = array(
    'other' => 'Other',
    'self' => 'Self',
    'company' => 'Company'
);
const CATEGORY_TYPE = array(
    '0' => 'Actor',
    '1' => 'Casting',
    '2' => 'Others'
);

const PLANS = array(
    'month' => 'Monthly',
    'year' => 'Yearly',
);
const SHIFTING = array(
    '6' => '6 Hours',
    '12' => '12 Hours',
);

class admin{
    const name = 'Admin';
    const image = 'Admin';
    const logo = 'Admin';
    const company_name = 'BollyHood';
    const email = 'bollyhoodapp@gmail.com';
    const address = 'Bokaro';
    const mobile = '7777777788';
    // const copyright =  admin::company_name;
    //$msg = date('Y') ;
    const copyright = " © ".admin::company_name;
    // const copyright =  date('Y') ." © ".admin::company_name. " ShubhamGupta" ;
}
// class mailer{
//     const host = 'smtp.gmail.com';
//     const port = '587';
//     const username = 'shubhamgupta309@gmail.com';
//     const sendername = 'ShubhamGupta';
//     const password = 'zwyhduclrclgrajd';
// }
class mailer{
    const host = 'smtp.gmail.com';
    const port = '587';
    const username = 'erptin@gmail.com';
    const sendername = 'ShubhamGupta';
    const password = 'muqrkcjpphroacuk';
}



//
// $action = basename($url, '.php'); //remove .php
// $url = 'http://learner.com/learningphp.php?lid=1348';
// $file_name = basename(parse_url($url, PHP_URL_PATH));


include_once(DIR."/db/db.php");
include_once(DIR."/library/myfunction.php");
// include_once(DIR."/db/mail.php");
// include_once(DIR."/db/DBcontroller.php");


