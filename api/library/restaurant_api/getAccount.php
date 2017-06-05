<?php
	function getRestInfo($access_token,$restID){
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
			else if(substr($rc["uid"],0,1)=="R"||substr($rc["uid"],0,1)=="M"||substr($rc["uid"],0,2)=="CM"){
				$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.locked=0 and restcompany.locked=0 and restaurant.restID='$restID'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$msg=array();
				if(mysqli_num_rows($rs)>0){
					$rc=mysqli_fetch_assoc($rs);
					$msg=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
					'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],"printer"=>$rc['printer'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'locked'=>$rc['locked'],'deliveryPrice'=>$rc['deliveryPrice'])
					);
				}
				$final=array('RestaurantAccount'=>$msg);
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