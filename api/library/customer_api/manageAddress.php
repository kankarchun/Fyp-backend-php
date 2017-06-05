<?php
	function getAddress($custID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from custaddress where custID='$custID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$Faddress=null;
		if(mysqli_num_rows($rs)>0){
			$Faddress=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$address=array('cAddressNo'=>$rc['cAddressNo'],'address'=>$rc['address']);
				array_push($Faddress,$address);
			}
		}
		$final=array('CustAddress'=>$Faddress);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function setAddress($custID,$address){
		require_once("../library/connections/conn.php");
		
		$sql="select cAddressNo from custaddress ORDER BY cAddressNo DESC LIMIT 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$cAddressNo=str_pad($rc['cAddressNo']+1,5,0,STR_PAD_LEFT);
			}else{
			$cAddressNo=str_pad(1,5,0,STR_PAD_LEFT);
		}
		$sql="insert into custaddress(cAddressNo,address,custID) values ($cAddressNo,'$address','$custID')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array('cAddressNo'=>$cAddressNo));
			}else{
			$msg=array('result'=>500,'message'=>'Failed','data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function updateAddress($address,$cAddressNo){
		require_once("../library/connections/conn.php");
		
		$sql="update custaddress set address='$address' where cAddressNo=$cAddressNo"; 
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
		
	}
	
	function deleteAddress($cAddressNo){
		require_once("../library/connections/conn.php");
		
		$sql="delete from custaddress where cAddressNo=$cAddressNo"; 
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