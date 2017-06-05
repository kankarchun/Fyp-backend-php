<?php
	function getTrigger($restID){
		require_once("../library/connections/conn.php");
		require_once("../library/customer_api/makeOrder.php");
		$sql="select * from trigger_invoice,invoice where invoice.invoiceID=trigger_invoice.invoiceID and restID='$restID' order by trigger_invoice.invoiceID desc limit 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			$rc=mysqli_fetch_assoc($rs);
			$data=getInvoice($conn,$rc["invoiceID"]);
			array_push($msg,$data);
			$sql="delete from trigger_invoice where invoiceID='".$rc["invoiceID"]."'"; 
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$sql="select count(*) as count from trigger_invoice,invoice where invoice.invoiceID=trigger_invoice.invoiceID and restID='$restID'"; 
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$rc=mysqli_fetch_assoc($rs);
		}
		$final=array('TriggerInvoice'=>$msg,'count'=>$rc['count']);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
?>