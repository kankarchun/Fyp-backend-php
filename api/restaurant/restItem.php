<?php
	header('Content-Type: application/json; charset=utf-8');
	header('Access-Control-Allow-Origin: *');
	if(isset($_GET['restID'],$_GET['item'],$_GET['access_token'])&&$_GET['item']=="food"){
		require_once("../library/manager_api/manageRestItem.php");
		
		$access_token=$_GET['access_token'];
		$restID=$_GET['restID'];
		
		return getFood($access_token,$restID);
		}else if(isset($_GET['restID'],$_GET['item'])&&$_GET['item']=="set"){
		require_once("../library/manager_api/manageRestItem.php");
		
		$access_token=$_GET['access_token'];
		$restID=$_GET['restID'];
		
		return getSet($access_token,$restID);
	}
	
?>