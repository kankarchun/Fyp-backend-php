<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['access_token'])&&isset($_GET['restID'])){
		require_once("../library/restaurant_api/getTableFloorPlan.php");
		
		$access_token=$_GET['access_token'];
		$restID=$_GET["restID"];
		
		return getTableFloorPlan($access_token,$restID);
	}
?>