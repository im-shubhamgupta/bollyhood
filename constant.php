<?php
include_once("config.php");

$action = isset($_GET['action']) ? $_GET['action'] : '' ;
define("RESOURCE_URL",SITE_URL.'/resources/');
define("DIR",__DIR__);//constant path

define("FILE_NAME", basename(parse_url($actual_link)['path'],'.php') );//remove.php


// const PAYMENT_STATUS = array(
//     0 => 'pending', 
//     1 => 'process' , 
//     2 => 'complete'
// );

// define('MEETING_URL', SITE_URL."/library/video/meeting.php");
define('IMAGE_URL',DIR."/resources/css/img/");

const CAT = array(
    'other' => 'Other',
    'self' => 'Self',
    'company' => 'Company'
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

include_once(DIR."/db/sessionHandller.php");
include_once(DIR."/db/db.php");
include_once(DIR."/library/myfunction.php");




