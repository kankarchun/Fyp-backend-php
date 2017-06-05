<?php
	function login($uid,$password){
		require_once("library/connections/conn.php");
		
		$sql="select * from customer where custTel='$uid'"; 
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			if(password_verify($password,$rc['custDevice'])){
				checkDB($conn,$rc["locked"],$rc["custID"]);
				}else{
				$msg='access_denied';
				$msg=array('result'=>401,'message'=>"failed",'data'=>array('return'=>$msg));
				echo json_encode($msg);
			}
			}else{
			$sql="select * from admin where userName='$uid'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				if(password_verify($password,$rc['password'])){
					checkDB($conn,0,$rc["adminID"]);
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
	
	function checkDB($conn,$locked,$uid){
		$sql="delete from accesstoken where uid='$uid'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if($locked==0){
			date_default_timezone_set('Asia/Hong_Kong');
			$token=bin2hex(openssl_random_pseudo_bytes(16));
			$expireDate=date("Y-m-d", time() + 86400);

			$sql="insert into accesstoken(token,expireDate,uid) values ('$token','$expireDate','$uid')";
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			//$msg="?access_token=$token&uid=$uid";
			$msg=array('result'=>200,'message'=>"success",'data'=>array('token'=>$token,'uid'=>$uid));
			}else{
			$msg='locked';
			$msg=array('result'=>403,'message'=>"locked",'data'=>array('return'=>$msg));
		}
		//mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function oauth($token,$uid,$ip){
		require_once("library/connections/conn.php");
		
		$sql="select * from accesstoken where token='$token' and uid='$uid' and expireDate>NOW()";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$sql="update accesstoken set ip='$ip' where token='$token' and uid='$uid'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			
			getUser($conn,$rc['uid'],$token);
			//mysqli_close($conn);
			}else{
			//mysqli_close($conn);
			$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
			echo json_encode($msg);
		}
	}
	
	function getUser($conn,$uid,$token){
		$sql="select * from customer where custID ='$uid' and locked=0";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$data=null;
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			
			$data=array('custID'=>$rc['custID'],'name'=>$rc['custName'],'tel'=>$rc['custTel']);
			$msg=array('result'=>200,'message'=>"success",'data'=>array('customer'=>$data));
			echo json_encode($msg);
			}else{
			$sql="select * from admin where adminID='$uid'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$data=null;
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$data=array('adminID'=>$rc['adminID'],'username'=>$rc['userName']);
				$msg=array('result'=>200,'message'=>"success",'data'=>array('admin'=>$data));
				echo json_encode($msg);
				}else{
				$msg=array('result'=>403,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
			}
		}
	}
?>