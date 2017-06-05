<?php
	function getMenu($restID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from menugroup where restID='$restID'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$openHour=$rc['openHour']*60*60;
				$startTime=date("H:i:s",strtotime($rc['startTime']));
				$endTime=date("H:i:s",strtotime($rc['startTime'])+$openHour);
				date_default_timezone_set("Asia/Hong_Kong");
				$currentTime=date("H:i:s");
				if(($currentTime>$startTime&&$currentTime<$endTime)||($startTime==$endTime)){
					$showDay=explode(',',$rc['showDay']);
					$today=date("w",time());
					for($i=0;$i<count($showDay);$i++){
						if($showDay[$i]==$today){
							array_push($msg,array('restID'=>$rc['restID'],'groupNo'=>$rc['groupNo'],'groupChiName'=>$rc['groupChiName'],'groupEngName'=>$rc['groupEngName']));
							break;
						}
					}
				}
			}
		}
		$final=array('RestaurantMenu'=>$msg);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getMenuItem($restID,$menuID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from menugroupitem where restID='$restID' and groupNo=$menuID order by rowNumber,columnNumber";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$food=null;
				$set=null;
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
	}
?>