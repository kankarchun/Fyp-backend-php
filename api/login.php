<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_POST["email"])&&isset($_POST["pwd"])){
		require_once("library/oauth.php");
		
		$email = $_POST["email"];
		$pwd = $_POST["pwd"];
		
		return login($email,$pwd);
		
	}else if(isset($_POST['access_token'])&&isset($_POST['uid'])){
		require_once("library/oauth.php");
		
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