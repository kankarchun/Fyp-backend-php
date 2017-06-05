<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
				if(isset($_GET['restID'])){
					require_once("../library/manager_api/manageDiscount.php");
					
					$restID = $_GET['restID'];
					
					return getRestDiscount($access_token,$restID);
				}
			break;
			case 'set':
				if(isset($_POST['charge'])){
					require_once("../library/manager_api/manageDiscount.php");
					
					$json=json_decode($_POST['charge'],true);
					
					$charge=$json["charge"];
					
					return setCharge($access_token,$charge);
				}
			break;
			case 'update':
				if(isset($_POST['charge'])){
					require_once("../library/manager_api/manageDiscount.php");
					
					$json=json_decode($_POST['charge'],true);
					
					$charge=$json["charge"];
					
					return updateCharge($access_token,$charge);
				}
			break;
			case 'delete':
				if(isset($_GET['chargeID'])){
					require_once("../library/manager_api/manageDiscount.php");
					
					$chargeID = $_GET['chargeID'];
					
					return deleteCharge($access_token,$chargeID);
				}
			break;
		}
	}
?>