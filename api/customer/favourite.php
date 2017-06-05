<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
		switch($action) {
			case 'get':
			if(isset($_GET['isFavourite'],$_GET['custID'],$_GET['restID'])){
				require_once("../library/customer_api/getFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				
				return isFavouriteRest($custID,$restID);
			}else if(isset($_GET['isFavourite'],$_GET['custID'],$_GET['foodID'])){
				require_once("../library/customer_api/getFavourite.php");
				
				$custID= $_GET['custID'];
				$foodID= $_GET['foodID'];
				
				return isFavouriteFood($custID,$foodID);
			}else if(isset($_GET['isFavourite'],$_GET['custID'],$_GET['setID'])){
				require_once("../library/customer_api/getFavourite.php");
				
				$custID= $_GET['custID'];
				$setID= $_GET['setID'];
				
				return isFavouriteSet($custID,$setID);
			}else if(isset($_GET['custID'])&&isset($_GET['restID'])){
				require_once("../library/customer_api/getFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				
				return getFood($custID,$restID);
			}else if(isset($_GET['custID'])){
				require_once("../library/customer_api/getFavourite.php");
				
				$custID= $_GET['custID'];
				
				return getRest($custID);
				
			}
			break;
			case 'set':
			if(isset($_GET['custID'])&&isset($_GET['restID'])&&isset($_GET['food'])){
				require_once("../library/customer_api/setFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				$json=json_decode($_GET['food'],true);
				$food=$json["food"];
				
				return setFood($custID,$restID,$food);
				
			}else if(isset($_GET['custID'])&&isset($_GET['restID'])&&isset($_GET['set'])){
				require_once("../library/customer_api/setFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				$json=json_decode($_GET['set'],true);
				$set=$json["set"];
				
				return setSet($custID,$restID,$set);
			}else if(isset($_GET['custID'])&&isset($_GET['restID'])){
				require_once("../library/customer_api/setFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				
				return setRest($custID,$restID);
				
			}
			break;
			case 'delete':
			if(isset($_GET['custID'])&&isset($_GET['restID'])&&isset($_GET['food'])){
				require_once("../library/customer_api/deleteFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				$foodID= $_GET['food'];
				
				return deleteFood($custID,$restID,$foodID);
			}else if(isset($_GET['custID'])&&isset($_GET['restID'])&&isset($_GET['set'])){
				require_once("../library/customer_api/deleteFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				$setID= $_GET['set'];
				
				return deleteSet($custID,$restID,$setID);
			}else if(isset($_GET['custID'])&&isset($_GET['restID'])){
				require_once("../library/customer_api/deleteFavourite.php");
				
				$custID= $_GET['custID'];
				$restID= $_GET['restID'];
				
				return deleteRest($custID,$restID);
				
			}
			break;
		}
	}
?>			