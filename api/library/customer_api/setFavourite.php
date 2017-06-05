<?php
	function setRest($custID,$restID){
		require_once("../library/connections/conn.php");
		
		$sql="insert into favourite(custID,restID) values ('$custID','$restID')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function setFood($custID,$restID,$food){
		require_once("../library/connections/conn.php");
		
		$sql="select * from favourite where custID='$custID' and restID='$restID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)<=0){
			$sql="insert into favourite(custID,restID) values ('$custID','$restID')";
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_affected_rows($conn)<=0){
				$msg=array('result'=>404,'message'=>"error",'data'=>array());
				echo json_encode($msg);
				return;
			}
		}
		$sql="select ffID from favouritefood ORDER BY ffID DESC LIMIT 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$ffID="FF".str_pad(substr($rc['ffID'],2)+1,5,0,STR_PAD_LEFT);
			}else{
			$ffID="FF".str_pad(1,5,0,STR_PAD_LEFT);
		}
		$sql="insert into favouritefood(ffID,custID,restID,foodID) values ('$ffID','$custID','$restID','".$food["foodID"]."')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			if(array_key_exists('specialOption',$food)){
				foreach($food['specialOption'] as $foodSpecOpt){
					$sql="select fooNo from favouriteorderoption ORDER BY fooNo DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$fooNo="FOO".str_pad(substr($rc['fooNo'],3)+1,5,0,STR_PAD_LEFT);
						}else{
						$fooNo="FOO".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="insert into favouriteorderoption(fooNo,ffID,optID) values ('$fooNo','$ffID','".$foodSpecOpt["optID"]."')";
					mysqli_query($conn,$sql) or die(mysqli_error($conn));
					if(mysqli_affected_rows($conn)>0){
						$msg=array('result'=>200,'message'=>"Success",'data'=>array());
						}else{
						$msg=array('result'=>404,'message'=>"error",'data'=>array());
					}
				}
				}else{
				$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function setSet($custID,$restID,$set){
		require_once("../library/connections/conn.php");
		
		$sql="select * from favourite where custID='$custID' and restID='$restID'";
		
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)<=0){
			$sql="insert into favourite(custID,restID) values ('$custID','$restID')";
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_affected_rows($conn)<=0){
				$msg=array('result'=>404,'message'=>"error",'data'=>array());
				echo json_encode($msg);
				return;
			}
		}
		$sql="select fsID from favouriteset ORDER BY fsID DESC LIMIT 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$fsID="FS".str_pad(substr($rc['fsID'],2)+1,5,0,STR_PAD_LEFT);
			}else{
			$fsID="FS".str_pad(1,5,0,STR_PAD_LEFT);
		}
		$sql="insert into favouriteset(fsID,custID,restID,setID) values ('$fsID','$custID','$restID','".$set["setID"]."')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			if(array_key_exists('setChoice',$set)){
				foreach($set['setChoice'] as $setChoice){
					$sql="select fscID from favouritesetchoice ORDER BY fscID DESC LIMIT 1";
					$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
					if(mysqli_num_rows($rs)>0){
						$rc=mysqli_fetch_assoc($rs);
						$fscID="FSC".str_pad(substr($rc['fscID'],3)+1,5,0,STR_PAD_LEFT);
						}else{
						$fscID="FSC".str_pad(1,5,0,STR_PAD_LEFT);
					}
					$sql="insert into favouritesetchoice(fscID,fsID,custID,foodNo,quantity) values ('$fscID','$fsID','$custID',".$setChoice["foodNo"].",".$setChoice["quantity"].")";
					mysqli_query($conn,$sql) or die(mysqli_error($conn));
					if(mysqli_affected_rows($conn)>0){
						$msg=array('result'=>200,'message'=>"Success",'data'=>array());
						if(array_key_exists('specialOption',$setChoice)){
							foreach($setChoice['specialOption'] as $setChoiceSpecOpt){
								$sql="select fcoNo from favouritechoiceoption ORDER BY fcoNo DESC LIMIT 1";
								$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
								if(mysqli_num_rows($rs)>0){
									$rc=mysqli_fetch_assoc($rs);
									$fcoNo=str_pad($rc['fcoNo']+1,5,0,STR_PAD_LEFT);
									}else{
									$fcoNo=str_pad(1,5,0,STR_PAD_LEFT);
								}
								$sql="insert into favouritechoiceoption(fcoNo,fscID,optID) values ($fcoNo,'$fscID','".$setChoiceSpecOpt["optID"]."')";
								mysqli_query($conn,$sql) or die(mysqli_error($conn));
								if(mysqli_affected_rows($conn)>0){
									$msg=array('result'=>200,'message'=>"Success",'data'=>array());
									}else{
									$msg=array('result'=>404,'message'=>"error",'data'=>array());
								}
							}
						}
						}else{
						$msg=array('result'=>404,'message'=>"error",'data'=>array());
					}
				}
			}
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
?>				