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
							$setTitle=array('titleNo'=>$rcSetTitle['titleNo'],'title'=>$rcSetTitle['title'],'titleEng'=>$rcSetTitle['titleEng'],'count'=>$rcSetTitle['count'],
							'setFood'=>$FsetFood);
							array_push($FsetTitle,$setTitle);
						}
						$set=array('setID'=>$rc['setID'],'setChiName'=>$rc['setChiName'],'setEngName'=>$rc['setEngName'],'totalPrice'=>$rc['totalPrice'],'setPhoto'=>$rc['setPhoto'],'setDesc'=>$rc['setDesc'],'setDescEng'=>$rc['setDescEng'],'setTakeout'=>$rc['setTakeout'],'available'=>$rc['available'],
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
	
	function setSetItem($access_token,$setItem){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="select setID from setitem ORDER BY setID DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$setID="S".str_pad(substr($rc['setID'],1)+1,5,0,STR_PAD_LEFT);
						}else{
						$setID="S".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="insert into setitem(setID,restID,setChiName,setEngName,totalPrice,setPhoto,setDesc,setDescEng,setTakeout,managerID) values 
					('$setID','".$setItem["restID"]."','".$setItem["setChiName"]."','".$setItem["setEngName"]."',-9999,'".$setItem["setPhoto"]."','".$setItem["setDesc"]."','".$setItem["setDescEng"]."','".$setItem["setTakeout"]."','".$setItem["managerID"]."')"; 
					mysqli_query($conn,$sql);

					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function setSetTitle($access_token,$title){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="insert into settitle(setID,title,titleEng,count) values ('".$title["setID"]."','".$title["title"]."','".$title["titleEng"]."',".$title["count"].")"; 
					mysqli_query($conn,$sql);

					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function setSetFood($access_token,$setFood){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="select foodNo from setfood ORDER BY foodNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$foodNo=str_pad($rc['foodNo']+1,5,0,STR_PAD_LEFT);
						}else{
						$foodNo=str_pad(1,5,0,STR_PAD_LEFT);
					}
					
					$sql="insert into setfood(foodNo,setID,foodID,titleNo,extraPrice) values ($foodNo,'".$setFood["setID"]."','".$setFood["foodID"]."',$titleNo,".$setFood["extraPrice"].")"; 
					mysqli_query($conn,$sql);

					mysqli_commit($conn);
					
					$setItemPrice=0;
					
					$sql="select foodPrice from setfood,food where setfood.foodID=food.foodID and setfood.setID='".$setFood["setID"]."'";
					$rs=mysqli_query($conn,$sql);
					while($rc=mysqli_fetch_assoc($rs)){
						$setItemPrice+=$rc["foodPrice"];
					}
					
					mysqli_autocommit($conn,FALSE);
					
					$sql="update setitem set totalPrice=$setItemPrice where setID='".$setFood["setID"]."'"; 
					mysqli_query($conn,$sql);
					
					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function setFood($access_token,$food){
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
					
					$sql="select foodID from food ORDER BY foodID DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$foodID="F".str_pad(substr($rc['foodID'],1)+1,5,0,STR_PAD_LEFT);
						}else{
						$foodID="F".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="insert into food(foodID,restID,foodChiName,foodEngName,foodPrice,foodPhoto,foodDesc,foodDescEng,foodTakeout,managerID) values 
					('$foodID','".$food["restID"]."','".$food["foodChiName"]."','".$food["foodEngName"]."',".$food["foodPrice"].",'".$food["foodPhoto"]."','".$food["foodDesc"]."','".$food["foodDescEng"]."','".$food["foodTakeout"]."','".$food["managerID"]."')"; 
					mysqli_query($conn,$sql);
					mysqli_close($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					echo json_encode($msg);
					}catch(Exception $ex){
					$msg=array('result'=>500,'message'=>"fail",'data'=>$ex->getMessage()."\n".$sql);
					echo json_encode($msg, JSON_UNESCAPED_UNICODE);
				}
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
				
			}
		}
	}
	
	function updateSetItem($access_token,$setItem){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					$setItemPrice=0;
					
					$sql="select foodPrice from setfood,food where setfood.foodID=food.foodID and setfood.setID='".$setItem["setID"]."'";
					$rs=mysqli_query($conn,$sql);
					while($rc=mysqli_fetch_assoc($rs)){
						$setItemPrice+=$rc["foodPrice"];
					}
					
					$sql="update setitem set available='".$setItem["available"]."',groupNo='".$setItem["groupNo"]."',setChiName='".$setItem["setChiName"]."',setEngName='".$setItem["setEngName"]."',totalPrice=$setItemPrice,setPhoto='".$setItem["setPhoto"]."',setDesc='".$setItem["setDesc"]."',setDescEng='".$setItem["setDescEng"]."',setTakeout='".$setItem["setTakeout"]."',managerID='".$setItem["managerID"]."' where setID='".$setItem["setID"]."'"; 
					mysqli_query($conn,$sql);

					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function updateSetTitle($access_token,$title){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					$setItemPrice=0;
					
					$sql="update settitle set setID='".$title["setID"]."',title='".$title["titleName"]."',titleEng='".$title["titleEng"]."',count='".$title["count"]."' where titleNo='".$title["titleNo"]."'"; 
					mysqli_query($conn,$sql);

					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function updateSetFood($access_token,$setFood){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					$setItemPrice=0;
					
					
					$sql="update setfood set groupNo='".$setFood["groupNo"]."',foodID='".$setFood["foodID"]."',titleNo='".$title["titleNo"]."',extraPrice=".$setFood["extraPrice"]." where foodNo='".$setFood["foodNo"]."'"; 
					mysqli_query($conn,$sql);
								
					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function updateFood($access_token,$food){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="update food set available='".$food["available"]."',groupNo='".$food["groupNo"]."',foodChiName='".$food["foodChiName"]."',foodEngName='".$food["foodEngName"]."',foodPrice=".$food["foodPrice"].",foodPhoto='".$food["foodPhoto"]."',foodDesc='".$food["foodDesc"]."',foodDescEng='".$food["foodDescEng"]."',foodTakeout='".$food["foodTakeout"]."',managerID='".$food["managerID"]."' where foodID='".$food["foodID"]."'"; 
					mysqli_query($conn,$sql);

					mysqli_commit($conn);
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function deleteSetItem($access_token,$setID){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					//setitem>setfood,setitle,favouriteset(favouritesetchoice fsid(favouritechoiceoption fscid),menugroupitem
					$sql="delete from favouritechoiceoption where fscID in (select fscID from favouritesetchoice where foodNo in (select foodNo from setfood where setID='$setID'))"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouritesetchoice where foodNo in (select foodNo from setfood where setID='$setID')"; 
					mysqli_query($conn,$sql);
					$sql="delete from setfood where setID='$setID'"; 
					mysqli_query($conn,$sql);
					$sql="delete from settitle where setID='$setID'"; 
					mysqli_query($conn,$sql);
					$sql="delete from menugroupitem where setID='$setID'"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouritechoiceoption where fscID in (select fscID from favouritesetchoice where fsID in (select fsID from favouriteset where setID='$setID'))"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouritesetchoice where fsID in (select fsID from favouriteset where setID='$setID')"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouriteset where setID='$setID'"; 
					mysqli_query($conn,$sql);
					
					$sql="delete from setitem where setID='$setID'"; 
					mysqli_query($conn,$sql);
					
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_commit($conn);
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function deleteFood($access_token,$foodID){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					//food>setfood,favouritefood(favouriteorderoption ffid),optionallow,meungroupitem
					$sql="delete from menugroupitem where foodID='$foodID'"; 
					mysqli_query($conn,$sql);
					$sql="delete from optionallow where foodID='$foodID'"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouriteorderoption where ffID in (select ffID from favouritefood where foodID='$foodID')"; 
					mysqli_query($conn,$sql);
					$sql="delete from setfood where foodID='$foodID'"; 
					mysqli_query($conn,$sql);
					$sql="delete from food where foodID='$foodID'"; 
					mysqli_query($conn,$sql);
					
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_commit($conn);
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function deleteSetFood($access_token,$foodNo){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="delete from favouritechoiceoption where fscID in (select fscID from favouritesetchoice where foodNo='$foodNo')"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouritesetchoice where foodNo='$foodNo'"; 
					mysqli_query($conn,$sql);
					$sql="delete from setfood where foodNo='$foodNo'"; 
					mysqli_query($conn,$sql);
					
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_commit($conn);
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
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
	
	function deleteSetTitle($access_token,$titleNo){
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
					mysqli_autocommit($conn,FALSE);
					mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
					
					$sql="delete from favouritechoiceoption where fscID in (select fscID from favouritesetchoice where foodNo in (select foodNo from setfood where titleNo='$titleNo'))"; 
					mysqli_query($conn,$sql);
					$sql="delete from favouritesetchoice where foodNo in (select foodNo from setfood where titleNo='$titleNo')"; 
					mysqli_query($conn,$sql);
					$sql="delete from setfood where titleNo='$titleNo'"; 
					mysqli_query($conn,$sql);
					
					$sql="delete from settitle where titleNo='$titleNo'"; 
					mysqli_query($conn,$sql);
					
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_commit($conn);
					mysqli_close($conn);
					echo json_encode($msg);
					}catch(Exception $ex){
					mysqli_rollback($conn);
					$msg=array('result'=>500,'message'=>"Please delete setFood first",'data'=>$ex->getMessage());
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