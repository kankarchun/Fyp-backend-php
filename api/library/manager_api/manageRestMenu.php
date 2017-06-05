<?php	
	function getMenu($access_token,$restID){
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
					$sql="select * from menugroup where restID='$restID'";
					$rs=mysqli_query($conn,$sql);
					$msg=array();
					if(mysqli_num_rows($rs)>0){
						while($rc=mysqli_fetch_assoc($rs)){
							array_push($msg,array('restID'=>$rc['restID'],'groupNo'=>$rc['groupNo'],'groupChiName'=>$rc['groupChiName'],'groupEngName'=>$rc['groupEngName'],'startTime'=>$rc['startTime'],'openHour'=>$rc['openHour'],'showDay'=>$rc['showDay'],'managerID'=>$rc['managerID'],'groupEngName'=>$rc['groupEngName'],'lastModify'=>$rc['lastModify']));
						}
					}
					$final=array('RestaurantMenu'=>$msg);
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
	
	function getMenuItem($access_token,$restID,$menuID){
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
					$sql="select * from menugroupitem where restID='$restID' and groupNo=$menuID order by rowNumber,columnNumber";
					$rs=mysqli_query($conn,$sql);
					$msg=array();
					if(mysqli_num_rows($rs)>0){
						while($rc=mysqli_fetch_assoc($rs)){
							$food=array();
							$set=array();
							$sql="select * from menuwidget where widgetID='".$rc['widgetID']."'";
							$rsWid=mysqli_query($conn,$sql) or die(mysqli_error($conn));
							$rcWid=mysqli_fetch_assoc($rsWid);
							$widget=array('widgetID'=>$rcWid['widgetID'],'showPhotos'=>$rcWid['showPhotos'],'rowSpan'=>$rcWid['rowSpan'],'colSpan'=>$rcWid['colSpan']);
							if($rc['foodID']!=null){
								$sql="select * from food where foodID='".$rc['foodID']."'";
								$rsFood=mysqli_query($conn,$sql) or die(mysqli_error($conn));
								$rcFood=mysqli_fetch_assoc($rsFood);
								$food=array('foodID'=>$rcFood['foodID'],'foodChiName'=>$rcFood['foodChiName'],'foodEngName'=>$rcFood['foodEngName'],'foodPrice'=>$rcFood['foodPrice'],'foodPhoto'=>$rcFood['foodPhoto'],'foodDesc'=>$rcFood['foodDesc'],'foodDescEng'=>$rcFood['foodDescEng'],'foodTakeout'=>$rcFood['foodTakeout'],'available'=>$rcFood['available']);
								
								}else if($rc['setID']!=null){
								$sql="select * from setitem where setID='".$rc['setID']."'";
								$rsSet=mysqli_query($conn,$sql) or die(mysqli_error($conn));
								$rcSet=mysqli_fetch_assoc($rsSet);
								
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
										
										$setFoods=array('foodNo'=>$rcSetFood['foodNo'],'extraPrice'=>$rcSetFood['extraPrice'],'food'=>$setfood);
										array_push($FsetFood,$setFoods);
									}
									$setTitle=array('title'=>$rcSetTitle['title'],'titleEng'=>$rcSetTitle['titleEng'],'count'=>$rcSetTitle['count'],
									'setFood'=>$FsetFood);
									array_push($FsetTitle,$setTitle);
								}
								$set=array('setID'=>$rcSet['setID'],'setChiName'=>$rcSet['setChiName'],'setEngName'=>$rcSet['setEngName'],'totalPrice'=>$rcSet['totalPrice'],'setPhoto'=>$rcSet['setPhoto'],'setDesc'=>$rcSet['setDesc'],'setDescEng'=>$rcSet['setDescEng'],'setTakeout'=>$rcSet['setTakeout'],'available'=>$rcSetItem['available'],
								'setTitle'=>$FsetTitle);
							}
							$data=array('itemNo'=>$rc['itemNo'],'restID'=>$rc['restID'],'groupNo'=>$rc['groupNo'],'rowNumber'=>$rc['rowNumber'],'columnNumber'=>$rc['columnNumber'],'color'=>$rc['color'],'food'=>$food,'set'=>$set,'widget'=>$widget); //row column
							array_push($msg,$data);
						}
					}
					
					$final=array('MenuItem'=>$msg);
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
	
	function setMenu($access_token,$menu){
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
					$sql="select groupNo from menugroup ORDER BY groupNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$groupNo=str_pad($rc['groupNo']+1,5,0,STR_PAD_LEFT);
						}else{
						$groupNo=str_pad(1,5,0,STR_PAD_LEFT);
					}
					date_default_timezone_set('Asia/Hong_Kong');
					$date = date('Y/m/d H:i:s', time());
					if($menu["openHour"]<=0){
						throw new Exception("openHour than 0");
					}
					$sql="insert into menugroup(restID,groupNo,groupChiName,groupEngName,startTime,openHour,showDay,managerID,lastModify) values ('".$menu["restID"]."',$groupNo,'".$menu["groupChiName"]."','".$menu["groupEngName"]."','".$menu["startTime"]."',".$menu["openHour"].",'".$menu["showDay"]."','".$menu["managerID"]."','$date')"; 
					mysqli_query($conn,$sql);
					
					$msg=array('result'=>200,'message'=>"Success",'data'=>array());
					mysqli_close($conn);
					echo json_encode($msg, JSON_UNESCAPED_UNICODE);
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
	
	function setMenuItem($access_token,$menuItem){
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
					$sql="select * from menuwidget where widgetID='".$menuItem["widgetID"]."'";
					$rsWidget=mysqli_query($conn,$sql);
					$rcWidget=mysqli_fetch_assoc($rsWidget);
					$colSpan=$rcWidget['colSpan'];
					$sColumnNumber=$menuItem["columnNumber"];
					if($colSpan>=3){
						$columnNumber=0;
						}else if($colSpan<=2&&($sColumnNumber==0||$sColumnNumber==1)){
						$columnNumber=$sColumnNumber;
						}else{
						$columnNumber=0;
					}
					
					$sql="select itemNo from menugroupitem ORDER BY itemNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$itemNo="IT".str_pad(substr($rc['itemNo'],2)+1,5,0,STR_PAD_LEFT);
						}else{
						$itemNo="IT".str_pad(1,5,0,STR_PAD_LEFT);
					}
					if(array_key_exists('foodID',$menuItem)){
						$sql="insert into menugroupitem(itemNo,restID,groupNo,foodID,widgetID,rowNumber,columnNumber,color) values ('$itemNo','".$menuItem["restID"]."',".$menuItem["groupNo"].",'".$menuItem["foodID"]."','".$menuItem["widgetID"]."',".$menuItem["rowNumber"].",$columnNumber,'".$menuItem["color"]."')"; 
						}else if(array_key_exists('setID',$menuItem)){
						$sql="insert into menugroupitem(itemNo,restID,groupNo,setID,widgetID,rowNumber,columnNumber,color) values ('$itemNo','".$menuItem["restID"]."',".$menuItem["groupNo"].",'".$menuItem["setID"]."','".$menuItem["widgetID"]."',".$menuItem["rowNumber"].",$columnNumber,'".$menuItem["color"]."')"; 
					}
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
	
	function updateMenu($access_token,$menu){
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
					date_default_timezone_set('Asia/Hong_Kong');
					$date = date('Y/m/d H:i:s', time());
					$sql="update menugroup set groupChiName='".$menu["groupChiName"]."',groupEngName='".$menu["groupEngName"]."',startTime='".$menu["startTime"]."',openHour=".$menu["openHour"].",showDay='".$menu["showDay"]."',managerID='".$menu["managerID"]."',lastModify='$date' where restID='".$menu["restID"]."' and groupNo=".$menu["groupNo"].""; 
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
	
	function updateMenuItem($access_token,$menuItem){
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
					$sql="select * from menuwidget where widgetID='".$menuItem["widgetID"]."'";
					$rsWidget=mysqli_query($conn,$sql);
					$rcWidget=mysqli_fetch_assoc($rsWidget);
					$colSpan=$rcWidget['colSpan'];
					$sColumnNumber=$menuItem["columnNumber"];
					if($colSpan>=3){
						$columnNumber=0;
						}else if($colSpan<=2&&($sColumnNumber==0||$sColumnNumber==1)){
						$columnNumber=$sColumnNumber;
						}else{
						$columnNumber=0;
					}
					
					if(array_key_exists('foodID',$menuItem)){
						$sql="update menugroupitem set color='".$menuItem["color"]."',restID='".$menuItem["restID"]."',groupNo=".$menuItem["groupNo"].",foodID='".$menuItem["foodID"]."',widgetID='".$menuItem["widgetID"]."',rowNumber=".$menuItem["rowNumber"].",columnNumber=$columnNumber where itemNo='".$menuItem["itemNo"]."'"; 
						}else if(array_key_exists('setID',$menuItem)){
						$sql="update menugroupitem set color='".$menuItem["color"]."',restID='".$menuItem["restID"]."',groupNo=".$menuItem["groupNo"].",setID='".$menuItem["setID"]."',widgetID='".$menuItem["widgetID"]."',rowNumber=".$menuItem["rowNumber"].",columnNumber=$columnNumber where itemNo='".$menuItem["itemNo"]."'"; 
					}
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
	
	function deleteMenuItem($access_token,$itemNo,$restID,$groupNo){
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
					$sql="delete from menugroupitem where itemNo='$itemNo' and restID='$restID' and groupNo=$groupNo"; 
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
	
	function deleteMenu($access_token,$restID,$groupNo){
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
					$sql="delete from menugroupitem where restID='$restID' and groupNo=$groupNo"; 
					mysqli_query($conn,$sql);
					$sql="delete from menugroup where restID='$restID' and groupNo=$groupNo"; 
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