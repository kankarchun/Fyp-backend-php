<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_POST['phoneNo'])&&isset($_POST['smsCode'])&&isset($_POST['imei'])){
		require_once("../library/customer_api/createCust.php");
		
		$phoneNo=$_POST['phoneNo'];
		$imei=$_POST['imei'];
		$smsCode=$_POST['smsCode'];
		
		return verifySMS($phoneNo,$imei,$smsCode);
	}else if(isset($_POST['phoneNo'])&&isset($_POST['imei'])){
		require_once("../library/customer_api/createCust.php");
		
		$phoneNo=$_POST['phoneNo'];
		$imei=$_POST['imei'];
		$sms=false;
		
		return sendSMS($phoneNo,$imei,$sms);
	}
?>