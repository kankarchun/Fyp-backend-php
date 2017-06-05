<?php
	function getSpecialOption($optID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from specialoption where optID='$optID'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$msg=null;
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_num_rows($rs);
			$msg=array('optID'=>$rc['optID'],'contentChi'=>$rc['contentChi'],'contentEng'=>$rc['contentEng'],'extraPrice'=>$rc['extraPrice']);
		}
		$final=array('SpecialOption'=>$msg);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getOrder($custID){
		require_once("../library/connections/conn.php");
		
		$sql="select * from invoice where custID='$custID' order by orderDateTime desc";
		
		$rsInvoice=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$Fmsg=null;
		if(mysqli_num_rows($rsInvoice)>0){
			$Fmsg=array();
			while($rcInvoice=mysqli_fetch_assoc($rsInvoice)){
				$invoiceID=$rcInvoice['invoiceID'];
				$custID=$rcInvoice['custID'];
				
				$sql="select * from restaurant where restID='".$rcInvoice['restID']."' and locked=0";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$rc=mysqli_fetch_assoc($rs);
				
				$restaurant=array('restID'=>$rc['restID'],'restChiName'=>$rc['restChiName'],'restEngName'=>$rc['restEngName'],'restAddress'=>$rc['restAddress'],'restAddressEng'=>$rc['restAddressEng'],'restTel'=>$rc['restTel'],'restEmail'=>$rc['restEmail'],'restPhoto'=>$rc['restPhoto'],'restDesc'=>$rc['restDesc'],'restDescEng'=>$rc['restDescEng'],'deliveryPrice'=>$rc['deliveryPrice']);
				
				$sql="select * from customer where custID='$custID' and locked=0";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$rc=mysqli_fetch_assoc($rs);
				
				$customer=array('custID'=>$rc['custID'],'custName'=>$rc['custName'],'custTel'=>$rc['custTel']);
				
				$sql="select * from takeout where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$takeout=null;
				if(mysqli_num_rows($rs)>0){
					$rc=mysqli_fetch_assoc($rs);
					$takeout=array('takeoutID'=>$rc['takeoutID'],'takeoutNo'=>$rc['takeoutNo'],'address'=>$rc['address']);
				}
				
				$table=null;
				if($rcInvoice['tableID']!=null){
					$sql="select * from resttable where tableID='".$rcInvoice['tableID']."'";
					$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$table=array('tableID'=>$rc['tableID'],'tableNo'=>$rc['tableNo']);
					}
				}
				
				$sql="select * from invoicecharge where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$charge=array();
				while($rc=mysqli_fetch_assoc($rs)){
					array_push($charge,array('iChargeNo'=>$rc['iChargeNo'],'detailChi'=>$rc['detailChi'],'detailEng'=>$rc['detailEng'],'charge'=>$rc['charge'])
					);
				}
				
				$sql="select * from orderfood where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$ForderFood=array();
				while($rc=mysqli_fetch_assoc($rs)){
					
					
					$sql="select * from orderoption where orderNo='".$rc['orderNo']."' and invoiceID='$invoiceID'";
					$rsOpt=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$FOpt=array();
					while($rcOpt=mysqli_fetch_assoc($rsOpt)){
						$sql="select * from specialoption where optID='".$rcOpt['optID']."'";
						$rsSpe=mysqli_query($conn,$sql) or die(mysqli_error($conn));
						$rcSpe=mysqli_fetch_assoc($rsSpe);
						
						array_push($FOpt,array('optID'=>$rcSpe['optID'],'contentChi'=>$rcSpe['contentChi'],'contentEng'=>$rcSpe['contentEng'],'extraPrice'=>$rcSpe['extraPrice']));
					}
					$data=array('orderNo'=>$rc['orderNo'],'foodChiName'=>$rc['foodChiName'],'foodEngName'=>$rc['foodEngName'],'foodPrice'=>$rc['foodPrice'],'quantity'=>$rc['quantity'],'foodSubPrice'=>$rc['foodSubPrice'],
					'specialOption'=>$FOpt); 
					array_push($ForderFood,$data);
				}
				
				$sql="select * from setorder where invoiceID='$invoiceID'";
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$setOrder=array();
				while($rc=mysqli_fetch_assoc($rs)){
					$sql="select * from setorderchoice where setOrderNo='".$rc['setOrderNo']."' and invoiceID='$invoiceID'";
					$rsCho=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					$FsetOrder=array();
					while($rcCho=mysqli_fetch_assoc($rsCho)){						
						$sql="select * from choiceoption where setOrderChoiceNo='".$rcCho['setOrderChoiceNo']."' and setOrderNo='".$rcCho['setOrderNo']."' and invoiceID='$invoiceID'";
						$rsChoOpt=mysqli_query($conn,$sql) or die(mysqli_error($conn));
						$FsetOpt=array();
						while($rcChoOpt=mysqli_fetch_assoc($rsChoOpt)){
							$sql="select * from specialoption where optID='".$rcChoOpt['optID']."'";
							$rsSpeOpt=mysqli_query($conn,$sql) or die(mysqli_error($conn));
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
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	//invoice(custID) -> restaurant(restid) -> customer(custID)
	//takeout
	//invoiceCharge
	//order->orderOption(orderNo,invoiceID)->specialOption(optID)
	//setOrder->setOrderChoice(invoiceID,setOrderNo)->specialOption(optID)
	//												->ChoiceOption(setOrderChoiceNo,setOrderNo,invoiceID)->specialOption(optID)
?>
