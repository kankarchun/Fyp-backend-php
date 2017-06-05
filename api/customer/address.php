<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['action']) && !empty($_GET['action'])) {
	    $action = $_GET['action'];
		switch($action) {
			case 'get':
			if(isset($_GET['custID'])){
				require_once("../library/customer_api/manageAddress.php");
				
				$custID=$_GET["custID"];
				
				return getAddress($custID);
			}
			break;
			case 'set':
			if(isset($_GET['custID'],$_GET['address'])){
				require_once("../library/customer_api/manageAddress.php");

				$custID=$_GET["custID"];
				$address=$_GET["address"];
				
				return setAddress($custID,$address);
			}
			break;
			case 'update':
			if(isset($_GET['address'],$_GET['cAddressNo'])){
				require_once("../library/customer_api/manageAddress.php");
				
				$address=$_GET["address"];
				$cAddressNo=$_GET["cAddressNo"];
				
				return updateAddress($address,$cAddressNo);
			}
			break;
			case 'delete':
			if(isset($_GET['cAddressNo'])){
				require_once("../library/customer_api/manageAddress.php");
				
				$cAddressNo=$_GET["cAddressNo"];
				
				return deleteAddress($cAddressNo);
			}
			break;
		}
	}
?>