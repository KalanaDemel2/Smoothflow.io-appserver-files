<?php
	session_start();
	require_once ("include/config.php");
	require_once ("include/session.php");
	header('Access-Control-Allow-Origin: *');
 	header('Access-Control-Allow-Methods: GET, POST');
	
	if(isset($_GET["logout"])){
		setcookie ("securityToken", "", time() - 3600, "/", $GLOBALS['mainDomain']);
		setcookie ("authData", "", time() - 3600, "/", $GLOBALS['mainDomain']);
		unset($_COOKIE["securityToken"]);
		unset($_COOKIE["authData"]);
		unset($_SESSION);
		header("Location: ".$GLOBALS['protacall']."://".$mainDomain."/logout.php");
		//echo $_SERVER['HTTP_HOST'] . " - Logout ";
		exit();
	}
	//exit();
	if(isset($_GET["SID"])){
		session_id($_GET["SID"]);
	}
	if (isset($_GET["r"])){
		//$_COOKIE['h']=$_GET["r"];
		setcookie("h", $_GET["r"]);
	}
	
	if (isset($_GET["securityToken"])){
		//echo "string";
		setcookie("securityToken", $_GET["securityToken"]);
		//$_COOKIE["securityToken"] = $_GET["securityToken"];
		if(createSessionDmian()){
			if(isset($_COOKIE['h'])){
				header("Location: ".$_COOKIE['h']."?securityToken=".$_COOKIE["securityToken"]);
				cookie_unset('h');
				//echo $_COOKIE['h'];
				exit();		
			}
			else{
				//echo "no cookie";
				header("Location: /");
				exit();
			}
		}
		else
		{
			header("Location:".$GLOBALS['protacall']."://".$mainDomain."/login.php?r=".$GLOBALS['protacall']."://".$_SERVER['HTTP_HOST']."/s.php");
			exit();
		}
	}
	//if(isset())
	if(!isset($_COOKIE["securityToken"])){
		if($mainDomain!=$_SERVER['HTTP_HOST'])
		{
			header("Location:".$GLOBALS['protacall']."://".$mainDomain."/login.php?r=".$GLOBALS['protacall']."://".$_SERVER['HTTP_HOST'].'/s.php');
		}
		else
		{
			header("Location: ".$GLOBALS['protacall']."://".$mainDomain."/login.php?r=".$GLOBALS['protacall']."://".$_SERVER['HTTP_HOST'].'/s.php');
		}
		//echo "string";
		exit();
	}
	else
	{
		if(isset($_COOKIE['h'])){
			header("Location: ".$_COOKIE['h']."?securityToken=".$_COOKIE["securityToken"]);
			cookie_unset('h');
			//session_unset('r');
			exit();		
		}
		else
		{
			header("Location: /");
			exit();
		}
	}
	
	
	//if(isset(var))
	if(isset($_GET["l"]))
	{
		header("Location: ".$GLOBALS['protacall']."://".$_GET["l"]."/s.php?securityToken=".$_COOKIE["securityToken"]);
		exit();
	}
?>
