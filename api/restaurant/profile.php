<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['restID'])&&isset($_GET['access_token'])){
		require_once("../library/restaurant_api/getAccount.php");
		
		$restID= $_GET['restID'];
		$access_token=$_GET['access_token'];
		return getRestInfo($access_token,$restID);
	} 
	
?>