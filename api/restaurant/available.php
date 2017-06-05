<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
			if(isset($_GET['item'],$_GET['restID'])&&$_GET['item']=="food"){
				require_once("../library/restaurant_api/updateAvailable.php");
				
				$restID=$_GET['restID'];
				
				return getFood($access_token,$restID);
				}else if(isset($_GET['item'],$_GET['restID'])&&$_GET['item']=="set"){
				require_once("../library/restaurant_api/updateAvailable.php");
				
				$restID=$_GET['restID'];
				
				return getSet($access_token,$restID);
			}
			break;
			case 'update':
			if(isset($_GET['foodID'],$_GET['available'])){
				require_once("../library/restaurant_api/updateAvailable.php");
				
				$access_token=$_GET['access_token'];
				$foodID=$_GET['foodID'];
				$available=$_GET['available'];
				
				return updateFood($access_token,$foodID,$available);
				}else if(isset($_GET['setID'],$_GET['available'])){
				require_once("../library/restaurant_api/updateAvailable.php");
				
				$access_token=$_GET['access_token'];
				$setID=$_GET['setID'];
				$available=$_GET['available'];
				
				return updateSetItem($access_token,$setID,$available);
			}
			break;
		}
	}
?>