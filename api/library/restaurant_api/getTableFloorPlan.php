<?php
	function getTableFloorPlan($access_token,$restID){
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
				$sql="select * from tablefloorplan where restID='$restID'";
				
				$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
				$msg=array();
				if(mysqli_num_rows($rs)>0){
					while($rc=mysqli_fetch_assoc($rs)){
						$sql="select * from resttable where floor='".$rc['floor']."' and restID='$restID'";
						$rsFloor=mysqli_query($conn,$sql) or die(mysqli_error($conn));
						$FFloor=array();
						if(mysqli_num_rows($rsFloor)>0){
							
							while($rcFloor=mysqli_fetch_assoc($rsFloor)){
								$table=array('tableID'=>$rcFloor['tableID'],'tableNo'=>$rcFloor['tableNo'],'posX'=>$rcFloor['posX'],'posY'=>$rcFloor['posY'],'maxNo'=>$rcFloor['maxNo'],'width'=>$rcFloor['width'],'height'=>$rcFloor['height'],'tableLock'=>$rcFloor['tableLock']);
								array_push($FFloor,$table);
							}
						}
						$floor=array('floor'=>$rc['floor'],'sizeX'=>$rc['sizeX'],'sizeY'=>$rc['sizeY'],'lastModify'=>$rc['lastModify'],
						'Table'=>$FFloor);
						array_push($msg,$floor);
					}
				}
				$final=array('TableFloorPlan'=>$msg);
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
?>						