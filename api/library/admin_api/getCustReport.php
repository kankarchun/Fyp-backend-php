<?php
	function getCustReport(){
		require_once("../library/connections/conn.php");
				
		$sql="select * from custreport,customer where custreport.custID=customer.custID";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$cust=array('reportID'=>$rc['reportID'],'custID'=>$rc['custID'],'custName'=>$rc['custName'],'custTel'=>$rc['custTel'],'locked'=>$rc['locked'],'custComment'=>$rc['custComment'],'managerID'=>$rc['managerID']);
				array_push($msg,$cust);
			}
		}
		$final=array('CustReport'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	?>