<?php
	function getRegion(){
		require_once("../library/connections/conn.php");
		
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
?>