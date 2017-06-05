<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['restID'],$_GET['qr'])){
		require_once("../library/admin_api/getQR.php");
		
		$restID=$_GET['restID'];
		if($_GET['qr']=="table"){
			return getTableQR($restID);
		}
	}
?>