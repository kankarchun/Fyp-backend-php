<?php
	function getRestDiscount($access_token,$restID){
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
					$sql="select * from charge where restID='$restID' order by orderIn";
					
					$rs=mysqli_query($conn,$sql);
					$FCharge=array();
					if(mysqli_num_rows($rs)>0){
						while($rc=mysqli_fetch_assoc($rs)){
							$Charge=array('chargeID'=>$rc['chargeID'],'charge'=>$rc['charge'],'detailChi'=>$rc['detailChi'],'detailEng'=>$rc['detailEng'],'hide'=>$rc['hide'],'orderIn'=>$rc['orderIn']);
							array_push($FCharge,$Charge);
						}
					}
					
					$final=array('Charge'=>$FCharge);
					$final=array('result'=>200,'message'=>"success",'data'=>$final);
					mysqli_close($conn);
					echo json_encode($final, JSON_UNESCAPED_UNICODE);
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
	
	function setCharge($access_token,$charge){
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
					$sql="select chargeID from charge ORDER BY chargeID DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$chargeID="CH".str_pad(substr($rc['chargeID'],2)+1,5,0,STR_PAD_LEFT);
						}else{
						$chargeID="CH".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="insert into charge(chargeID,restID,charge,hide,detailChi,detailEng,orderIn) values ('$chargeID','".$charge["restID"]."','".$charge["charge"]."','".$charge["hide"]."','".$charge["detailChi"]."','".$charge["detailEng"]."',".$charge["orderIn"].")"; 
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
	
	function updateCharge($access_token,$charge){
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
					$sql="update charge set charge='".$charge["charge"]."',detailChi='".$charge["detailChi"]."',detailEng='".$charge["detailEng"]."',hide='".$charge["hide"]."',orderIn=".$charge["orderIn"]." where chargeID='".$charge["chargeID"]."'"; 
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
	
	function deleteCharge($access_token,$chargeID){
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
					$sql="delete from charge where chargeID='$chargeID'"; 
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