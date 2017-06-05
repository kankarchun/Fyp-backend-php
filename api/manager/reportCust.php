<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['access_token'])&&isset($_GET['custID'])&&isset($_GET['comment'])){
		require_once("../library/manager_api/setCustReport.php");
		
		$access_token=$_GET['access_token'];
		$custID=$_GET['custID'];
		$comment=$_GET['comment'];
		
		return setCustReport($access_token,$custID,$comment);
	}
?>