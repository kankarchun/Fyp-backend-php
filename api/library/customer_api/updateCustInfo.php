<?php
	function updateCustInfo($custID,$custName){
		require_once("../library/connections/conn.php");
		
		$sql="update customer set custName='$custName' where custID='$custID'";
		
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('status'=>true,'msg'=>"success");
		}else{
			$msg=array('status'=>false,'msg'=>"No record");
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
?>