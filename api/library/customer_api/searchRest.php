<?php
	function getRest(){		
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.locked=0 and restcompany.locked=0";
		
		searching($sql);
	}
	
	function searchRest($keywords){
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and (restChiName like '%$keywords%' or restEngName like '%$keywords%') and restaurant.locked=0 and restcompany.locked=0";
		
		searching($sql);
	}
	
	function searchRegion($region){	
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and (rgChiName like '%$region%' or rgEngName like '%$region%') and restaurant.locked=0 and restcompany.locked=0 order by restaurant.restEngName asc";
		
		searching($sql);
	}
	
	function getRegion(){		
		$sql="select region.rgID,rgChiName,rgEngName from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.locked=0 and restcompany.locked=0 group by region.rgID order by region.rgEngName asc";
		
		regionSearching($sql);
	}
	
	function searchRegionID($regionID){
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.rgID='$regionID' and restaurant.locked=0 and restcompany.locked=0 order by restaurant.restEngName asc";
		
		searching($sql);
	}
	
	function searchRestRegion($keywords,$region){
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and (restChiName like '%$keywords%' or restEngName like '%$keywords%') and (rgChiName like '%$region%' or rgEngName like '%$region%') and restaurant.locked=0 and restcompany.locked=0 order by restaurant.restEngName asc";
		
		searching($sql);
	}
	
	function searchLocation($latitude,$longitude){
		include("../library/customer_api/geoLocation.php");
		$GeoLocation=new GeoLocation();
		$edison = $GeoLocation->fromDegrees($latitude, $longitude);
        $coordinates = $edison->boundingCoordinates(1, 'km');
		$minLatitude=$coordinates[0]->getLatitudeInDegrees();
		$minLongitude=$coordinates[0]->getLongitudeInDegrees();
		$maxLatitude=$coordinates[1]->getLatitudeInDegrees();
		$maxLongitude=$coordinates[1]->getLongitudeInDegrees();
		
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and latitude between $minLatitude and $maxLatitude and longitude between $minLongitude and $maxLongitude and restaurant.locked=0 and restcompany.locked=0 order by restaurant.restEngName asc";
		
		searching($sql);
	}
	
	function regionSearching($sql){
		require_once("../library/connections/conn.php");
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				array_push($msg,array('rgID'=>$rc['rgID'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName']));
			}
		}
		$final=array('Region'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function searching($sql){
		require_once("../library/connections/conn.php");
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				array_push($msg,array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
				'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restAddressEng'=>$rc['restAddressEng'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'deliveryPrice'=>$rc['deliveryPrice'])
				)
				);
			}
		}
		$final=array('Restaurant'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo  json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function scanQR($restID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from restcompany,restaurant,region where restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.locked=0 and restcompany.locked=0 and restID='$restID'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$msg=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
			'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restAddressEng'=>$rc['restAddressEng'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'deliveryPrice'=>$rc['deliveryPrice'])
			);
			
		}
		$final=array('Restaurant'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo  json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function searchTableNo($tableID){
		require_once("../library/connections/conn.php");
		try{
			$sql="select * from restcompany,restaurant,region,resttable where resttable.restid=restaurant.restid and restcompany.companyID=restaurant.companyID and restaurant.rgID=region.rgID and restaurant.locked=0 and restcompany.locked=0 and tableID='$tableID'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$msg=null;
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				if($rc['tableLock']==0){
					$sql="update resttable set tableLock=1 where tableID='$tableID'"; 
					mysqli_query($conn,$sql);
					$msg=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
					'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restAddressEng'=>$rc['restAddressEng'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'deliveryPrice'=>$rc['deliveryPrice']),
					'table'=>array('tableID'=>$rc['tableID'],'tableNo'=>$rc['tableNo'])
					);
					}else{
					throw new Exception('table locked');
				}
			}
			$final=array('RestaurantTable'=>$msg);
			$final=array('result'=>200,'message'=>"success",'data'=>$final);
			mysqli_close($conn);
			echo  json_encode($final, JSON_UNESCAPED_UNICODE);
			}catch(Exception $ex){
			$msg=array('result'=>500,'message'=>"fail",'data'=>$ex->getMessage());
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		}
	}
?>	