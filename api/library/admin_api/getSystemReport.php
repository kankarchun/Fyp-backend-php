<?php
	function getRestaurantRegister(){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$lastMonths=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$msg=array();
		$Ftotal=0;
		foreach($lastMonths as $month){
			$firstDayMonth = date("Y-m-01",strtotime("-$month month"));
			$lastDayMonth  = date("Y-m-t",strtotime("-$month month"));
			
			$sql="select * from restaurant where registeredDate between Date('$firstDayMonth') and Date('$lastDayMonth')";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$total=mysqli_num_rows($rs);
			$Ftotal+=$total;
			
			$fRest=array('total'=>$total);
			array_push($msg,$fRest);
		}
		$final=array('RestaurantReport'=>$msg,'total'=>$Ftotal);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	//customer
	function getCustomerRegister(){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$lastMonths=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$msg=array();
		$Ftotal=0;
		foreach($lastMonths as $month){
			$firstDayMonth = date("Y-m-01",strtotime("-$month month"));
			$lastDayMonth  = date("Y-m-t",strtotime("-$month month"));
			
			$sql="select * from customer where registeredDate between Date('$firstDayMonth') and Date('$lastDayMonth')";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$total=mysqli_num_rows($rs);
			$Ftotal+=$total;
			
			$fRest=array('total'=>$total);
			array_push($msg,$fRest);
		}
		$final=array('CustomerReport'=>$msg,'total'=>$Ftotal);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	//invoice
	function getFoodProfit($restID){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$lastYear = date("Y-m-d",strtotime("-1 year"));
		$currentYear  = date("Y-m-d");
		
		$sql="select SUM(quantity) as sum,foodEngName from orderfood,invoice where orderfood.invoiceID=invoice.invoiceID and orderDateTime between Date('$lastYear') and Date('$currentYear') and restID='$restID' group by foodEngName";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$ForderFood=null;
		$Ftotal=0;
		if(mysqli_num_rows($rs)>0){
			$ForderFood=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$orderFood=array('foodEngName'=>$rc['foodEngName'],'sum'=>$rc['sum']);
				$Ftotal+=$rc['sum'];
				array_push($ForderFood,$orderFood);
			}
		}
		$sql="select SUM(quantity) as sum,setEngName from setorder,invoice where setorder.invoiceID=invoice.invoiceID and orderDateTime between Date('$lastYear') and Date('$currentYear') and restID='$restID' group by setEngName";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$FsetOrder=null;
		if(mysqli_num_rows($rs)>0){
			$FsetOrder=array();
			while($rc=mysqli_fetch_assoc($rs)){
				$setOrder=array('setEngName'=>$rc['setEngName'],'sum'=>$rc['sum']);
				$Ftotal+=$rc['sum'];
				array_push($FsetOrder,$setOrder);
			}
		}
		
		$msg=array('orderFood'=>$ForderFood,'setOrder'=>$FsetOrder);
		$final=array('FoodReport'=>$msg,'total'=>$Ftotal);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	//invoice
	function getTimeOrder($restID){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$lastYear = date("Y-m-d",strtotime("-1 year"));
		$currentYear  = date("Y-m-d");
		$start=0;
		$end=0;
		$msg=array();
		$Ftotal=0;
		while($end<24){
			$start=$end;
			$end+=6;
			$sql="select Count(*) as count from orderfood,invoice where orderfood.invoiceID=invoice.invoiceID and orderDateTime between Date('$lastYear') and Date('$currentYear') and restID='$restID' and cast(orderDateTime as time) BETWEEN '$start:00' and '$end:00'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$orderFood=0;
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$orderFood=$rc['count'];
				$Ftotal+=$rc['count'];
			}
			$sql="select Count(*) as count from setorder,invoice where setorder.invoiceID=invoice.invoiceID and orderDateTime between Date('$lastYear') and Date('$currentYear') and restID='$restID' and cast(orderDateTime as time) BETWEEN '$start:00' and '$end:00'";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$setOrder=0;
			if(mysqli_num_rows($rs)>0){
				$rc=mysqli_fetch_assoc($rs);
				$setOrder=$rc['count'];
				$Ftotal+=$rc['count'];
			}
			$Fcount=array('time'=>"$start:00-$end:00","orderFood"=>$orderFood,'setOrder'=>$setOrder);
			array_push($msg,$Fcount);
		}
		$final=array('TimeReport'=>$msg,'total'=>$Ftotal);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	//invoice
	function getAllRestaurantProfit(){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$lastMonths=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$msg=array();
		$Ftotal=0;
		foreach($lastMonths as $month){
			$firstDayMonth = date("Y-m-01",strtotime("-$month month"));
			$lastDayMonth  = date("Y-m-t",strtotime("-$month month"));
			
			$sql="select * from invoice where orderDateTime between Date('$firstDayMonth') and Date('$lastDayMonth')";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$total=0;
			while($rc=mysqli_fetch_assoc($rs)){
				$total+=$rc['totalCost'];
			}
			$Ftotal+=$total;
			$fRest=array('total'=>$total);
			array_push($msg,$fRest);
		}
		$final=array('ProfitReport'=>$msg,'total'=>$Ftotal);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
	
	function getRestaurantProfit($restID){
		require_once("../library/connections/conn.php");
		
		date_default_timezone_set('Asia/Hong_Kong');
		$lastMonths=array(1,2,3,4,5,6,7,8,9,10,11,12);
		$msg=array();
		$Ftotal=0;
		foreach($lastMonths as $month){
			$firstDayMonth = date("Y-m-01",strtotime("-$month month"));
			$lastDayMonth  = date("Y-m-t",strtotime("-$month month"));
			
			$sql="select * from invoice where restID='$restID' and orderDateTime between Date('$firstDayMonth') and Date('$lastDayMonth')";
			$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$total=0;
			while($rc=mysqli_fetch_assoc($rs)){
				$total+=$rc['totalCost'];
			}
			$Ftotal+=$total;
			$fRest=array('total'=>$total);
			array_push($msg,$fRest);
		}
		$final=array('ProfitReport'=>$msg,'total'=>$Ftotal);
		$final=array('result'=>200,'message'=>"success",'data'=>$final);
		mysqli_close($conn);
		echo json_encode($final, JSON_UNESCAPED_UNICODE);
	}
?>									