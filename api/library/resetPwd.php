<?php
	function forgot($access_token,$password){
		require_once("library/connections/conn.php");
		
		$sql="select * from accesstoken where token='$access_token' and thirdParty=0";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)<=0){
			$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
			return;
		}else{
			$rc=mysqli_fetch_assoc($rs);
			$current=date('Y-m-d H:i:s');
			if($rc['expireDate']<$current){
				$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
				return;
			}
			else if(substr($rc["uid"],0,1)=="CM"){
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				return;
			}
			else{				
				$sql="update restcompany set companyPW='$password' where companyID='".$rc["uid"]."'"; 
				mysqli_query($conn,$sql) or die(mysqli_error($conn));
				if(mysqli_affected_rows($conn)>0){
					$msg=array('result'=>200,'message'=>"Change password success",'data'=>array());
					}else{
					$msg=array('result'=>404,'message'=>"error",'data'=>array());
				}
				mysqli_close($conn);
				echo json_encode($msg);
			}
		}
	}
?>