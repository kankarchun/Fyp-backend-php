<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['access_token'])){
		require_once("../library/thirdparty_api/getRestInfo.php");
		
		$access_token=$_GET['access_token'];
		
		return getUser($access_token);
	} 
	
?>