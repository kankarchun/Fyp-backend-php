<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
		switch($action) {
			case 'get':
			if(isset($_GET['user'])){
				require_once("../library/admin_api/manageAccount.php");
				
				if($_GET['user']=="customer"){
					return getCustAccount();
					}else if($_GET['user']=="restaurantCompany"){
					return getRestCompanyAccount();
					}else if($_GET['user']=="restaurant"&&isset($_GET['companyID'])){
					$companyID=$_GET['companyID'];
					return getRestAccount($companyID);
				}else if($_GET['user']=="restaurant"){
					return getAllRestAccount();
				}
			}
			break;
			case 'update':
			if(isset($_GET['companyID'],$_GET['locked'])){
				require_once("../library/admin_api/manageAccount.php");
				
				$companyID=$_GET["companyID"];
				$locked=$_GET['locked'];
				
				return updateRestCompanyAccount($companyID,$locked);
				}else if(isset($_GET['custID'],$_GET['locked'])){
				require_once("../library/admin_api/manageAccount.php");
				
				$custID=$_GET["custID"];
				$locked=$_GET['locked'];
				
				return updateCustAccount($custID,$locked);
			}else if(isset($_GET['restID'],$_GET['locked'])){
				require_once("../library/admin_api/manageAccount.php");
				
				$restID=$_GET["restID"];
				$locked=$_GET['locked'];
				
				return updateRestAccount($restID,$locked);
			}
			break;
			case 'set':
			if(isset($_GET['RestaurantCompanyAccount'])){
				require_once("../library/admin_api/manageAccount.php");
				
				$json=json_decode($_GET['RestaurantCompanyAccount'],true);
				
				$RestaurantCompanyAccount=$json["RestaurantCompanyAccount"];
				
				return setRestCompanyAccount($RestaurantCompanyAccount);
				}else if(isset($_GET['CustomerAccount'])){
				require_once("../library/admin_api/manageAccount.php");
				
				$json=json_decode($_GET['CustomerAccount'],true);
				
				$CustomerAccount=$json["CustomerAccount"];
				
			return setCustAccount($CustomerAccount);
			}else if(isset($_GET['restAccount'])){
			require_once("../library/admin_api/manageAccount.php");
			
			$json=json_decode($_GET['restAccount'],true);
			
			$restAccount=$json["restAccount"];
			
			return setRestAccount($restAccount);
			}
			break;
			}
			}
			?>			