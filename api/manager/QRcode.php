<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['action']) && !empty($_GET['action'])&&isset($_GET['access_token'])) {
	    $action = $_GET['action'];
		$access_token=$_GET['access_token'];
		switch($action) {
			case 'get':
			if(isset($_GET['restID'])){
				require_once("../library/manager_api/manageQRcode.php");
				
				$restID = $_GET['restID'];
				
				return getRestQR($access_token,$restID);
			}
			break;
			case 'set':
			if(isset($_GET['tableID'],$_GET["qrcode"])){
				require_once("../library/manager_api/manageQRcode.php");
				
				$tableID = $_GET['tableID'];
				$qrcode=$_GET["qrcode"];
				
				return setTableQR($access_token,$tableID,$qrcode);
				}else if(isset($_GET['restID'],$_GET["qrcode"])){
				require_once("../library/manager_api/manageQRcode.php");
				
				$restID = $_GET['restID'];
				$qrcode=$_GET["qrcode"];
				
				return setRestQR($access_token,$restID,$qrcode);
			}
			break;
			case 'delete':
			if(isset($_GET['tableID'])){
				require_once("../library/manager_api/manageQRcode.php");
				
				$tableID=$_GET['tableID'];
				
				return deleteTableQR($access_token,$tableID);
				}else if(isset($_GET['restID'])){
				require_once("../library/manager_api/manageQRcode.php");
				
				$restID = $_GET['restID'];
				
				return deleteRestQR($access_token,$restID);
			}
			break;
		}
	}
?>