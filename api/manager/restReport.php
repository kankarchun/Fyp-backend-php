<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['restID'])&&isset($_GET['minOrderDate'])&&isset($_GET['maxOrderDate'])&&isset($_GET['access_token'])){
		require_once("../library/manager_api/getRestReport.php");
		
		$restID=$_GET['restID'];
		$minOrderDate=$_GET['minOrderDate'];
		$maxOrderDate=$_GET['maxOrderDate'];
		$access_token=$_GET['access_token'];
		
		return getRestReport($access_token,$restID,$minOrderDate,$maxOrderDate);
	}
?>