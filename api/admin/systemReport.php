<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
		if($action=='restaurantReport'){
			require_once("../library/admin_api/getSystemReport.php");
			
			return getRestaurantRegister();
		}
		else if($action=='customerReport'){
			require_once("../library/admin_api/getSystemReport.php");
			
			return getCustomerRegister();
		}
		else if($action=='profitReport'&&isset($_GET['restID'])){
			require_once("../library/admin_api/getSystemReport.php");
			
			$restID=$_GET['restID'];
			
			return getRestaurantProfit($restID);
		}
		else if($action=='profitReport'){
			require_once("../library/admin_api/getSystemReport.php");
			
			return getAllRestaurantProfit();
		}else if($action=='timeReport'&&isset($_GET['restID'])){
			require_once("../library/admin_api/getSystemReport.php");
			
			$restID=$_GET['restID'];
			
			return getTimeOrder($restID);
		}else if($action=='foodReport'&&isset($_GET['restID'])){
			require_once("../library/admin_api/getSystemReport.php");
			
			$restID=$_GET['restID'];
		
			return getFoodProfit($restID);
		}
	}
?>