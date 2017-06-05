<?php
	function setCustNotification($adminID,$custNotification){
		require_once("../library/connections/conn.php");
		foreach($custNotification as $custNotification){
			$sql="select cNID from custnotice ORDER BY cNID DESC LIMIT 1";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$cNID="CN".str_pad(substr($rc['cNID'],2)+1,5,0,STR_PAD_LEFT);
				}else{
				$cNID="CN".str_pad(1,5,0,STR_PAD_LEFT);
			}
			if(array_key_exists('restID',$custNotification)){
				$sql="insert into custnotice(cNID,custID,adminID,title,titleEng,description,descriptionEng,restID) values ('$cNID','".$custNotification['custID']."','$adminID','".$custNotification['title']."','".$custNotification['titleEng']."','".$custNotification['description']."','".$custNotification['descriptionEng']."','".$custNotification['restID']."')"; 
			}else{
				$sql="insert into custnotice(cNID,custID,adminID,title,titleEng,description,descriptionEng) values ('$cNID','".$custNotification['custID']."','$adminID','".$custNotification['title']."','".$custNotification['titleEng']."','".$custNotification['description']."','".$custNotification['descriptionEng']."')"; 
			}
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
		}
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function setCompanyNotification($adminID,$companyNotification){
		require_once("../library/connections/conn.php");
		foreach($companyNotification as $companyNotification){
			$sql="select rNID from restnotice ORDER BY rNID DESC LIMIT 1";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$rNID="RN".str_pad(substr($rc['rNID'],2)+1,5,0,STR_PAD_LEFT);
				}else{
				$rNID="RN".str_pad(1,5,0,STR_PAD_LEFT);
			}
			$sql="insert into restnotice(rNID,companyID,adminID,title,titleEng,description,descriptionEng) values ('$rNID','".$companyNotification['companyID']."','$adminID','".$companyNotification['title']."','".$companyNotification['titleEng']."','".$companyNotification['description']."','".$companyNotification['descriptionEng']."')"; 
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
		}
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
?>