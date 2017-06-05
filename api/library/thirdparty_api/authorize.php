<?php
	function getCode($client_id,$redirect_uri,$uid,$password){
		require_once("library/connections/conn.php");
		
		$sql="select * from thirdparty where api_key='$client_id' and redirect_uri='$redirect_uri'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){			
			$sql="select * from restaurant where restEmail='$uid'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				if(password_verify($password,$rc['restPW'])){
					checkDB($conn,$rc["locked"],$rc["restID"]);
					}else{
					$msg='access_denied';
					$msg=array('result'=>401,'message'=>"failed",'data'=>array('return'=>$msg));
					echo json_encode($msg);
				}
				}else{
				$sql="select * from manager where managerEmail='$uid'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				if(mysqli_num_rows($rs)>0){
					$rc=mysqli_fetch_assoc($rs);
					if(password_verify($password,$rc['managerPW'])){
						checkDB($conn,$rc["locked"],$rc["managerID"]);
						}else{
						$msg='access_denied';
						$msg=array('result'=>401,'message'=>"failed",'data'=>array('return'=>$msg));
						echo json_encode($msg);
					}
					}else{
					$sql="select * from restcompany where companyEmail='$uid'";
					$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						if(password_verify($password,$rc['companyPW'])){
							checkDB($conn,$rc["locked"],$rc["companyID"]);
							}else{
							$msg='access_denied';
							$msg=array('result'=>401,'message'=>"failed",'data'=>array('return'=>$msg));
							echo json_encode($msg);
						}
						}else{
						$msg='access_denied';
						$msg=array('result'=>401,'message'=>"access_denied",'data'=>array('return'=>$msg));
						//mysqli_close($conn);
						echo json_encode($msg);
					}
				}
			}
			}else{
			$msg='access_denied';
			$msg=array('result'=>401,'message'=>"failed",'data'=>array('return'=>$msg));
			echo json_encode($msg);
		}
	}
	
	
	function checkDB($conn,$locked,$uid){
		$sql="delete from accesstoken where uid='$uid'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if($locked==0){
			date_default_timezone_set('Asia/Hong_Kong');
			$token=bin2hex(openssl_random_pseudo_bytes(16));
			$expireDate=date("Y-m-d", time() + 86400);
			$sql="insert into accesstoken(token,expireDate,uid,thirdparty) values ('$token','$expireDate','$uid',1)";
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_affected_rows($conn)>0){
				$msg=array('result'=>200,'message'=>"success",'data'=>array('code'=>$token));
				}else{
				$msg='failed';
				$msg=array('result'=>500,'message'=>"failed",'data'=>array('return'=>$msg));
			}
			}else{
			$msg='locked';
			$msg=array('result'=>403,'message'=>"locked",'data'=>array('return'=>$msg));
		}
		//mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function getToken($client_id,$redirect_uri,$client_secret,$code,$ip){
		require_once("library/connections/conn.php");
		
		$sql="select * from thirdparty where api_key='$client_id' and redirect_uri='$redirect_uri' and secret='$client_secret'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){	
			$sql="select * from accesstoken where token='$code' and expireDate>NOW()";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$token=bin2hex(openssl_random_pseudo_bytes(16));
				$sql="update accesstoken set token='$token',ip='$ip' where token='$code'";
				mysqli_query($conn,$sql) or die(mysqli_error($conn));
				if(mysqli_affected_rows($conn)>0){
					$msg=array('result'=>200,'message'=>"success",'data'=>array('access_token'=>$token));
					}else{
					$msg='failed';
					$msg=array('result'=>500,'message'=>"failed",'data'=>array('return'=>$msg));
				}
				}else{
				$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
				echo json_encode($msg);
			}
			}else{
			$msg='access_denied';
			$msg=array('result'=>401,'message'=>"failed",'data'=>array('return'=>$msg));
			echo json_encode($msg);
		}
	}
?>