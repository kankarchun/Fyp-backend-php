<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../library/admin_api/getCustReport.php");
		
	return getCustReport();
?>