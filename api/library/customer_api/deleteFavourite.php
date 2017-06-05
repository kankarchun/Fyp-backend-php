<?php
	function deleteRest($custID,$restID){
		require_once("../library/connections/conn.php");
		
		$sql="delete from favouriteorderoption where ffID in (select ffID from favouritefood where custID='$custID' and restID='$restID')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$sql="delete from favouritefood where custID='$custID' and restID='$restID'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$sql="delete from favouritechoiceoption where fscID in (select fscID from favouritesetchoice where fsID in (select fsID from favouriteset where custID='$custID' and restID='$restID'))";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$sql="delete from favouritesetchoice where fsID in (select fsID from favouriteset where custID='$custID' and restID='$restID')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$sql="delete from favouriteset where custID='$custID' and restID='$restID'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$sql="delete from favourite where custID='$custID' and restID='$restID'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function deleteFood($custID,$restID,$foodID){
		require_once("../library/connections/conn.php");
		
		$sql="delete from favouriteorderoption where ffID in (select ffID from favouritefood where foodID='$foodID')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$sql="delete from favouritefood where foodID='$foodID'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function deleteSet($custID,$restID,$setID){
		require_once("../library/connections/conn.php");
		
		$sql="delete from favouritechoiceoption where fscID in (select fscID from favouritesetchoice where fsID in (select fsID from favouriteset where setID='$setID'))";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$sql="delete from favouritesetchoice where fsID in (select fsID from favouriteset where setID='$setID')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$sql="delete from favouriteset where setID='$setID'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>404,'message'=>"error",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
		}
	?>					