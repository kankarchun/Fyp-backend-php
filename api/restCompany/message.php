<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['message'],$_GET['access_token'],$_GET['companyID'])){
		require_once("../library/restCompany_api/setMessage.php");
		
		$message=$_GET['message'];
		$access_token=$_GET['access_token'];
		$companyID=$_GET['companyID'];

		return setMessage($access_token,$companyID,$message);
	}
?>