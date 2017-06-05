<?php
	function getFood($access_token,$restID){
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
				$sql="select * from food where restID='$restID'";
				
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$foodMsg=array();
				if(mysqli_num_rows($rs)>0){					
					while($rc=mysqli_fetch_assoc($rs)){
						$food=array('foodID'=>$rc['foodID'],'foodChiName'=>$rc['foodChiName'],'foodEngName'=>$rc['foodEngName'],'foodPrice'=>$rc['foodPrice'],'foodPhoto'=>$rc['foodPhoto'],'foodDesc'=>$rc['foodDesc'],'foodDescEng'=>$rc['foodDescEng'],'foodTakeout'=>$rc['foodTakeout'],'available'=>$rc['available']
						);
						array_push($foodMsg,$food);
					}
				}
				
				$final=array('Food'=>$foodMsg);
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
	
	function getSet($access_token,$restID){
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
				$sql="select * from setitem where restID='$restID'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$setMsg=array();
				if(mysqli_num_rows($rs)>0){
					while($rc=mysqli_fetch_assoc($rs)){
						$sql="select * from settitle where setID='".$rc['setID']."'";
						$rsSetTitle=mysqli_query($conn,$sql) or die(mysqli_error($conn));
						$FsetTitle=array();
						while($rcSetTitle=mysqli_fetch_assoc($rsSetTitle)){
							$sql="select * from setfood where  titleNo='".$rcSetTitle['titleNo']."'";
							$rsSetFood=mysqli_query($conn,$sql) or die(mysqli_error($conn));
							$FsetFood=array();
							while($rcSetFood=mysqli_fetch_assoc($rsSetFood)){
								$sql="select * from food where foodID='".$rcSetFood['foodID']."'";
								$rsSetItem=mysqli_query($conn,$sql) or die(mysqli_error($conn));
								$rcSetItem=mysqli_fetch_assoc($rsSetItem);
								$setfood=array('foodID'=>$rcSetItem['foodID'],'foodChiName'=>$rcSetItem['foodChiName'],'foodEngName'=>$rcSetItem['foodEngName'],'foodPhoto'=>$rcSetItem['foodPhoto'],'foodDesc'=>$rcSetItem['foodDesc'],'foodDescEng'=>$rcSetItem['foodDescEng'],'available'=>$rcSetItem['available']);
								
								$setFoods=array('extraPrice'=>$rcSetFood['extraPrice'],'food'=>$setfood);
								array_push($FsetFood,$setFoods);
							}
							$setTitle=array('title'=>$rcSetTitle['title'],'titleEng'=>$rcSetTitle['titleEng'],'count'=>$rcSetTitle['count'],
							'setFood'=>$FsetFood);
							array_push($FsetTitle,$setTitle);
						}
						$set=array('setID'=>$rcSet['setID'],'setChiName'=>$rcSet['setChiName'],'setEngName'=>$rcSet['setEngName'],'totalPrice'=>$rcSet['totalPrice'],'setPhoto'=>$rcSet['setPhoto'],'setDesc'=>$rcSet['setDesc'],'setDescEng'=>$rcSet['setDescEng'],'setTakeout'=>$rcSet['setTakeout'],'available'=>$rcSet['available'],
						'setTitle'=>$FsetTitle);
						array_push($setMsg,$set);
					}
				}
				$final=array('Set'=>$setMsg);
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
	
	function updateSetItem($access_token,$setID,$available){
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
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="update setitem set available='$available' where setID='$setID'"; 
					mysqli_query($conn,$sql);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
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
	
	function updateFood($access_token,$foodID,$available){
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
				try{
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="update food set available='$available' where foodID='$foodID'"; 
					mysqli_query($conn,$sql);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
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