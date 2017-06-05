<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_POST['managerAccount'])&&isset($_GET['access_token'])){
		require_once("../library/manager_api/manageAccount.php");
		
		$json=json_decode($_POST['managerAccount'],true);
		$managerAccount=$json['managerAccount'];
		$access_token=$_GET['access_token'];
		return updateManagerInfo($access_token,$managerAccount);
	}else if(isset($_GET['managerID'])&&isset($_GET['access_token'])){
		require_once("../library/manager_api/manageAccount.php");
		
		$managerID= $_GET['managerID'];
		$access_token=$_GET['access_token'];
		return getManagerInfo($access_token,$managerID);
	} 
	
?>