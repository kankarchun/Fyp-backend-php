<?php
	require_once("library/connections/DbOperation.php");
	
	$db=new DbOperation();
	
		$customers=$db->getChargeByRestaurantID("R00001");
		
		$FCharge=array();
		foreach($customers as $rc)
		{
		$Charge=array('chargeID'=>$rc['chargeID'],'charge'=>$rc['charge'],'detailChi'=>$rc['detailChi'],'detailEng'=>$rc['detailEng']);
		array_push($FCharge,$Charge);
		}
		
		$final=array('Charge'=>$FCharge);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
	
	/*
	$customers=$db->createCustomerAddress("2","test address","C00001");
	if($customers){
		$final=array('result'=>200,'message'=>"Success",'data'=>array());
		}else{
		$final=array('result'=>500,'message'=>'Failed','data'=>array());
	}
	*/
	echo json_encode($final, JSON_UNESCAPED_UNICODE);
	
?>