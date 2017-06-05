<?php
	function setCustReport($access_token,$managerID,$custID,$comment){
		require_once("../library/connections/conn.php");
		
		$sql="select * from accesstoken where token='$access_token' and thirdParty=0";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)<=0){
			$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
			echo json_encode($msg);
			}else{
			$rc=mysqli_fetch_assoc($rs);
			$current=date('Y-m-d H:i:s');
			if($rc['expireDate']<$current){
				$msg=array('result'=>401,'message'=>"login_again",'data'=>array());
				echo json_encode($msg);
			}
			else if(substr($rc["uid"],0,1)=="M"||substr($rc["uid"],0,2)=="CM"){
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					$sql="select reportID from custreport ORDER BY reportID DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$reportID="CR".str_pad(substr($rc['reportID'],2)+1,5,0,STR_PAD_LEFT);
						}else{
						$reportID="CR".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="insert into custreport(reportID,custID,custComment,managerID) values ('$reportID','$custID','$comment','$managerID')"; 
					mysqli_query($conn,$sql);
					if(mysqli_affected_rows($conn)>0){
						$msg=array('result'=>200,'message'=>"Success",'data'=>array());
						}else{
						$msg=array('result'=>404,'message'=>"error",'data'=>array());
					}
					mysqli_close($conn);
					echo json_encode($msg);
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