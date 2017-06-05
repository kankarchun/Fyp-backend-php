<?php
	function getRestAccount($access_token,$restID){
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
			else if(substr($rc["uid"],0,1)=="M"||substr($rc["uid"],0,2)=="CM"){
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.locked=0 and restID='$restID'";
					$rs=mysqli_query($conn,$sql);
					$msg=array();
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$msg=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
						'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restAddressEng'=>$rc['restAddressEng'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'locked'=>$rc['locked'],'latitude'=>$rc['latitude'],'longitude'=>$rc['longitude'],'deliveryPrice'=>$rc['deliveryPrice'])
						);
					}
					$final=array('RestaurantAccount'=>$msg);
					$final=array('result'=>200,'message'=>"success",'data'=>$final);
					mysqli_close($conn);
					echo json_encode($final, JSON_UNESCAPED_UNICODE);
					}catch(Exception $ex){
					$msg=array('result'=>500,'message'=>"fail",'data'=>$ex->getMessage());
					echo json_encode($msg, JSON_UNESCAPED_UNICODE);
				}
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
			}
		}
		
		
	}
	
	function updateRestAccount($access_token,$restAccount){
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
			else if(substr($rc["uid"],0,1)=="M"||substr($rc["uid"],0,2)=="CM"){
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

					$API_KEY='AIzaSyDwmj7UOe54eQVTfmTydGwE6sBLbs2fgi4';
					$address = $restAccount['address']; // Google HQ
					$prepAddr = str_replace(' ','+',$address);
					$geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false&key='.$API_KEY);
					$output= json_decode($geocode);
					$latitude = $output->results[0]->geometry->location->lat;
					$longitude = $output->results[0]->geometry->location->lng;
					if($latitude==null||$longitude==null){
						throw new Exception("wrong address");
					}
					$sql="update restaurant set latitude=$latitude,longitude=$longitude,deliveryPrice=".$restAccount["deliveryPrice"].",restPw='".$restAccount["restPW"]."',restChiName='".$restAccount["restChiName"]."',restEngName='".$restAccount["restEngName"]."',restAddress='".$restAccount["restAddress"]."',restAddressEng='".$restAccount["restAddressEng"]."',rgID='".$restAccount["rgID"]."',printer='".$restAccount["printer"]."',restTel='".$restAccount["restTel"]."',restEmail='".$restAccount["restEmail"]."',restPhoto='".$restAccount["restPhoto"]."',restDesc='".$restAccount["restDesc"]."',restDescEng='".$restAccount["restDescEng"]."',locked=".$restAccount["locked"]." where restID='".$restAccount["restID"]."'"; 

					//$sql="update restaurant set latitude=".$restAccount["latitude"].",longitude=".$restAccount["longitude"].",deliveryPrice=".$restAccount["deliveryPrice"].",restPw='".$restAccount["restPW"]."',restChiName='".$restAccount["restChiName"]."',restEngName='".$restAccount["restEngName"]."',restAddress='".$restAccount["restAddress"]."',restAddressEng='".$restAccount["restAddressEng"]."',rgID='".$restAccount["rgID"]."',printer='".$restAccount["printer"]."',restTel='".$restAccount["restTel"]."',restEmail='".$restAccount["restEmail"]."',restPhoto='".$restAccount["restPhoto"]."',restDesc='".$restAccount["restDesc"]."',restDescEng='".$restAccount["restDescEng"]."',locked=".$restAccount["locked"]." where restID='".$restAccount["restID"]."'"; 
					mysqli_query($conn,$sql);
					if(mysqli_affected_rows($conn)>0){
						$msg=array('result'=>200,'message'=>"Success",'data'=>array());
						}else{
						$msg=array('result'=>404,'message'=>"error",'data'=>array());
					}
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					$msg=array('result'=>500,'message'=>"fail",'data'=>$ex->getMessage());
					echo json_encode($msg, JSON_UNESCAPED_UNICODE);
				}
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
			}
		}
		
		
	}
?>													