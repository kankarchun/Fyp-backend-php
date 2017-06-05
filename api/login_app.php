<?php
	header('Content-Type: application/json; charset=utf-8');
	if(isset($_POST["uid"])&&isset($_POST["pwd"])){
		require_once("library/oauth_app.php");
		
		$uid = $_POST["uid"];
		$pwd = $_POST["pwd"];
		
		return login($uid,$pwd);
		
	}else if(isset($_POST['access_token'])&&isset($_POST['uid'])){
		require_once("library/oauth_app.php");
		
		$token=$_POST['access_token'];
		$uid=$_POST['uid'];
		//echo "$token";
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return oauth($token,$uid,$ip);
	}
	
?>