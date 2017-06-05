<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['adminID'],$_GET['custNotification'])){
		require_once("../library/admin_api/setNotification.php");
		
		$json=json_decode($_GET['custNotification'],true);
		
		$custNotification=$json["custNotification"];
		$adminID= $_GET['adminID'];
		
		return setCustNotification($adminID,$custNotification);
	}else if(isset($_GET['adminID'],$_GET['companyNotification'])){
		require_once("../library/admin_api/setNotification.php");
		
		$json=json_decode($_GET['companyNotification'],true);
		
		$companyNotification=$json["companyNotification"];
		$adminID= $_GET['adminID'];
		
		return setCompanyNotification($adminID,$companyNotification);
	}
	
?>