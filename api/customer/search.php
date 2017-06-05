<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
		switch($action) {
			case 'all':
				if(isset($_GET['rest'])){
					require_once("../library/customer_api/searchRest.php");
					
					return getRest();
				}else if(isset($_GET['region'])){
					require_once("../library/customer_api/searchRest.php");
					
					return getRegion();
				}
			break;
			case 'search':
				if(isset($_GET['restID'])&&isset($_GET['food'])){
					require_once("../library/customer_api/searchFood.php");
					
					$food = $_GET['food'];
					
					return searchFood($food);
				}else if(isset($_GET['restaurant'])&&isset($_GET['region'])){
					require_once("../library/customer_api/searchRest.php");
					
					$restaurant = $_GET['restaurant'];
					$region=$_GET['region'];
					
					return searchRestRegion($restaurant,$region);
				}
				else if(isset($_GET['latitude'])&&isset($_GET['longitude'])){
					require_once("../library/customer_api/searchRest.php");
					
					$latitude = $_GET['latitude'];
					$longitude=$_GET['longitude'];
					
					return searchLocation($latitude,$longitude);
				}
				else if(isset($_GET['tableID'])){
					require_once("../library/customer_api/searchRest.php");
					
					$tableID = $_GET['tableID'];
					
					return searchTableNo($tableID);
					
				}
				else if(isset($_GET['restaurant'])){
					require_once("../library/customer_api/searchRest.php");
					
					$restaurant = $_GET['restaurant'];
					
					return searchRest($restaurant);
					
				}else if(isset($_GET['region'])){
					require_once("../library/customer_api/searchRest.php");
					
					$region=$_GET['region'];
					
					return searchRegion($region);
				}else if(isset($_GET['restID'])){
					require_once("../library/customer_api/searchRest.php");
					
					$restID = $_GET['restID'];
					
					return scanQR($restID);
				}else if(isset($_GET['regionID'])){
					require_once("../library/customer_api/searchRest.php");
					
					$regionID = $_GET['regionID'];
					
					return searchRegionID($regionID);
				}
			break;
		}
	}
?>