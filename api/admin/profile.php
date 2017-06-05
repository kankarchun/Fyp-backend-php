<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['AdminAccount'])){
		require_once("../library/admin_api/manageAccount.php");
		
		$json=json_decode($_GET['AdminAccount'],true);
		$AdminAccount=$json['AdminAccount'];
		return updateAdminInfo($AdminAccount);
	}else if(isset($_GET['adminID'])){
		require_once("../library/admin_api/manageAccount.php");
		
		$adminID= $_GET['adminID'];
		
		return getAdminInfo($adminID);
	} 
	
?>