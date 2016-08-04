<?php

require_once ("include/config.php");
require_once ("include/session.php");

$fullHost = strtolower($_SERVER['HTTP_HOST']);

switch ($fullHost) {
    case $mainDomain: // smoothflow.io
        if(!isset($_COOKIE["securityToken"])){
			header("location:http://qa.smoothflow.io");
		}
        else{
            getURI();
		}
        break;
    case "qa." . $mainDomain: // qa.smoothflow.io
        if(!isset($_COOKIE["securityToken"])){
            include ("index1.php");	
		}else{
		    getURI();
		}
        break;
    default:
    if(!isset($_COOKIE["securityToken"])) {
        if($mainDomain != $_SERVER['HTTP_HOST']){ 
            header("Location: http://qa.". $mainDomain . "/login.php?r=http://" . $_SERVER['HTTP_HOST'] . '/s.php'); 
		}
        exit();
    }
	getURI();
    break;
}
?>



