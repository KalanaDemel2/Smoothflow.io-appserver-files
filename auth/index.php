<?php
require($_SERVER["DOCUMENT_ROOT"] . "/include/config.php");
function detectRequestBody() {
    $rawInput = fopen('php://input', 'r');
    $tempStream = fopen('php://temp', 'r+');
    stream_copy_to_stream($rawInput, $tempStream);
    rewind($tempStream);

    return stream_get_contents($tempStream);
}
$authrequest = str_replace('/auth/','',$_SERVER["REQUEST_URI"]);
$SecurityToken="";
$headers = apache_request_headers();
if(isset($_COOKIE["authData"])){
	$authData = json_decode($_COOKIE["authData"]);
	$SecurityToken=$authData->SecurityToken;
	array_push($headers,'securityToken:'.$SecurityToken);
}

	
	 
	//echo $SecurityToken;
	//$authURI="http://auth.duoworld.com:3048/";
	//echo $authURI.$authrequest;
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
	
	
	curl_setopt($ch, CURLOPT_URL, $authURI.$authrequest);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	if($_SERVER["REQUEST_METHOD"]!="GET"){
		$postData = detectRequestBody();
		curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		//var_dump($postData);
	}
	$data = curl_exec($ch);
	echo $data;
	//return $obj;

?>
