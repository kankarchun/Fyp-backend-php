<?php
	function getCharge($restID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from charge where restID='$restID' and hide='0' order by orderIn";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$FCharge=null;
		if(mysqli_num_rows($rs)>0){
			$FCharge=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$Charge=array('chargeID'=>$rc['chargeID'],'charge'=>$rc['charge'],'detailChi'=>$rc['detailChi'],'detailEng'=>$rc['detailEng']);
				array_push($FCharge,$Charge);
			}
		}
		
		$final=array('Charge'=>$FCharge);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
?>