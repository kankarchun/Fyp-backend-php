<?php
	function getOptionAllow($foodID){
		require_once("../library/connections/conn.php");

		$sql="select * from specialoption where optid in (select optid from optionallow where foodID='$foodID')";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc = mysqli_fetch_assoc($rs)){
				$allow=array('optID'=>$rc['optID'],'contentChi'=>$rc['contentChi'],'contentEng'=>$rc['contentEng'],'extraPrice'=>$rc['extraPrice']);
				array_push($msg,$allow);
			}
		}
		$msg=array('OptionAllow'=>$msg);
		$msg=array('result'=>200,'message'=>"success",'data'=>$msg);
		mysqli_close($conn);
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
	}
?>