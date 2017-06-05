<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['custID'])){
		require_once("../library/customer_api/getOrder.php");
		
		$custID = $_GET['custID'];
		
		return getOrder($custID);
		
	}else if(isset($_GET['invoice'])){
		require_once("../library/customer_api/makeOrder.php");
		
		$json=json_decode($_GET['invoice'],true);
		
		$invoice=$json["invoice"];
		$charge=null;
		$food=null;
		$set=null;
		$coupon=null;
		if(array_key_exists('charge',$json["invoice"])){
			$charge=$invoice["charge"];
		}
		if(array_key_exists('food',$json["invoice"])){
			$food=$invoice["food"];
		}
		if(array_key_exists('set',$json["invoice"])){
			$set=$invoice["set"];
		}
		
		return makeOrder($invoice,$charge,$food,$set);
	}else if(isset($_GET['optID'])){
		require_once("../library/customer_api/getOrder.php");
		
		$optID=$_GET['optID'];
		
		return getSpecialOption($optID);
	}
?>