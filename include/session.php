<?php

//include ("include/config.php");

function createSessionDmian(){
	$Host = strtolower($_SERVER['HTTP_HOST']);
	//echo "$authURI";
	if(isset($_COOKIE['securityToken'])){
		$obj=getSession($_COOKIE['securityToken'],"");
		//ho $_COOKIE['securityToken'];
		var_dump($obj);
		//it();
		if(isset($obj))
		{
			$_SESSION['userObject']=$obj;
			echo "string 1";
			//setcookie('authData')
			if(!isset($_COOKIE['authData'])){
				echo "cookie not set";
				$obj=getSession($_COOKIE['securityToken'],$Host);
				var_dump($obj);
			    if( isset($obj) && $obj->SecurityToken!=""){
			    	echo "set....1";
			    	$_SESSION[$Host]=$obj;
			    	setcookie("securityToken", $obj->SecurityToken,time()+86400);
			    	setcookie("authData", json_encode($obj),time()+86400);
			    	return true;
			    }
			    else
			    {
			    	return false;
			    }
			}else{
				return true;
			}
		}else{
			return false;
		}	
	}
	else
	{
		return false;
	}
}

function getSession($securityToken,$domain){
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'securityToken : ""',
	'X-Apple-Store-Front: 143444,12'
	));
	if($domain==""){
		$domain="Nil";
	}

	curl_setopt($ch, CURLOPT_URL, SVC_AUTH_URL.'/GetSession/'.$securityToken.'/'.$domain.'');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	$obj = json_decode($data);
	return $obj;
}

function INTS(){
	if(isset($_COOKIE["securityToken"])){
		$data=getSession($_COOKIE["securityToken"],"");
		if(!isset($data)){
			setcookie ("securityToken", "", time() - 3600);
		    setcookie ("authData", "", time() - 3600);
		    unset($_COOKIE["securityToken"]);
		    unset($_COOKIE["authData"]);
		    unset($_SESSION);
		    if($mainDomain!=strtolower($_SERVER['HTTP_HOST'])){
			header("Location: http://".$mainDomain."/");
			exit();
		    }
		}else{
			if(isset($data->Error)){
			   	setcookie ("securityToken", "", time() - 3600);
		    		setcookie ("authData", "", time() - 3600);
		    		unset($_COOKIE["securityToken"]);
		    		unset($_COOKIE["authData"]);
			    	unset($_SESSION);
			    	if($mainDomain!=strtolower($_SERVER['HTTP_HOST'])){
					header("Location: http://".$mainDomain."/");
					exit();
			    	}
			}
		}
	}
}


function getURI(){
			if(!isset($_COOKIE["securityToken"])){
				header("Location: s.php?r=index.php");
				exit();
			}
			$uri=$GLOBALS['objURI'];
		    $serchfild=strtolower($_SERVER['HTTP_HOST']);
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    'SecurityToken :'.$_COOKIE['securityToken'],
		    'X-Apple-Store-Front: 143444,12'
		    ));
			curl_setopt($ch, CURLOPT_URL, SVC_AUTH_URL.'/tenant/GetTenants/'.$_COOKIE['securityToken']);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		    $data = curl_exec($ch);
		    $obj = json_decode($data);
		    var_dump($obj);
		    if (isset($obj)){
		    	if(count($obj)!=0){
		    		setcookie("tenantData", json_encode($obj));
		    		$tid=$obj[0]->TenantID;
		    		foreach ($obj as &$value) {
    					if($serchfild==strtolower($value->TenantID)){
    						$tid=$serchfild;
    					}
					}
					
		    		$ch=curl_init();
		    		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		    		'SecurityToken :'.$_COOKIE['securityToken'],
		    		'X-Apple-Store-Front: 143444,12'
		    		));
		    		curl_setopt($ch, CURLOPT_URL, SVC_AUTH_URL.'/tenant/GetTenant/'.$tid);
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				    $data = curl_exec($ch);
				    $obj = json_decode($data);
				    if(isset($obj))
				    {
				    	if($obj->TenantID!=""){
						if ($obj->TenantID==strtolower($_SERVER['HTTP_HOST'])){
				    			header("Location: http://".$obj->TenantID."/".str_replace("index.html","",$obj->Shell)."");
		    					exit();
						}else{
							header("Location: http://".$obj->TenantID."/s.php?securityToken=".$_COOKIE["securityToken"]);
		    					exit();	
						}
		    			}
		    			else
		    			{
		    				// header("Location: payapi/shell.php");
		    				header("Location: app/");
		    				exit();
		    			}
		    		}
		    		else
		    		{
		    				// header("Location: payapi/shell.php");
		    				header("Location: app/");
		    				exit();
		    		}


		    		
		    	}else{

		    		$ch=curl_init();
		    		curl_setopt($ch, CURLOPT_URL, SVC_AUTH_URL.'/tenant/GetTenant/'.$serchfild);
				    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				    $data = curl_exec($ch);
				    $obj = json_decode($data);
				    if(isset($obj))
				    {
				    	if($obj->TenantID!=""){
		    				include("notauthorized.php");
		    			}
		    			else
		    			{
		    				header("Location: app/");
		    				// header("Location: payapi/shell.php");
		    			}
		    		}
		    	}	

		    }else{
		    	//include("t.php");
		    }
		    // header("Location: payapi/shell.php");
		    header("Location: app/");
}



?>
