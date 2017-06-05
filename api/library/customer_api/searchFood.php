<?php
	function searchFood($keywords){
		require_once("../library/connections/conn.php");
		
		$sql="select * from food,restaurant,restcompany,region where restaurant.rgID=region.rgID and restcompany.companyID=restaurant.companyID and food.restID=restaurant.restID and (foodChiName like '%$keywords%' or foodEngName like '%$keywords%') and restaurant.locked=0 and restcompany.locked=0 order by food.foodEngName asc";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$foodMsg=null;
		if(mysqli_num_rows($rs)>0){
			$foodMsg=array();
			
			$sql="select * from charge where restID='".$rc['restID']."'";
			$rsCharge=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$Fcharge=null;
			if(mysqli_num_rows($rsFood)>0){
				$Fcharge=array();
				while($rcCharge=mysqli_fetch_assoc($rsCharge)){
					$charge=array('chargeID'=>$rcCharge['chargeID'],'charge'=>$rcCharge['charge'],'dayNo'=>$rcCharge['dayNo'],'detail'=>$rcCharge['detail']);
					array_push($Fcharge,$charge);
					}
			}
			$food=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
			'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'deliveryPrice'=>$rc['deliveryPrice'],
			'food'=>array('foodID'=>$rc['foodID'],'foodChiName'=>$rc['foodChiName'],'foodEngName'=>$rc['foodEngName'],'foodPrice'=>$rc['foodPrice'],'foodPhoto'=>$rc['foodPhoto'],'foodDesc'=>$rc['foodDesc'],'foodDescEng'=>$rc['foodDescEng'],'foodTakeout'=>$rc['foodTakeout'],'available'=>$rc['available'],
			'charge'=>$Fcharge))
			);
			array_push($foodMsg,$food);
		}
		
		$sql="select * from setitem,restaurant,restcompany where restcompany.companyID=restaurant.companyID and setitem.restID=restaurant.restID and (setChiName like '%$keywords%' or setEngName like '%$keywords%') and restaurant.locked=0 and restcompany.locked=0 order by setItem.setEngName asc";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$setMsg=null;
		if(mysqli_num_rows($rs)>0){
			$setMsg=array();
			
			while($rc=mysqli_fetch_assoc($rs)){				
				//setFood
				$sql="select * from food where foodID in (select foodID from setFood where setID='".$rc['setID']."')";
				$rsSetFood=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$FsetFood=array();
				while($rcSetFood=mysqli_fetch_assoc($rsSetFood)){
					$sql="select * from settitle where titleNo in (select titleNo from setFood where setID='".$rc['setID']."')";
					$rsSetTitle=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$rcSetTitle=mysqli_fetch_assoc($rsSetTitle);
					
					$sql="select * from setfood where setID='".$rc['setID']."'";
					$rsSetPrice=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$rcSetPrice=mysqli_fetch_assoc($rsSetPrice);
					
					$setFood=array('foodID'=>$rcSetFood['foodID'],'restID'=>$rcSetFood['restID'],'groupNo'=>$rcSetFood['groupNo'],'foodChiName'=>$rcSetFood['foodChiName'],'foodEngName'=>$rcSetFood['foodEngName'],'foodPrice'=>$rcSetFood['foodPrice'],'foodPhoto'=>$rcSetFood['foodPhoto'],'foodDesc'=>$rcSetFood['foodDesc'],'foodDescEng'=>$rcSetFood['foodDescEng'],'foodTakeout'=>$rcSetFood['foodTakeout'],'available'=>$rcSetFood['available'],
					'titleName'=>$rcSetTitle['titleName'],'extraPrice'=>$rcSetPrice['extraPrice'],'foodNo'=>$rcSetPrice['foodNo']);
					array_push($FsetFood,$setFood);
				}
				//chargeFood
				$sql="select * from charge where restID='".$rc['restID']."'";
				$rsCharge=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$Fcharge=null;
				if(mysqli_num_rows($rsCharge)>0){
					$Fcharge=array();
					while($rcCharge=mysqli_fetch_assoc($rsCharge)){
						$charge=array('chargeID'=>$rcCharge['chargeID'],'charge'=>$rcCharge['charge'],'dayNo'=>$rcCharge['dayNo'],'detail'=>$rcCharge['detail']);
						array_push($Fcharge,$charge);
					}
				}
				$setItem=array('companyID'=>$rc['companyID'],'companyChiName'=>$rc['companyChiName'],'companyEngName'=>$rc['companyEngName'],'companyEmail'=>$rc['companyEmail'],
				'restaurant'=>array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'restPhoto'=>$rc['restPhoto'],'rgChiName'=>$rc['rgChiName'],'rgEngName'=>$rc['rgEngName'],'deliveryPrice'=>$rc['deliveryPrice'],
				'setItem'=>array('setID'=>$rc['setID'],'setChiName'=>$rc['setChiName'],'setEngName'=>$rc['setEngName'],'totalPrice'=>$rc['totalPrice'],'setPhoto'=>$rc['setPhoto'],'setDesc'=>$rc['setDesc'],'setDescEng'=>$rc['setDescEng'],'setTakeout'=>$rc['setTakeout'],'available'=>$rc['available'],
				'setFood'=>$FsetFood,'charge'=>$Fcharge))
				);
				array_push($setMsg,$setItem);
			}
		}
		$final=array('Food'=>$foodMsg,'Set'=>$setMsg);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
?>						