<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['redirect_uri'],$_GET['client_id'],$_POST['email'],$_POST['pwd'])){
		require_once("../library/thirdparty_api/authorize.php");
		
		$redirect_uri=$_GET['redirect_uri'];
		$client_id=$_GET['client_id'];
		$email=$_POST['email'];
		$pwd=$_POST['pwd'];
		
		return getCode($client_id,$redirect_uri,$email,$pwd);
		}else if(isset($_GET['client_id'],$_GET['redirect_uri'],$_GET['client_secret'],$_GET['code'])){
		require_once("../library/thirdparty_api/authorize.php");
		
		$redirect_uri=$_GET['redirect_uri'];
		$client_id=$_GET['client_id'];
		$client_secret=$_GET['client_secret'];
		$code=$_GET['code'];
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return getToken($client_id,$redirect_uri,$client_secret,$code,$ip);
	}
?>