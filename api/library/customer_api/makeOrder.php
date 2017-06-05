<?php
	function makeOrder($invoice,$charge,$food,$set){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$date = date('Y/m/d H:i:s', time());
		try{
			mysqli_autocommit($conn,FALSE);
			mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

			$sql="select invoiceID from invoice ORDER BY invoiceID DESC LIMIT 1";
			$rs=mysqli_query($conn,$sql);
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$invoiceID="I".str_pad(substr($rc['invoiceID'],1)+1,5,0,STR_PAD_LEFT);
				}else{
				$invoiceID="I".str_pad(1,5,0,STR_PAD_LEFT);
			}
			$sql="select takeoutID from takeout ORDER BY takeoutID DESC LIMIT 1";
			$rs=mysqli_query($conn,$sql);
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$takeoutID="T".str_pad(substr($rc['takeoutID'],1)+1,5,0,STR_PAD_LEFT);
				}else{
				$takeoutID="T".str_pad(1,5,0,STR_PAD_LEFT);
			}
			$sql=null;
			$data=null;
			$takeoutNo=null;
			//((food*quantity)+(set*quantity))*charge
			$totalCost=0;
			$foodTotalPrice=0;
			$setTotalPrice=0;
			
			if($invoice['tableID']!=null){
				$sql="select * from restaurant,resttable where restaurant.restID=resttable.restID and restaurant.restID='".$invoice["restID"]."' and resttable.tableID='".$invoice["tableID"]."'";
				}else{
				$sql="select * from restaurant where restID='".$invoice["restID"]."'";
			}
			$rs=mysqli_query($conn,$sql);
			if(mysqli_num_rows($rs)<=0){
				throw new Exception("no this restaurant");
				}else{
				$sql="select * from customer where custID='".$invoice["custID"]."'";
				$rs=mysqli_query($conn,$sql);
				if(mysqli_num_rows($rs)<=0){
					throw new Exception("no this customer");
				}
			}
			
			if($invoice['tableID']!=null){
				$sql="update resttable set tableLock=0 where tableID='".$invoice["tableID"]."'"; 
				mysqli_query($conn,$sql);
				$sql="insert into invoice(invoiceID,restID,custID,tableID,foodTotalCost,totalCost,orderDateTime) values ('$invoiceID','".$invoice["restID"]."','".$invoice["custID"]."','".$invoice["tableID"]."',0,0,'$date')";
				}else{
				$sql="insert into invoice(invoiceID,restID,custID,takeoutID,foodTotalCost,totalCost,orderDateTime) values ('$invoiceID','".$invoice["restID"]."','".$invoice["custID"]."','$takeoutID',0,0,'$date')";
			}
			mysqli_query($conn,$sql);
			if($invoice['tableID']==null){
				if($invoice['address']!=null){
					$sql="insert into takeout(takeoutID,address,invoiceID) values ('$takeoutID','".$invoice["address"]."','$invoiceID')";
					}else{
					$sql="select * from invoice where tableID is null and orderDateTime>CURDATE()";
					$rs=mysqli_query($conn,$sql);
					$takeoutNo=mysqli_num_rows($rs)+1;
					
					$sql="insert into takeout(takeoutID,takeoutNo,invoiceID) values ('$takeoutID',$takeoutNo,'$invoiceID')";
				}
				mysqli_query($conn,$sql);
			}
			if($food!=null){
				foreach($food as $foodItem){
					$specialOptionPrice=0;
					
					$sql="select orderNo from orderfood ORDER BY orderNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql)  ;
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$orderNo="OF".str_pad(substr($rc['orderNo'],2)+1,5,0,STR_PAD_LEFT);
						}else{
						$orderNo="OF".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="select * from food where foodID='".$foodItem["foodID"]."'";
					$rs=mysqli_query($conn,$sql)  ;
					$rc=mysqli_fetch_assoc($rs);
					if($rc['available']==1){
						throw new Exception($rc['foodChiName'].' not available');
					}
					
					$sql="insert into orderfood(orderNo,invoiceID,foodChiName,foodEngName,foodPrice,quantity,foodSubPrice) values ('$orderNo','$invoiceID','".$rc["foodChiName"]."','".$rc["foodEngName"]."','".$rc["foodPrice"]."',".$foodItem["quantity"].",0)";
					mysqli_query($conn,$sql)  ;
					if(array_key_exists('specialOption',$foodItem)){
						foreach($foodItem["specialOption"] as $foodSpecOpt){
							$sql="select * from specialoption where optID='".$foodSpecOpt["optID"]."'";
							$rsSpec=mysqli_query($conn,$sql);
							$rcSpec=mysqli_fetch_assoc($rsSpec);
							$specialOptionPrice+=$rcSpec["extraPrice"];
							
							$sql="insert into orderoption(optID,orderNo,invoiceID) values ('".$foodSpecOpt["optID"]."','$orderNo','$invoiceID')";
							mysqli_query($conn,$sql);
						}
					}
					$foodSubPrice=($rc["foodPrice"]+$specialOptionPrice)*$foodItem["quantity"];
					$sql="update orderfood set foodSubPrice=$foodSubPrice where orderNo='$orderNo'";
					mysqli_query($conn,$sql)  ;
					$foodTotalPrice+=$foodSubPrice;
				}
			}
			if($set!=null){
				foreach($set as $setItem){
					$setFoodPrice=0;
					
					$sql="select setOrderNo from setorder ORDER BY setOrderNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$setOrderNo=str_pad($rc['setOrderNo']+1,5,0,STR_PAD_LEFT);
						}else{
						$setOrderNo=str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="select * from setitem where setID='".$setItem["setID"]."'";
					$rs=mysqli_query($conn,$sql);
					$rc=mysqli_fetch_assoc($rs);
					if($rc['available']==1){
						throw new Exception($rc['setChiName'].' not available');
					}
					
					$sql="insert into setorder(setOrderNo,invoiceID,setChiName,setEngName,setPrice,quantity,setSubPrice) values ($setOrderNo,'$invoiceID','".$rc["setChiName"]."','".$rc["setEngName"]."',".$rc["totalPrice"].",".$setItem["quantity"].",0)";
					
					mysqli_query($conn,$sql);
					foreach($setItem["setOrderChoice"] as $setItemChoice){
						$specialOptionPrice=0;
						
						$sql="select setOrderChoiceNo from setorderchoice ORDER BY setOrderChoiceNo DESC LIMIT 1";
						$rs=mysqli_query($conn,$sql);
						if(mysqli_num_rows($rs)>0){
							$rcNum=mysqli_fetch_assoc($rs);
							$setOrderChoiceNo=str_pad($rcNum['setOrderChoiceNo']+1,5,0,STR_PAD_LEFT);
							}else{
							$setOrderChoiceNo=str_pad(1,5,0,STR_PAD_LEFT);
						}
						$sql="select * from setfood,food where setfood.foodID=food.foodID and foodNo='".$setItemChoice["foodNo"]."'";
						$rsSetFood=mysqli_query($conn,$sql);
						$rcSetFood=mysqli_fetch_assoc($rsSetFood);
						if($rcSetFood['available']==1){
							throw new Exception($rcSetFood['foodChiName'].' not available');
						}
						
						$sql="insert into setorderchoice(setOrderChoiceNo,setOrderNo,invoiceID,foodChiName,foodEngName,extraPrice,quantity,extraSubPrice) values ($setOrderChoiceNo,$setOrderNo,'$invoiceID','".$rcSetFood["foodChiName"]."','".$rcSetFood["foodEngName"]."',".$rcSetFood["extraPrice"].",".$setItemChoice["quantity"].",".$rcSetFood["extraPrice"]*$setItemChoice["quantity"].")";
						mysqli_query($conn,$sql);
						if(array_key_exists('specialOption',$setItemChoice)){
							foreach($setItemChoice["specialOption"] as $setItemChoiceSpecOpt){
								$sql="select * from specialoption where optID='".$setItemChoiceSpecOpt["optID"]."'";
								$rsSpec=mysqli_query($conn,$sql);
								$rcSpec=mysqli_fetch_assoc($rsSpec);
								$specialOptionPrice+=$rcSpec["extraPrice"];
								
								$sql="insert into choiceoption(optID,setOrderChoiceNo,setOrderNo,invoiceID) values ('".$setItemChoiceSpecOpt["optID"]."',$setOrderChoiceNo,$setOrderNo,'$invoiceID')";
								mysqli_query($conn,$sql);
							}
						}
						$setFoodPrice+=($rcSetFood["extraPrice"]+$specialOptionPrice)*$setItemChoice["quantity"];
					}
					$setSubPrice=($rc['totalPrice']+$setFoodPrice)*$setItem["quantity"];
					$sql="update setorder set setSubPrice=$setSubPrice where setOrderNo='$setOrderNo'";
					mysqli_query($conn,$sql) ;
					$setTotalPrice+=$setSubPrice;
				}
			}
			$foodTotalCost=$setTotalPrice+$foodTotalPrice;
			$totalCost=$foodTotalCost;
			if($invoice['tableID']==null&&$invoice['address']!=null){
				$sql="select * from restaurant where restID='".$invoice["restID"]."'";
				$rsCheck=mysqli_query($conn,$sql);
				$rcCheck=mysqli_fetch_assoc($rsCheck);
				if($foodTotalCost<$rcCheck['deliveryPrice']){
					$totalCost=$rcCheck['deliveryPrice'];
				}
			}
			
			if($charge!=null){
				foreach($charge as $invoiceCharge){
					$sql="select iChargeNo from invoicecharge ORDER BY iChargeNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$iChargeNo="IC".str_pad(substr($rc['iChargeNo'],2)+1,5,0,STR_PAD_LEFT);
						}else{
						$iChargeNo="IC".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="select * from charge where chargeID='".$invoiceCharge["chargeID"]."'";
					$rs=mysqli_query($conn,$sql);
					$rc=mysqli_fetch_assoc($rs);
					$sql="insert into invoicecharge(iChargeNo,invoiceID,detailChi,detailEng,charge) values ('$iChargeNo','$invoiceID','".$rc["detailChi"]."','".$rc["detailEng"]."','".$rc["charge"]."')";
					mysqli_query($conn,$sql);
					
					$symbol=substr($rc['charge'],0,1);
					$chargeCost=substr($rc['charge'],1);
					if($symbol=="+"){
						$totalCost+=$chargeCost;
					}
					else if($symbol=="-"){
						$totalCost*=$chargeCost;
					}
					else if($symbol=="*"){
						$totalCost*=$chargeCost;
					}
					else if($symbol=="/"){
						$totalCost/=$chargeCost;
					}
				}
			}
			$sql="update invoice set totalCost=$totalCost,foodTotalCost=$foodTotalCost where invoiceID='$invoiceID'";
			mysqli_query($conn,$sql) ;
			
			mysqli_commit($conn);
			$final=getInvoice($conn,$invoiceID);
			$msg=array('result'=>200,'message'=>"Success",'data'=>$final);
			mysqli_close($conn);
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			}catch(Exception $ex){
			mysqli_rollback($conn);
			$msg=array('result'=>500,'message'=>"fail",'data'=>$ex->getMessage());
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		}
	}
	
	function getInvoice($conn,$invoiceID){		
		$sql="select * from invoice where invoiceID='$invoiceID'";
		
		$rsInvoice=mysqli_query($conn,$sql);
		$Fmsg=null;
		if(mysqli_num_rows($rsInvoice)>0){
			$Fmsg=array();
			while($rcInvoice=mysqli_fetch_assoc($rsInvoice)){
				$invoiceID=$rcInvoice['invoiceID'];
				$custID=$rcInvoice['custID'];
				
				$sql="select * from restaurant where restID='".$rcInvoice['restID']."' and locked=0";
				$rs=mysqli_query($conn,$sql);
				$rc=mysqli_fetch_assoc($rs);
				
				$restaurant=array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restAddressEng'=>$rc['restAddressEng'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restPhoto'=>$rc['restPhoto'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'deliveryPrice'=>$rc['deliveryPrice']);
				
				$sql="select * from customer where custID='$custID' and locked=0";
				$rs=mysqli_query($conn,$sql);
				$rc=mysqli_fetch_assoc($rs);
				
				$customer=array('custID'=>$rc['custID'],'custName'=>$rc['custName'],'custTel'=>$rc['custTel']);
				
				$sql="select * from takeout where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql);
				$takeout=null;
				if(mysqli_num_rows($rs)>0){
					$rc=mysqli_fetch_assoc($rs);
					$takeout=array('takeoutID'=>$rc['takeoutID'],'takeoutNo'=>$rc['takeoutNo'],'address'=>$rc['address']);
				}
				
				$table=null;
				if($rcInvoice['tableID']!=null){
					$sql="select * from resttable where tableID='".$rcInvoice['tableID']."'";
					$rs=mysqli_query($conn,$sql);
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$table=array('tableID'=>$rc['tableID'],'tableNo'=>$rc['tableNo']);
					}
				}
				
				$sql="select * from invoicecharge where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql);
				$charge=array();
				while($rc=mysqli_fetch_assoc($rs)){
					array_push($charge,array('iChargeNo'=>$rc['iChargeNo'],'detailChi'=>$rc['detailChi'],'detailEng'=>$rc['detailEng'],'charge'=>$rc['charge'])
					);
				}
				
				$sql="select * from orderfood where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql);
				$ForderFood=array();
				while($rc=mysqli_fetch_assoc($rs)){
					
					
					$sql="select * from orderoption where orderNo='".$rc['orderNo']."' and invoiceID='$invoiceID'";
					$rsOpt=mysqli_query($conn,$sql);
					$FOpt=array();
					while($rcOpt=mysqli_fetch_assoc($rsOpt)){
						$sql="select * from specialoption where optID='".$rcOpt['optID']."'";
						$rsSpe=mysqli_query($conn,$sql);
						$rcSpe=mysqli_fetch_assoc($rsSpe);
						
						array_push($FOpt,array('optID'=>$rcSpe['optID'],'contentChi'=>$rcSpe['contentChi'],'contentEng'=>$rcSpe['contentEng'],'extraPrice'=>$rcSpe['extraPrice']));
					}
					$data=array('orderNo'=>$rc['orderNo'],'foodChiName'=>$rc['foodChiName'],'foodEngName'=>$rc['foodEngName'],'foodPrice'=>$rc['foodPrice'],'quantity'=>$rc['quantity'],'foodSubPrice'=>$rc['foodSubPrice'],
					'specialOption'=>$FOpt); 
					array_push($ForderFood,$data);
				}
				
				$sql="select * from setorder where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql);
				$setOrder=array();
				while($rc=mysqli_fetch_assoc($rs)){
					$sql="select * from setorderchoice where setOrderNo='".$rc['setOrderNo']."' and invoiceID='$invoiceID'";
					$rsCho=mysqli_query($conn,$sql);
					$FsetOrder=array();
					while($rcCho=mysqli_fetch_assoc($rsCho)){						
						$sql="select * from choiceoption where setOrderChoiceNo='".$rcCho['setOrderChoiceNo']."' and setOrderNo='".$rcCho['setOrderNo']."' and invoiceID='$invoiceID'";
						$rsChoOpt=mysqli_query($conn,$sql);
						$FsetOpt=array();
						while($rcChoOpt=mysqli_fetch_assoc($rsChoOpt)){
							$sql="select * from specialoption where optID='".$rcChoOpt['optID']."'";
							$rsSpeOpt=mysqli_query($conn,$sql);
							$rcSpeOpt=mysqli_fetch_assoc($rsSpeOpt);
							
							array_push($FsetOpt,array('optID'=>$rcSpeOpt['optID'],'contentChi'=>$rcSpeOpt['contentChi'],'contentEng'=>$rcSpeOpt['contentEng'],'extraPrice'=>$rcSpeOpt['extraPrice']));
						}
						
						$setChoice=array('setOrderChoiceNo'=>$rcCho['setOrderChoiceNo'],'foodChiName'=>$rcCho['foodChiName'],'foodEngName'=>$rcCho['foodEngName'],'extraPrice'=>$rcCho['extraPrice'],'quantity'=>$rcCho['quantity'],'extraSubPrice'=>$rcCho['extraSubPrice'],
						'ChoiceOption'=>$FsetOpt);
						array_push($FsetOrder,$setChoice);
					}
					
					$data=array('setOrderNo'=>$rc['setOrderNo'],'setChiName'=>$rc['setChiName'],'setEngName'=>$rc['setEngName'],'setPrice'=>$rc['setPrice'],'quantity'=>$rc['quantity'],'setSubPrice'=>$rc['setSubPrice'],
					'setOrderChoice'=>$FsetOrder); 
					array_push($setOrder,$data);
				}
				
				$invoice=array('invoiceID'=>$rcInvoice['invoiceID'],'restID'=>$rcInvoice['restID'],'custID'=>$rcInvoice['custID'],'table'=>$table,'takeout'=>$takeout,'totalCost'=>$rcInvoice['totalCost'],'orderDateTime'=>$rcInvoice['orderDateTime'],'foodTotalCost'=>$rcInvoice['foodTotalCost'],
				'restaurant'=>$restaurant,'customer'=>$customer,'charge'=>$charge,'orderFood'=>$ForderFood,'setOrder'=>$setOrder);
				array_push($Fmsg,$invoice);
			}
		}
		$final=array('invoice'=>$Fmsg);
		return $final;
	}
	
	//makeOrder(invoice,json(orders{food,set})) -> insert(invoice,InvoiceCharge,orderFood(orderOption(SpecialOption)),setOrder(setOrderChoice(SpecialOption)(ChoiceOption(SpecialOption)))) ->
?>
