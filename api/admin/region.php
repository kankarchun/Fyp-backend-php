<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once("../library/admin_api/getRegion.php");

	return getRegion();
	
?>