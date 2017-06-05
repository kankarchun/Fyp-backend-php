<?php
	function isFavouriteRest($custID,$restID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from favourite where custID='$custID' and restID='$restID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		
		if(mysqli_num_rows($rs)>0){
			$msg=array('isFavourite'=>true);
			}else{
			$msg=array('isFavourite'=>false);
		}
		$final=array('result'=>200,'message'=>"success",'data'=>$msg);
		mysqli_close($conn);
		echo json_encode($final);
	}
	
	function isFavouriteFood($custID,$foodID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from favouritefood where custID='$custID' and foodID='$foodID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array('isFavourite'=>true);
			}else{
			$msg=array('isFavourite'=>false);
		}
		$final=array('result'=>200,'message'=>"success",'data'=>$msg);
		mysqli_close($conn);
		echo json_encode($final);
	}
	
	function isFavouriteSet($custID,$setID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from favouriteset where custID='$custID' and setID='$setID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array('isFavourite'=>true);
			}else{
			$msg=array('isFavourite'=>false);
		}
		$final=array('result'=>200,'message'=>"success",'data'=>$msg);
		mysqli_close($conn);
		echo json_encode($final);
	}
	
	function getRest($custID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from favourite where custID='$custID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$msg=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$sql="select * from restcompany,restaurant,region where region.rgid=restaurant.rgid and restcompany.companyID=restaurant.companyID and restaurant.restID='".$rc['restID']."' and restaurant.locked=0 and restcompany.locked=0";
				$rsRest=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$rcRest=mysqli_fetch_assoc($rsRest);
				
				array_push($msg,array('companyID'=>$rcRest['companyID'],'companyChiName'=>$rcRest['companyChiName'],'companyEngName'=>$rcRest['companyEngName'],'companyEmail'=>$rcRest['companyEmail'],
				'restaurant'=>array('restID'=>$rcRest['restID'],'restChiName'=>$rcRest['restChiName'],'restEngName'=>$rcRest['restEngName'],'restAddress'=>$rcRest['restAddress'],'restAddressEng'=>$rcRest['restAddressEng'],'restTel'=>$rcRest['restTel'],'restEmail'=>$rcRest['restEmail'],'restDesc'=>$rcRest['restDesc'],'restDescEng'=>$rcRest['restDescEng'],'restPhoto'=>$rcRest['restPhoto'],'rgChiName'=>$rcRest['rgChiName'],'rgEngName'=>$rcRest['rgEngName'],'deliveryPrice'=>$rcRest['deliveryPrice'])
				)
				);
			}
		}
		$final=array('RestaurantFavourite'=>$msg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getFood($custID,$restID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from restaurant,favouritefood,restcompany,menugroup,menugroupitem where menugroup.groupNo=menugroupitem.groupNo and menugroup.restID=menugroupitem.restID and menugroupitem.foodID=favouritefood.foodID and restcompany.companyID=restaurant.companyID and restaurant.restID=favouritefood.restID and favouritefood.custID='$custID' and favouritefood.restID='$restID' and restaurant.locked=0 and restcompany.locked=0";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$foodMsg=null;
		if(mysqli_num_rows($rs)>0){
			
			$foodMsg=array();
			
			while($rc=mysqli_fetch_assoc($rs)){
				$openHour=$rc['openHour']*60*60;
				$startTime=date("H:i:s",strtotime($rc['startTime']));
				$endTime=date("H:i:s",strtotime($rc['startTime'])+$openHour);
				date_default_timezone_set("Asia/Hong_Kong");
				$currentTime=date("H:i:s");
				$available=1;
				if(($currentTime>$startTime&&$currentTime<$endTime)||($startTime==$endTime)){
					$showDay=explode(',',$rc['showDay']);
					$today=date("w",time());
					for($i=0;$i<count($showDay);$i++){
						if($showDay[$i]==$today){
							$available=0;
							break;
						}
					}
					}else{
					$available=1;
				}
				$sql="select * from food,menugroupitem where menugroupitem.foodID=food.foodID and available=0 and food.foodID='".$rc['foodID']."' and food.restID='".$rc['restID']."'";
				$rsFood=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$rcFood=mysqli_fetch_assoc($rsFood);
				
				$sql="select * from favouriteorderoption where ffID='".$rc['ffID']."'";
				$rsOpt=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$foOpt=array();
				while($rcOpt=mysqli_fetch_assoc($rsOpt)){
					$sql="select * from specialoption where optID='".$rcOpt['optID']."'";
					$rsSpe=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$rcSpe=mysqli_fetch_assoc($rsSpe);
					$option=array('optID'=>$rcSpe['optID'],'contentChi'=>$rcSpe['contentChi'],'contentEng'=>$rcSpe['contentEng'],'extraPrice'=>$rcSpe['extraPrice']);
					array_push($foOpt,$option);
				}
				$food=array('foodID'=>$rcFood['foodID'],'restID'=>$rcFood['restID'],'groupNo'=>$rcFood['groupNo'],'foodChiName'=>$rcFood['foodChiName'],'foodEngName'=>$rcFood['foodEngName'],'foodPrice'=>$rcFood['foodPrice'],'foodPhoto'=>$rcFood['foodPhoto'],'foodDesc'=>$rcFood['foodDesc'],'foodDescEng'=>$rcFood['foodDescEng'],'foodTakeout'=>$rcFood['foodTakeout'],'available'=>$available,
				'favouriteOrderOption'=>$foOpt);
				array_push($foodMsg,$food);
			}
		}
		
		$sql="select * from restaurant,favouriteset,restcompany,menugroup,menugroupitem where menugroup.groupNo=menugroupitem.groupNo and menugroup.restID=menugroupitem.restID and menugroupitem.setID=favouriteset.setID and restcompany.companyID=restaurant.companyID and restaurant.restID=favouriteset.restID and custID='$custID' and favouriteset.restID='$restID' and restaurant.locked=0 and restcompany.locked=0";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$setMsg=null;
		if(mysqli_num_rows($rs)>0){
			$setMsg=array();
			$set=null;
			while($rc=mysqli_fetch_assoc($rs)){
				$openHour=$rc['openHour']*60*60;
				$startTime=date("H:i:s",strtotime($rc['startTime']));
				$endTime=date("H:i:s",strtotime($rc['startTime'])+$openHour);
				date_default_timezone_set("Asia/Hong_Kong");
				$currentTime=date("H:i:s");
				$available=1;
				if(($currentTime>$startTime&&$currentTime<$endTime)||($startTime==$endTime)){
					$showDay=explode(',',$rc['showDay']);
					$today=date("w",time());
					for($i=0;$i<count($showDay);$i++){
						if($showDay[$i]==$today){
							$available=0;
							break;
						}
					}
					}else{
					$available=1;
				}
				$sql="select * from setitem,menugroupitem where menugroupitem.setID=setitem.setID and available=0 and setitem.setID='".$rc['setID']."' and setitem.restID='".$rc['restID']."'";
				$rsSet=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$rcSet=mysqli_fetch_assoc($rsSet);
				
				$sql="select * from settitle where setID='".$rc['setID']."'";
				$rsSetTitle=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$FsetTitle=array();
				while($rcSetTitle=mysqli_fetch_assoc($rsSetTitle)){
					
					$sql="select * from favouritesetchoice where fsID='".$rc['fsID']."' and custID='$custID'";
					$rsCho=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$FsetFood=array();
					$setFood=null;
					$FotherSetFood=array();
					$otherSetFood=null;
					if(mysqli_num_rows($rsCho)>0){
						while($rcCho=mysqli_fetch_assoc($rsCho)){
							$sql="select * from food,setfood,menugroupitem where menugroupitem.foodID=food.foodID and available=0 and food.foodID=setfood.foodID and setfood.titleNo='".$rcSetTitle['titleNo']."'";
							$rsSetFood=mysqli_query($conn,$sql) or die(mysqli_error($conn));
							if(mysqli_num_rows($rsSetFood)>0){
								$rcSetFood=mysqli_fetch_assoc($rsSetFood);					
								if($rcSetFood['foodNo']==$rcCho['foodNo']){
									$sql="select * from favouritechoiceoption where fscID='".$rcCho['fscID']."'";
									$rsChoOpt=mysqli_query($conn,$sql) or die(mysqli_error($conn));
									$fcoOpt=array();
									while($rcChoOpt=mysqli_fetch_assoc($rsChoOpt)){
										$sql="select * from specialoption where optID='".$rcChoOpt['optID']."'";
										$rsSpe=mysqli_query($conn,$sql) or die(mysqli_error($conn));
										$rcSpe=mysqli_fetch_assoc($rsSpe);
										$option=array('optID'=>$rcSpe['optID'],'contentChi'=>$rcSpe['contentChi'],'contentEng'=>$rcSpe['contentEng'],'extraPrice'=>$rcSpe['extraPrice']);
										array_push($fcoOpt,$option);
									}
									$setFood=array('foodID'=>$rcSetFood['foodID'],'foodNo'=>$rcSetFood['foodNo'],'restID'=>$rcSetFood['restID'],'groupNo'=>$rcSetFood['groupNo'],'foodChiName'=>$rcSetFood['foodChiName'],'foodEngName'=>$rcSetFood['foodEngName'],'foodPrice'=>$rcSetFood['foodPrice'],'foodPhoto'=>$rcSetFood['foodPhoto'],'foodDesc'=>$rcSetFood['foodDesc'],'foodDescEng'=>$rcSetFood['foodDescEng'],'foodTakeout'=>$rcSetFood['foodTakeout'],
									'favouriteChoiceOption'=>$fcoOpt,'extraPrice'=>$rcSetFood['extraPrice'],'quantity'=>$rcCho['quantity']);
									array_push($FsetFood,$setFood);
									}else{
									while($rcSetFood=mysqli_fetch_assoc($rsSetFood)){
										$otherSetFood=array('foodID'=>$rcSetFood['foodID'],'foodNo'=>$rcSetFood['foodNo'],'restID'=>$rcSetFood['restID'],'groupNo'=>$rcSetFood['groupNo'],'foodChiName'=>$rcSetFood['foodChiName'],'foodEngName'=>$rcSetFood['foodEngName'],'foodPrice'=>$rcSetFood['foodPrice'],'foodPhoto'=>$rcSetFood['foodPhoto'],'foodDesc'=>$rcSetFood['foodDesc'],'foodDescEng'=>$rcSetFood['foodDescEng'],'foodTakeout'=>$rcSetFood['foodTakeout'],
										'extraPrice'=>$rcSetFood['extraPrice'],'quantity'=>0);
										array_push($FotherSetFood,$otherSetFood);
									}
								}
							}
						}
						}else{
						$sql="select * from food,setfood,menugroupitem where menugroupitem.foodID=food.foodID and available=0 and food.foodID=setfood.foodID and setfood.setID='".$rc['setID']."' and setfood.titleNo='".$rcSetTitle['titleNo']."'";
						$rsSetFood=mysqli_query($conn,$sql) or die(mysqli_error($conn));
						while($rcSetFood=mysqli_fetch_assoc($rsSetFood)){
							$otherSetFood=array('foodID'=>$rcSetFood['foodID'],'foodNo'=>$rcSetFood['foodNo'],'restID'=>$rcSetFood['restID'],'groupNo'=>$rcSetFood['groupNo'],'foodChiName'=>$rcSetFood['foodChiName'],'foodEngName'=>$rcSetFood['foodEngName'],'foodPrice'=>$rcSetFood['foodPrice'],'foodPhoto'=>$rcSetFood['foodPhoto'],'foodDesc'=>$rcSetFood['foodDesc'],'foodDescEng'=>$rcSetFood['foodDescEng'],'foodTakeout'=>$rcSetFood['foodTakeout'],
							'extraPrice'=>$rcSetFood['extraPrice'],'quantity'=>0);
							array_push($FotherSetFood,$otherSetFood);
						}
					}
					
					$setTitle=array('title'=>$rcSetTitle['title'],'titleEng'=>$rcSetTitle['titleEng'],'count'=>$rcSetTitle['count'],
					'setFood'=>$FsetFood,'otherSetFood'=>$FotherSetFood);
					array_push($FsetTitle,$setTitle);
				}
				$set=array('setID'=>$rcSet['setID'],'restID'=>$rcSet['restID'],'groupNo'=>$rcSet['groupNo'],'setChiName'=>$rcSet['setChiName'],'setEngName'=>$rcSet['setEngName'],'totalPrice'=>$rcSet['totalPrice'],'setPhoto'=>$rcSet['setPhoto'],'setDesc'=>$rcSet['setDesc'],'setDescEng'=>$rcSet['setDescEng'],'setTakeout'=>$rcSet['setTakeout'],'available'=>$available,
				'setTitle'=>$FsetTitle);
				array_push($setMsg,$set);
			}
		}
		$final=array('FoodFavourite'=>$foodMsg,'SetFavourite'=>$setMsg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	//favouriteFood(custID)->restaurant(restID)
	//						->food(foodID)
	//						->favoutireOrderOption(ffID,custID)->specialOption(optID)
	//favoutireSet(custID)->set(setID)
	//						->favouriteSetChoice(fsID,custID)->setFood(foodNo)
	//														->favoutireChoiceOption(fsID,custID,foodNo)->specialOption(optID)
?>								