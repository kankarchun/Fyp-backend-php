<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
			if(isset($_GET['restID'])){
				require_once("../library/manager_api/manageRestAccount.php");
				
				$restID=$_GET["restID"];
				
				return getRestAccount($access_token,$restID);
			}
			break;
			case 'update':
			if(isset($_POST['restAccount'])){
				require_once("../library/manager_api/manageRestAccount.php");
				
				$json=json_decode($_POST['restAccount'],true);
				
				$restAccount=$json["restAccount"];
				
				return updateRestAccount($access_token,$restAccount);
			}
			break;
		}
	}
?>