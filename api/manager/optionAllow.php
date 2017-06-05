<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
				if(isset($_GET['access_token'])){
					require_once("../library/manager_api/manageOptionAllow.php");
					
					$access_token=$_GET['access_token'];
					
					return getOptionAllow($access_token);
				} 
			break;
			case 'set':
				if(isset($_GET['access_token'],$_GET['optID'],$_GET['foodID'])){
					require_once("../library/manager_api/manageOptionAllow.php");
					
					$access_token=$_GET['access_token'];
					$optID=$_GET['optID'];
					$foodID= $_GET['foodID'];
					
					return setOptionAllow($access_token,$optID,$foodID);
				} 
			break;
			case 'update':
				if(isset($_GET['access_token'],$_GET['oaID'],$_GET['optID'],$_GET['foodID'])){
					require_once("../library/manager_api/manageOptionAllow.php");
					
					$access_token=$_GET['access_token'];
					$oaID=$_GET['oaID'];
					$optID=$_GET['optID'];
					$foodID= $_GET['foodID'];
					
					return updateOptionAllow($access_token,$oaID,$optID,$foodID);
				} 
			break;
			case 'delete':
				if(isset($_GET['access_token'],$_GET['oaID'])){
					require_once("../library/manager_api/manageOptionAllow.php");
					
					$access_token=$_GET['access_token'];
					$oaID=$_GET['oaID'];
					
					return deleteOptionAllow($access_token,$oaID);
				}
			break;
		}
	}
?>