<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_POST['companyAccount'])&&isset($_GET['access_token'])){
		require_once("../library/restCompany_api/manageAccount.php");
		
		$json=json_decode($_POST['companyAccount'],true);
		$companyAccount=$json['companyAccount'];
		$access_token=$_GET['access_token'];
		return updateCompanyInfo($access_token,$companyAccount);
	}else if(isset($_GET['companyID'])&&isset($_GET['access_token'])){
		require_once("../library/restCompany_api/manageAccount.php");
		
		$companyID= $_GET['companyID'];
		$access_token=$_GET['access_token'];
		return getCompanyInfo($access_token,$companyID);
	}
	
?>