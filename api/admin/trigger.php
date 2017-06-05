<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_GET['restID'])){
		require_once("../library/admin_api/getTrigger.php");
		
		$restID=$_GET['restID'];
		
		return getTrigger($restID);
	}
?>