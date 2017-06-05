<?php
	function getUser($access_token){
		require_once("../library/connections/conn.php");
		
		$sql="select * from accesstoken where token='$access_token' and thirdParty=1";
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
				$uid=$rc["uid"];
				
				$sql="select * from restaurant,restcompany where restcompany.companyID=restaurant.companyID and restID='$uid' and restaurant.locked=0 and restcompany.locked=0";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$data=null;
				if(mysqli_num_rows($rs)>0){
					$rc=mysqli_fetch_assoc($rs);
					$data=array('restID'=>$rc['restID'],'ChiName'=>$rc['restChiName'],'EngName'=>$rc['restEngName'],'address'=>$rc['restAddress'],'addressEng'=>$rc['restAddressEng'],'tel'=>$rc['restTel'],'email'=>$rc['restEmail'],'photo'=>$rc['restPhoto'],'desc'=>$rc['restDesc'],'registeredDate'=>$rc['registeredDate'],
					'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName']);
					$msg=array('result'=>200,'message'=>"success",'data'=>array('restaurant'=>$data));
					echo json_encode($msg);
					}else{
					$sql="select * from manager,restcompany,restaurant where restaurant.restID=manager.restID and restcompany.companyID=manager.companyID and managerID='$uid' and restaurant.locked=0 and restcompany.locked=0";
					$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$data=null;
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						
						$data=array('restID'=>$rc['restID'],'managerID'=>$rc['managerID'],'email'=>$rc['managerEmail'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName']);
						$msg=array('result'=>200,'message'=>"success",'data'=>array('manager'=>$data));
						echo json_encode($msg);
						}else{
						$sql="select * from restcompany where companyID='$uid' and locked=0";
						$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
						$data=null;
						if(mysqli_num_rows($rs)>0){
							$rc=mysqli_fetch_assoc($rs);
							
							$data=array('companyID'=>$rc['companyID'],'ChiName'=>$rc['companyChiName'],'EngName'=>$rc['companyEngName'],'email'=>$rc['companyEmail']);
							$msg=array('result'=>200,'message'=>"success",'data'=>array('company'=>$data));
							echo json_encode($msg);
							}else{
							$msg=array('result'=>403,'message'=>"locked",'data'=>array());
							echo json_encode($msg);
						}
					}
				}
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
				
			}
		}
	}	
?>