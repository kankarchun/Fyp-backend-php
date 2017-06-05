<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'set':
				if(isset($_POST['tableFloor'])){
					require_once("../library/manager_api/manageTableFloorPlan.php");
					
					$json=json_decode($_POST['tableFloor'],true);
					
					$tableFloor=$json["tableFloor"];

					return setTableFloor($access_token,$tableFloor);
				}else if(isset($_POST['restTable'])){
					require_once("../library/manager_api/manageTableFloorPlan.php");
					
					$json=json_decode($_POST['restTable'],true);
					
					$restTable=$json["restTable"];
					
					return setRestTable($access_token,$restTable);
				}
			break;
			case 'update':
				if(isset($_POST['tableFloor'])){
					require_once("../library/manager_api/manageTableFloorPlan.php");
					
					$json=json_decode($_POST['tableFloor'],true);
					
					$tableFloor=$json["tableFloor"];

					return updateTableFloor($access_token,$tableFloor);
				}else if(isset($_POST['restTable'])){
					require_once("../library/manager_api/manageTableFloorPlan.php");
					
					$json=json_decode($_POST['restTable'],true);
					
					$restTable=$json["restTable"];
					
					return updateRestTable($access_token,$restTable);
				}
			break;
			case 'delete':
				if(isset($_GET['restID'])&&isset($_GET['floor'])){
					require_once("../library/manager_api/manageTableFloorPlan.php");
					
					$restID = $_GET['restID'];
					$floor = $_GET['floor'];
					
					return deleteTableFloor($access_token,$restID,$floor);
				}else if(isset($_GET['tableID'])){
					require_once("../library/manager_api/manageTableFloorPlan.php");
					
					$tableID = $_GET['tableID'];
					
					return deleteRestTable($access_token,$tableID);
				}
			break;
		}
	}
?>