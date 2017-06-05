<?php
	function getRegion($access_token){
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
			else if(substr($rc["uid"],0,2)=="CM"){
				$sql="select * from region";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$msg=array();
				if(mysqli_num_rows($rs)>0){
					while($rc=mysqli_fetch_assoc($rs)){
						array_push($msg,array('rgID'=>$rc['rgID'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName']));
					}
				}
				$final=array('Region'=>$msg);
				$final=array('result'=>200,'message'=>"success",'data'=>$final);
				mysqli_close($conn);
				echo json_encode($final, JSON_UNESCAPED_UNICODE);
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
				
			}
		}
		
		
	}
?>