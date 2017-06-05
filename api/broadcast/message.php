<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
			require_once("../library/broadcast_api/manageMsg.php");
			
			return getMsg($access_token);
			break;
			case 'delete':
			if(isset($_GET['cNID'])){
				require_once("../library/broadcast_api/manageMsg.php");
				
				$cNID = $_GET['cNID'];
				
				return deleteCustMsg($access_token,$cNID);
				
				}else if(isset($_GET['rNID'])){
				require_once("../library/broadcast_api/manageMsg.php");
				
				$rNID = $_GET['rNID'];
				
				return deleteCompanyMsg($access_token,$rNID);
				
			}
			break;
		}
	}
?>