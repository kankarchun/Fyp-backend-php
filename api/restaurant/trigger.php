<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['invoiceID'])&&isset($_GET['access_token'])){
		require_once("../library/restaurant_api/setTrigger.php");
		
		$invoiceID= $_GET['invoiceID'];
		$access_token=$_GET['access_token'];
		return setTrigger($access_token,$invoiceID);
	} 
	
?>