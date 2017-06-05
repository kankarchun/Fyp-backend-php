<?php
	function setTrigger($access_token,$invoiceID){
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
			else if(substr($rc["uid"],0,1)=="R"||substr($rc["uid"],0,1)=="M"||substr($rc["uid"],0,2)=="CM"){
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="insert into trigger_invoice(invoiceID) values ('$invoiceID')"; 
					mysqli_query($conn,$sql);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
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