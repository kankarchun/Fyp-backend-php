<?php
	function getTableQR($restID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from resttable where restID='$restID'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$table=array('tableID'=>$rc['tableID'],'restID'=>$rc['restID']);
				array_push($msg,$table);
			}
		}
		$final=array('TableQR'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
?>