<?php
	//echo password_hash("demo", PASSWORD_BCRYPT );
	$url='http://api.xn--h9h.ws/api/admin/trigger?action=get';
	//  Initiate curl
	$ch = curl_init();
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);
	
	printing($result);
	function printing($result){
		$printer_name = "RONGTA 58mm Series Printer"; 
		$handle = printer_open($printer_name);
		printer_set_option($handle, PRINTER_MODE, "RAW");//Body
		
		$json=json_decode($result,true);

		$triggerInvoice=$json["data"]["TriggerInvoice"];
		foreach($triggerInvoice as $invoice){
			printer_start_doc($handle, "My Document");
			printer_start_page($handle);
			$content=getInvoice($invoice["invoice"][0]);
			printer_write($handle,$content);
			
			printer_end_page($handle);
			printer_end_doc($handle);
		}
		printer_close($handle);
		
	}
	
	function getInvoice($invoice){
		$final="";
		$line="--------------------------------\n";
		$description="Food              Qty      Price\n";
		$title="          ";
		$telephone="          Tel:";
		$invoiceNo="Invoice:";
		$date="Date:";
		$table="          Table No:";
		$takeout="          Takeout No:";
		$total="Total:";
		
		//$final.=$title.mb_convert_encoding($invoice["restaurant"]["restChiName"],"GB2312","UTF-8")."\n";
		$final.=$title.$invoice["restaurant"]["restEngName"]."\n";
		$final.=$telephone.$invoice["restaurant"]["restTel"]."\n\n";
		if($invoice["table"]!=null){
			$final.=$table.$invoice["table"]["tableNo"]."\n\n";
		}else if($invoice["takeout"]!=null&&$invoice["takeout"]["address"]==null){
			$final.=$takeout.$invoice["takeout"]["takeoutNo"]."\n\n";
		}else{
			$final.="\n\n";
		}
		$final.=$invoiceNo.$invoice["invoiceID"]."\n";
		$final.=$date.$invoice["orderDateTime"]."\n";
		//line
		$final.=$line;
		//description
		$final.=$description;
		//line
		$final.=$line;
		foreach($invoice["setOrder"] as $setOrder){
			//setItem
			$name=$setOrder["setEngName"];
			$quantity=$setOrder["quantity"];
			$price=$setOrder["setSubPrice"];
			$final.=getContent(0,$name,$quantity,$price);
			foreach($setOrder["setOrderChoice"] as $setOrderChoice){
				//setFood
				$name=$setOrderChoice["foodEngName"];
				$quantity=$setOrderChoice["quantity"];
				$price=$setOrderChoice["extraSubPrice"];
				$final.=getContent(1,$name,$quantity,$price);
				foreach($setOrderChoice["ChoiceOption"] as $choiceOption){
					//setFoodOption
					$name=$choiceOption["contentEng"];
					$final.=getContent(2,$name,"","");
				}
			}
		}
		foreach($invoice["orderFood"] as $orderFood){
			//Food
			$name=$orderFood["foodEngName"];
			$quantity=$orderFood["quantity"];
			$price=$orderFood["foodSubPrice"];
			$final.=getContent(0,$name,$quantity,$price);
			foreach($orderFood["specialOption"] as $specialOption){
				//foodOption
				$name=$specialOption["contentEng"];
				$final.=getContent(1,$name,"","");
			}
		}		
		//line
		$final.=$line;
		foreach($invoice["charge"] as $orderFood){
			//Charge
			$name=$orderFood["detailEng"];
			$price=$orderFood["charge"];
			$final.=getContent(0,$name,"",$price);
		}
		//line
		$final.=$line;
		//Total
		$price=$invoice["totalCost"];
		$content=$total.$price;
		$final.=getSpace(32,$content).$content."\n";
		return $final;
	}
	
	function getContent($firstSpace,$name,$quantity,$price){
		$content="";
		for($i=0;$i<$firstSpace;$i++){
			$content.=" ";
		}
		$content.=$name;
		$content.=getSpace(18,$content);
		$content.=getSpace(2,$quantity).$quantity;
		$content.=getSpace(12,$price).$price."\n";
		return $content;
	}
	
	function getSpace($max,$content){
		$space="";
		$spaceLength=$max-strlen($content);
		for($i=0;$i<$spaceLength;$i++){
			$space.=" ";
		}
		return $space;
	}

	function testPrinter(){
		//32 one line
		$printer_name = "RONGTA 58mm Series Printer"; 
		$handle = printer_open($printer_name);
		printer_set_option($handle, PRINTER_MODE, "RAW");//Body
		$data=mb_convert_encoding("大家乐(将军澳)","GB2312","UTF-8");
		$content="          $data\n".//Title
				 "          Tel:2178 4070\n\n".//telephone
				 "          Takeout No:1\n\n".//number
				 "Invoice:I00001\n".//invoice
				 "Date:01/01/17 00:00:00\n".//date
				 "--------------------------------\n".//line
				 "Food              Qty     Price\n".//description
				 "--------------------------------\n".
				 "breakfast          1       $10.0\n".//setItem
				 " -dim sum         10        $0.0".//setFood(1+..+)
				 "  -less oil        1            \n".//setFoodOption(32=2+x+1+8+12)
				 "dum sum            1       $10.0\n".//food
				 "--------------------------------\n".
				 "             special        *0.7\n".//charge/coupon
				 "--------------------------------\n".
				 "                     Total:$10.0\n";//total
		printer_start_doc($handle, "My Document");
		printer_start_page($handle);
		printer_write($handle,$data);
		
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);
	}
?>