<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['custID'])&&isset($_GET['custName'])){
		require_once("../library/customer_api/updateCustInfo.php");
		
		$custID= $_GET['custID'];
		$custName= $_GET['custName'];
		
		return updateCustInfo($custID,$custName);
	}
	
?>