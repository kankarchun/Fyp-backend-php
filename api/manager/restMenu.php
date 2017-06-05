<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
				if(isset($_GET['restID'],$_GET['access_token'],$_GET['menuID'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$access_token = $_GET['access_token'];
					$restID = $_GET['restID'];
					$menuID = $_GET['menuID'];
					
					return getMenuItem($access_token,$restID,$menuID);
				}else if(isset($_GET['restID'],$_GET['access_token'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$access_token = $_GET['access_token'];
					$restID = $_GET['restID'];

					return getMenu($access_token,$restID);
				}
			break;
			case 'set':
				if(isset($_POST['menu'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$json=json_decode($_POST['menu'],true);
					
					$menu=$json["menu"];

					return setMenu($access_token,$menu);
				}else if(isset($_POST['menuItem'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$json=json_decode($_POST['menuItem'],true);
					
					$menuItem=$json["menuItem"];
					
					return setMenuItem($access_token,$menuItem);
				}
			break;
			case 'update':
				if(isset($_POST['menu'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$json=json_decode($_POST['menu'],true);
					
					$menu=$json["menu"];

					return updateMenu($access_token,$menu);
				}else if(isset($_POST['menuItem'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$json=json_decode($_POST['menuItem'],true);
					
					$menuItem=$json["menuItem"];
					
					return updateMenuItem($access_token,$menuItem);
				}
			break;
			case 'delete':
				if(isset($_GET['itemNo'])&&isset($_GET['restID'])&&isset($_GET['groupNo'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$itemNo = $_GET['itemNo'];
					$restID = $_GET['restID'];
					$groupNo = $_GET['groupNo'];
					
					return deleteMenuItem($access_token,$itemNo,$restID,$groupNo);
				}
				else if(isset($_GET['restID'])&&isset($_GET['groupNo'])){
					require_once("../library/manager_api/manageRestMenu.php");
					
					$restID = $_GET['restID'];
					$groupNo = $_GET['groupNo'];
					
					return deleteMenu($access_token,$restID,$groupNo);
				}
			break;
		}
	}
?>