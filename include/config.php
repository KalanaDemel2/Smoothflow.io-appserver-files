<?php
$mainDomain="smoothflow.io";
$authURI="http://auth.smoothflow.io:3048/";
$objURI="http://obj.smoothflow.io:3000/";
$fullhost=strtolower($_SERVER['HTTP_HOST']);
$protacall="http";
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
define("MEDIA_PATH", "/var/media");
define("APPICON_PATH", "/var/www/html/devportal/appicons");
        //define("BASE_PATH", "/var/www/html/medialib");
        //define("STORAGE_PATH", BASE_PATH . "/media");
        //define("THUMB_PATH", BASE_PATH . "/thumbnails");
define("SVC_OS_URL", "http://obj.smoothflow.io:3000");
define("SVC_OS_BULK_URL", "http://obj.smoothflow.io:3001/transfer");
define("SVC_AUTH_URL", "http://auth.smoothflow.io:3048");
define("SVC_CEB_URL", "http://ceb.smoothflow.io:3500");
define("SVC_SMOOTHFLOW_URL", "http://smoothflow.io");
define ("STRIPE_KEY","sk_test_ujsydm6IgtDJ49L74x7sj4x7");
?>