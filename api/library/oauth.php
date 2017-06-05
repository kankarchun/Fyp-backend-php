<?php
	function login($uid,$password){
		require_once("library/connections/conn.php");
		
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
			if(mysqli_affected_rows($conn)>0){
				$msg=array('result'=>200,'message'=>"success",'data'=>array('token'=>$token,'uid'=>$uid));
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
	
	function oauth($token,$uid,$ip){
		require_once("library/connections/conn.php");
		
		$sql="select * from accesstoken where token='$token' and uid='$uid' and expireDate>NOW()";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$sql="update accesstoken set ip='$ip' where token='$token' and uid='$uid'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			getUser($conn,$rc['uid'],$token);
			
			}else{
			$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
			echo json_encode($msg);
		}
	}
	
	function getUser($conn,$uid,$token){
		$sql="select * from restaurant,restcompany where restcompany.companyID=restaurant.companyID and restID='$uid' and restaurant.locked=0 and restcompany.locked=0";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$data=null;
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$data=array('restID'=>$rc['restID'],'ChiName'=>$rc['restChiName'],'EngName'=>$rc['restEngName'],'address'=>$rc['restAddress'],'addressEng'=>$rc['restAddressEng'],'tel'=>$rc['restTel'],'email'=>$rc['restEmail'],'photo'=>$rc['restPhoto'],'desc'=>$rc['restDesc'],'registeredDate'=>$rc['registeredDate'],
						'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName']);
			$msg=array('result'=>200,'message'=>"success",'data'=>array('restaurant'=>$data));
			echo json_encode($msg);
			}else{
			$sql="select * from manager,restcompany,restaurant where restaurant.restID=manager.restID and restcompany.companyID=manager.companyID and managerID='$uid' and restaurant.locked=0 and restcompany.locked=0";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$data=null;
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				
				$data=array('restID'=>$rc['restID'],'managerID'=>$rc['managerID'],'email'=>$rc['managerEmail'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName']);
				$msg=array('result'=>200,'message'=>"success",'data'=>array('manager'=>$data));
				echo json_encode($msg);
				}else{
				$sql="select * from restcompany where companyID='$uid' and locked=0";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$data=null;
				if(mysqli_num_rows($rs)>0){
					$rc=mysqli_fetch_assoc($rs);
					
					$data=array('companyID'=>$rc['companyID'],'ChiName'=>$rc['companyChiName'],'EngName'=>$rc['companyEngName'],'email'=>$rc['companyEmail']);
					$msg=array('result'=>200,'message'=>"success",'data'=>array('company'=>$data));
					echo json_encode($msg);
					}else{
					$msg=array('result'=>403,'message'=>"locked",'data'=>array());
					echo json_encode($msg);
				}
			}
		}
	}		
?>