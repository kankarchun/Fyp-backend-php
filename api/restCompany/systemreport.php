<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		if($action=='profitReport'&&isset($_GET['restID'])){
			require_once("../library/restCompany_api/getSystemReport.php");
			
			$restID=$_GET['restID'];
			$access_token=$_GET['access_token'];
			
			return getRestaurantProfit($access_token,$restID);
			}else if($action=='profitReport'&&isset($_GET['companyID'])){
			require_once("../library/restCompany_api/getSystemReport.php");
			
			$companyID=$_GET['companyID'];
			$access_token=$_GET['access_token'];
			
			return getAllRestaurantProfit($access_token,$companyID);
			}else if($action=='timeReport'&&isset($_GET['restID'])){
			require_once("../library/restCompany_api/getSystemReport.php");
			
			$restID=$_GET['restID'];
			$access_token=$_GET['access_token'];
			
			return getTimeOrder($access_token,$restID);
			}else if($action=='foodReport'&&isset($_GET['restID'])){
			require_once("../library/restCompany_api/getSystemReport.php");
			
			$restID=$_GET['restID'];
			$access_token=$_GET['access_token'];
			
			return getFoodProfit($access_token,$restID);
		}
	}
?>