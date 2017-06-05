<?php
	function getAdminInfo($adminID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from admin where adminID='$adminID'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$msg=array('userName'=>$rc['userName']);
		}
		$final=array('AdminAccount'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function updateAdminInfo($adminAccount){
		require_once("../library/connections/conn.php");
		
		$sql="update admin set password='".$adminAccount["password"]."',userName='".$adminAccount["userName"]."' where adminID='".$adminAccount["adminID"]."'"; 
		
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
?>