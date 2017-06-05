<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['foodID'])){
		require_once("../library/customer_api/getOptionAllow.php");
		
		$foodID= $_GET['foodID'];
		
		return getOptionAllow($foodID);
	} 
?>