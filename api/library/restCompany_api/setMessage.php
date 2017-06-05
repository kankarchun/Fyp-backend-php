<?php	
	function setMessage($access_token,$companyID,$message){
		require_once("../library/connections/conn.php");
		
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
				echo json_encode($msg);
			}
			else if(substr($rc["uid"],0,2)=="CM"){
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					$sql="insert into adminmessage(companyID,message) values ('$companyID','$message')"; 
					mysqli_query($conn,$sql);
					if(mysqli_affected_rows($conn)>0){
						$msg=array('result'=>200,'message'=>"Success",'data'=>array());
						}else{
						$msg=array('result'=>404,'message'=>"error",'data'=>array());
					}
					mysqli_close($conn);
					echo json_encode($msg, JSON_UNESCAPED_UNICODE);
					}catch(Exception $ex){
					$msg=array('result'=>500,'message'=>"fail",'data'=>$ex->getMessage());
					echo json_encode($msg, JSON_UNESCAPED_UNICODE);
				}
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
			}
		}
	}
?>