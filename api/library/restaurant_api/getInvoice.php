<?php
	function getInvoice($access_token,$restID){
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
				
				$sql="select * from invoice where restID='$restID'";
				
				$rsInvoice=mysqli_query($conn,$sql);
				$Fmsg=array();
				if(mysqli_num_rows($rsInvoice)>0){
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
						$takeout=array();
						if(mysqli_num_rows($rs)>0){
							$rc=mysqli_fetch_assoc($rs);
							$takeout=array('takeoutID'=>$rc['takeoutID'],'takeoutNo'=>$rc['takeoutNo'],'address'=>$rc['address']);
						}
						
						$table=array();
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
				$final=array('result'=>200,'message'=>"Success",'data'=>$final);
				mysqli_close($conn);
				echo json_encode($final, JSON_UNESCAPED_UNICODE);
			}
			else{
				$msg=array('result'=>401,'message'=>"access_denied",'data'=>array());
				echo json_encode($msg);
				
			}
		}
		
		
	}
?>						