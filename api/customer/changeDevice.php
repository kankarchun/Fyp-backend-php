<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_POST['custID'])){
		require_once("../library/customer_api/updateCust.php");
		
		$custID=$_POST['custID'];
		
		return changeDevice($custID);
	}else if(isset($_POST['code'])&&isset($_POST['imei'])){
		require_once("../library/customer_api/updateCust.php");
		
		$imei=$_POST['imei'];
		$code=$_POST['code'];
		
		return verifyDevice($imei,$code);
	}else if(isset($_POST['phoneNo'])&&isset($_POST['smsCode'])&&isset($_POST['imei'])){
		require_once("../library/customer_api/updateCust.php");
		
		$phoneNo=$_POST['phoneNo'];
		$imei=$_POST['imei'];
		$smsCode=$_POST['smsCode'];
		
		return verifySMS($phoneNo,$imei,$smsCode);
	}else if(isset($_POST['phoneNo'])&&isset($_POST['oldPhone'])){
		require_once("../library/customer_api/updateCust.php");
		
		$phoneNo=$_POST['phoneNo'];
		$oldPhone=$_POST['oldPhone'];
		$sms=false;
		
		return sendSMS($phoneNo,$oldPhone,$sms);
	}
?>