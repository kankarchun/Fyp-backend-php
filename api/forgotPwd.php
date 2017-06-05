<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_POST["access_token"])&&isset($_POST["pwd"])){
		require_once("library/resetPwd.php");
		
		$access_token = $_POST["access_token"];
		$pwd = $_POST["pwd"];
		
		return forgot($access_token,$pwd);
	}
	
?>