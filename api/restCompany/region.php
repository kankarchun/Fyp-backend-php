<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['companyID'])&&isset($_GET['access_token'])){
		require_once("../library/restCompany_api/getRegion.php");
		
		$access_token=$_GET['access_token'];
		return getRegion($access_token);
	}
	
?>