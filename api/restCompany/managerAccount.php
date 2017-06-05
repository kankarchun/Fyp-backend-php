<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
			if(isset($_GET['companyID'],$_GET['user'])&&$_GET['user']=="manager"){
				require_once("../library/restCompany_api/manageManagerAccount.php");
				
				$companyID=$_GET["companyID"];
				
				return getManagerAccount($access_token,$companyID);
				}else if(isset($_GET['companyID'],$_GET['user'])&&$_GET['user']=="restaurant"){
				require_once("../library/restCompany_api/manageManagerAccount.php");
				
				$companyID=$_GET["companyID"];
				
				return getRestAccount($access_token,$companyID);
			}
			break;
			case 'update':
			if(isset($_POST['managerAccount'])){
				require_once("../library/restCompany_api/manageManagerAccount.php");
				
				$json=json_decode($_POST['managerAccount'],true);
				
				$managerAccount=$json["managerAccount"];
				
				return updateManagerAccount($access_token,$managerAccount);
			}else if(isset($_POST['restAccount'])){
				require_once("../library/restCompany_api/manageManagerAccount.php");
				
				$json=json_decode($_POST['restAccount'],true);
				
				$restAccount=$json["restAccount"];
				
				return updateRestAccount($access_token,$restAccount);
			}
			break;
			case 'set':
			if(isset($_POST['managerAccount'])){
				require_once("../library/restCompany_api/manageManagerAccount.php");
				
				$json=json_decode($_POST['managerAccount'],true);
				
				$managerAccount=$json["managerAccount"];
				
				return setManagerAccount($access_token,$managerAccount);
			}
			break;
			case 'delete':
			if(isset($_GET['managerID'])){
				require_once("../library/restCompany_api/manageManagerAccount.php");
				
				$managerID=$_GET["managerID"];
				
				return deleteManagerAccount($access_token,$managerID);
			}
			break;
		}
	}
?>