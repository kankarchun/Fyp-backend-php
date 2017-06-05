<?php
	function checkImei($conn,$imei){		
		$sql="select * from customer where custDevice='".password_hash($imei, PASSWORD_BCRYPT)."'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$msg=true;
			}else{
			$msg=false;
		}
		
		return $msg;
	}
	
	function checkPhone($conn,$phoneNo){
		$sql="select * from customer where custTel='$phoneNo'";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$msg=true;
			}else{
			$msg=false;
		}
		return $msg;
	}
	
	function sendSMS($phoneNo,$oldPhone,$sms){
		require_once("../library/connections/conn.php");
		
		if(checkPhone($conn,$phoneNo)){
			$msg=array('result'=>500,'message'=>'registered','data'=>array()); //front-end go to login.php
			}else{
			$verifyCode=rand(1000,9999);
			if($sms===true){
				$content="[ GRO Platfrom ] Vertifcation Code: $verifyCode";
				$url="https://api.xn--h9h.ws/sms/?phone=".$phoneNo."&content=".urlencode($content);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$html = curl_exec($ch);
				curl_close($ch);
				}else{
				
				$number='+852'.$phoneNo;
				//generate sms code back to phone
				require('../library/customer_api/twilio-php-master/Twilio/autoload.php');
				$sid = 'ACbfb605b297f9b083b37ca85b5c8fde18';
				$token = '519c71cba74b7423f69dfcaa2e105e90';
				$client = new Twilio\Rest\Client($sid, $token);
				$client->messages->create(
				// the number you'd like to send the message to
				$number,
				array(
				// A Twilio phone number you purchased at twilio.com/console
				'from' => '+12568263030',
				// the body of the text message you'd like to send
				'body' => $verifyCode
				)
				);
			}
			$sql="delete from sms where phone='$phoneNo'";
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			$sql="insert into sms(phone,verifyCode,oldPhone) values ('$phoneNo','$verifyCode','$oldPhone')";
			mysqli_query($conn,$sql) or die(mysqli_error($conn));
			if(mysqli_affected_rows($conn)>0){
				$msg=array('result'=>200,'message'=>"success",'data'=>array('code'=>$verifyCode));
			}
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	//change phone
	function verifySMS($phoneNo,$imei,$smsCode){
		require_once("../library/connections/conn.php");
		
		$sql="select * from sms where verifyCode='$smsCode' order by id desc limit 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			
			$msg=updateCust($conn,$phoneNo,$imei,$rc['oldPhone']);
			}else{
			$data=array();
			$data['error']='wrong_number';
			$msg=array('result'=>500,'message'=>'no this phone number','data'=>$data);
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function updateCust($conn,$phoneNo,$imei,$oldPhone){
		require_once("../library/connections/conn.php");
		
		$sql="delete from sms where phone='$phoneNo'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$sql="update customer set custDevice='".password_hash($imei, PASSWORD_BCRYPT)."',custTel='$phoneNo' where custTel='$oldPhone'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array());
			}else{
			$msg=array('result'=>500,'message'=>'Failed','data'=>array());
		}
		return $msg;
	}
	
	//change device,same phone
	function changeDevice($custID){
		require_once("../library/connections/conn.php");
		
		$verifyCode=rand(1000,9999);
		
		$sql="delete from sms where phone='$phoneNo'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$sql="insert into sms(phone,verifyCode) values ('$custID','$verifyCode')";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"success",'data'=>array('code'=>$verifyCode));
		}else{
			$msg=array('result'=>500,'message'=>"fail",'data'=>array());
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function verifyDevice($imei,$smsCode){
		require_once("../library/connections/conn.php");
		
		$sql="select * from sms where verifyCode='$smsCode' order by id desc limit 1";
		$rs=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if(mysqli_num_rows($rs)>0){
			$rc=mysqli_fetch_assoc($rs);
			$msg=updateDevice($conn,$imei,$rc['phone']);
			}else{
			$data=array();
			$data['error']='wrong_code';
			$msg=array('result'=>500,'message'=>'Please input again','data'=>$data);
		}
		mysqli_close($conn);
		echo json_encode($msg);
	}
	
	function updateDevice($conn,$imei,$phoneNo){
		require_once("../library/connections/conn.php");
		
		$sql="delete from sms where phone='$phoneNo'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$sql="update customer set custDevice='".password_hash($imei, PASSWORD_BCRYPT)."' where custID='$phoneNo'";
		mysqli_query($conn,$sql) or die(mysqli_error($conn));
		
		$sql="select * from customer where custID='$phoneNo' ORDER BY custID DESC LIMIT 1";
		$rs=mysqli_query($conn,$sql);
		$rc=mysqli_fetch_assoc($rs);
		if(mysqli_affected_rows($conn)>0){
			$msg=array('result'=>200,'message'=>"Success",'data'=>array('phoneNo'=>$rc['custTel']));
			}else{
			$msg=array('result'=>500,'message'=>'Failed','data'=>array());
		}
		return $msg;
	}
?>