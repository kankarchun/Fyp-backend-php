<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['adminID'],$_GET['changeDateTime'],$_GET['title'],$_GET['custID'])){
		require_once("../library/admin_api/setControlLog.php");
		
		$adminID=$_GET['adminID'];
		$changeDateTime=$_GET['changeDateTime'];
		$title=$_GET['title'];
		$custID=$_GET['custID'];
		
		return setCustControlLog($adminID,$changeDateTime,$title,$custID);
	}else if(isset($_GET['adminID'],$_GET['changeDateTime'],$_GET['title'],$_GET['companyID'])){
		require_once("../library/admin_api/setControlLog.php");
		
		$adminID=$_GET['adminID'];
		$changeDateTime=$_GET['changeDateTime'];
		$title=$_GET['title'];
		$companyID=$_GET['companyID'];
		
		return setCompanyControlLog($adminID,$changeDateTime,$title,$companyID);
	}
?>