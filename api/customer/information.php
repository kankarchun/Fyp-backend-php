<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['restID'])&&isset($_GET['menuID'])){
		require_once("../library/customer_api/restMenu.php");
		
		$restID = $_GET['restID'];
		$menuID=$_GET['menuID'];

		return getMenuItem($restID,$menuID);
	}else if(isset($_GET['restID'])){
		require_once("../library/customer_api/restMenu.php");
		
		$restID = $_GET['restID'];
		
		return getMenu($restID);
		
	}
	
?>