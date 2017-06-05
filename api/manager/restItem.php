<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
			if(isset($_GET['restID'],$_GET['item'])&&$_GET['item']=="food"){
				require_once("../library/manager_api/manageRestItem.php");
				
				$restID=$_GET['restID'];
				
				return getFood($access_token,$restID);
				}else if(isset($_GET['restID'],$_GET['item'])&&$_GET['item']=="set"){
				require_once("../library/manager_api/manageRestItem.php");
				
				$restID=$_GET['restID'];
				
				return getSet($access_token,$restID);
			}
			break;
			case 'set':
			if(isset($_POST['setItem'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['setItem'],true);
				
				$setItem=$json["setItem"];
				
				return setSetItem($access_token,$setItem);
				}else if(isset($_POST['title'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['title'],true);
				
				$title=$json["title"];
				
				return setSetTitle($access_token,$title);
				}else if(isset($_POST['setFood'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['setFood'],true);
				
				$setFood=$json["setFood"];
				
				return setSetFood($access_token,$setFood);
			}
			else if(isset($_POST['food'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['food'],true);
				
				$food=$json["food"];
				
				return setFood($access_token,$food);
			}
			break;
			case 'update':
			if(isset($_POST['setItem'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['setItem'],true);
				
				$setItem=$json["setItem"];
				
				return updateSetItem($access_token,$setItem);
				}else if(isset($_POST['title'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['title'],true);
				
				$title=$json["title"];
				
				return updateSetTitle($access_token,$title);
				}else if(isset($_POST['setFood'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['setFood'],true);
				
				$setFood=$json["setFood"];
				
				return updateSetFood($access_token,$setFood);
			}
			else if(isset($_POST['food'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$json=json_decode($_POST['food'],true);
				
				$food=$json["food"];
				
				return updateFood($access_token,$food);
			}
			break;
			case 'delete':
			if(isset($_GET['foodNo'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$foodNo=$_GET['foodNo'];
				
				return deleteSetFood($access_token,$foodNo);
				}else if(isset($_GET['titleNo'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$titleNo=$_GET['titleNo'];
				
				return deleteSetTitle($access_token,$titleNo);
			}else if(isset($_GET['setID'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$setID=$_GET['setID'];
				
				return deleteSetItem($access_token,$setID);
			}else if(isset($_GET['foodID'])){
				require_once("../library/manager_api/manageRestItem.php");
				
				$foodID=$_GET['foodID'];
				
				return deleteFood($access_token,$foodID);
			}
			break;
		}
	}
?>			