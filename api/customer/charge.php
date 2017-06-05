<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['restID'])){
		require_once("../library/customer_api/getCharge.php");
		
		$restID= $_GET['restID'];
		
		return getCharge($restID);
	}
	
?>