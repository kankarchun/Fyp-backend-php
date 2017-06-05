<?php
	function getCustAccount(){
		require_once("../library/connections/conn.php");
		
		$sql="select * from customer";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$cust=array('custID'=>$rc['custID'],'custDevice'=>$rc['custDevice'],'custName'=>$rc['custName'],'custTel'=>$rc['custTel'],'locked'=>$rc['locked']);
				array_push($msg,$cust);
			}
		}
		$final=array('CustomerAccount'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getAllRestAccount(){
		require_once("../library/connections/conn.php");
		
		$sql="select * from restaurant";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				array_push($msg,array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'locked'=>$rc['locked'])
				);
			}
		}
		$final=array('Restaurant'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo  json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getRestAccount($companyID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from restaurant where companyID='$companyID'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				array_push($msg,array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'locked'=>$rc['locked'])
				);
			}
		}
		$final=array('Restaurant'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo  json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getRestCompanyAccount(){
		require_once("../library/connections/conn.php");
		
		$sql="select * from restcompany";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$restCompany=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],'locked'=>$rc['locked']);
				array_push($msg,$restCompany);
			}
		}
		$final=array('RestaurantCompanyAccount'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function updateRestAccount($restID,$locked){
		require_once("../library/connections/conn.php");
		
		$sql="update restaurant set locked=$locked where restID='$restID'"; 
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function updateRestCompanyAccount($companyID,$locked){
		require_once("../library/connections/conn.php");
		
		$sql="update restcompany set locked=$locked where companyID='$companyID'"; 
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function updateCustAccount($custID,$locked){
		require_once("../library/connections/conn.php");
		
		$sql="update customer set locked=$locked where custID='$custID'"; 
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function setRestCompanyAccount($restCompanyAccount){
		require_once("../library/connections/conn.php");
		
		$sql="select companyID from restcompany ORDER BY companyID DESC LIMIT 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$companyID="CM".str_pad(substr($rc['companyID'],2)+1,5,0,STR_PAD_LEFT);
			}else{
			$companyID="CM".str_pad(1,5,0,STR_PAD_LEFT);
		}
		$sql="insert into restcompany(companyID,companyPW,companyChiName,companyEngName,companyEmail,locked)
		values ('$companyID','".password_hash(hash('sha512',$restCompanyAccount['companyPW']), PASSWORD_BCRYPT)."','".$restCompanyAccount['companyChiName']."','".$restCompanyAccount['companyEngName']."','".$restCompanyAccount['companyEmail']."',0)"; 
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function setCustAccount($custAccount){
		require_once("../library/connections/conn.php");
		
		$sql="select custID from customer ORDER BY custID DESC LIMIT 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$custID="C".str_pad(substr($rc['custID'],1)+1,5,0,STR_PAD_LEFT);
			}else{
			$custID="C".str_pad(1,5,0,STR_PAD_LEFT);
		}
		$sql="insert into customer(custID,custDevice,custName,custTel,locked)
		values ('$custID','".password_hash($custAccount['custDevice'], PASSWORD_BCRYPT)."','".$custAccount['custName']."','".$custAccount['custTel']."',0)"; 
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	
	function setRestAccount($restAccount){
		require_once("../library/connections/conn.php");
		
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
			
			$sql="select restID from restaurant ORDER BY restID DESC LIMIT 1";
			$rs=mysqli_query($conn,$sql);
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$restID="R".str_pad(substr($rc['restID'],1)+1,5,0,STR_PAD_LEFT);
				}else{
				$restID="R".str_pad(1,5,0,STR_PAD_LEFT);
			}
			date_default_timezone_set('Asia/Hong_Kong');
			$date = date('Y/m/d H:i:s', time());
			$sql="insert into restaurant(restID,companyID,restPW,restChiName,restEngName,restAddress,restAddressEng,rgID,printer,restTel,restEmail,restPhoto,restDesc,restDescEng,registeredDate,locked,latitude,longitude,deliveryPrice)
			values ('$restID','".$restAccount['companyID']."','".password_hash(hash('sha512',$restAccount['restPW']), PASSWORD_BCRYPT)."','".$restAccount['restChiName']."','".$restAccount['restEngName']."','".$restAccount['restAddress']."','".$restAccount['restAddressEng']."','".$restAccount['rgID']."','".$restAccount['printer']."','".$restAccount['restTel']."','".$restAccount['restEmail']."','".$restAccount['restPhoto']."','".$restAccount['restDesc']."','".$restAccount['restDescEng']."','$date',0,$latitude,$longitude,".$restAccount['deliveryPrice'].")"; 
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
?>									