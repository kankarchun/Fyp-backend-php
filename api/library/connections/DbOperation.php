<?php
	class DbOperation
	{
		private $conn;
		private $today;
		
		function __construct()
		{
			require_once dirname(__FILE__) . '/conn.php';
			
			$db=new DbConnect();
			$this->conn=$db->connect();
			
			date_default_timezone_set('Asia/Hong_Kong');
			$this->today = date('Y/m/d H:i:s', time());
			
			set_exception_handler(array($this,'errorBlock'));
		}
		
		public function errorBlock($e)
		{
			$msg=array('result'=>500,'message'=>"sql error",'data'=>$e->getMessage());
			echo json_encode($msg, JSON_UNESCAPED_UNICODE);
			return false;
		}
		
		public function getAllCustomer()
		{
			$stmt=$this->conn->prepare("select * from customer");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerID()
		{
			$stmt=$this->conn->prepare("select custID from customer 
			ORDER BY custID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerNoticeID()
		{
			$stmt=$this->conn->prepare("select cNID from custnotice 
			ORDER BY cNID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSmsByPhone($phoneNo)
		{
			$params=array(
			':phoneNo'=>$phoneNo
			);
			
			$stmt=$this->conn->prepare("select * from sms where
			phone=:phoneNo' order by id desc limit 1");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerByPhone($phoneNo)
		{
			$params=array(
			':phoneNo'=>$phoneNo
			);
			
			$stmt=$this->conn->prepare("select * from customer where 
			custTel=:phoneNo");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerByDevice($custDevice)
		{
			$params=array(
			':custDevice'=>password_hash($custDevice, PASSWORD_BCRYPT)
			);
			
			$stmt=$this->conn->prepare("select * from customer where
			custDevice=:custDevice");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantCharge($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from charge where 
			restID=:restID and hide='0'
			order by orderIn");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteRestaurantByRestaurantID($custID,$restID)
		{
			$params=array(
			':custID'=>$custID,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from favourite where
			custID=:custID and restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteFood($custID,$foodID)
		{
			$params=array(
			':custID'=>$custID,
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("select * from favouritefood where 
			custID=:custID and foodID=:foodID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteSet($custID,$setID)
		{
			$params=array(
			':custID'=>$custID,
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("select * from favouriteset where
			custID=:custID and setID=:setID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteRestaurant($custID)
		{
			$params=array(
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("select * from favourite where 
			custID=:custID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByID($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where
			region.rgid=restaurant.rgid and
			restcompany.companyID=restaurant.companyID and 
			restaurant.restID=:restID and
			restaurant.locked=0 and
			restcompany.locked=0");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteFoodByRestaurantID($custID,$restID)
		{
			$params=array(
			':custID'=>$custID,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("
			select * from restaurant,favouritefood,restcompany,menugroup,menugroupitem where
			menugroup.groupNo=menugroupitem.groupNo and
			menugroup.restID=menugroupitem.restID and
			menugroupitem.foodID=favouritefood.foodID and
			restcompany.companyID=restaurant.companyID and
			restaurant.restID=favouritefood.restID and
			favouritefood.custID=:custID and 
			favouritefood.restID=:restID and 
			restaurant.locked=0 and
			restcompany.locked=0");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuItemFood($foodID,$restID)
		{
			$params=array(
			':foodID'=>$foodID,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from food,menugroupitem where 
			menugroupitem.foodID=food.foodID and 
			available=0 and 
			food.foodID=:foodID and
			food.restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteOrderOption($ffID)
		{
			$params=array(
			':ffID'=>$ffID
			);
			
			$stmt=$this->conn->prepare("select * from favouriteorderoption where
			ffID=:ffID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSpecialOptionByID($optID)
		{
			$params=array(
			':optID'=>$optID
			);
			
			$stmt=$this->conn->prepare("select * from specialoption where 
			optID=:optID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteSetByRestaurantID($custID,$restID)
		{
			$params=array(
			':custID'=>$custID,
			':optID'=>$optID
			);
			
			$stmt=$this->conn->prepare("
			select * from restaurant,favouriteset,restcompany,menugroup,menugroupitem where 
			menugroup.groupNo=menugroupitem.groupNo and 
			menugroup.restID=menugroupitem.restID and 
			menugroupitem.setID=favouriteset.setID and
			restcompany.companyID=restaurant.companyID and
			restaurant.restID=favouriteset.restID and
			custID=:custID and 
			favouriteset.restID=:restID and
			restaurant.locked=0 and 
			restcompany.locked=0");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuItemSetItem($setID,$restID)
		{
			$params=array(
			':setID'=>$setID,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from setitem,menugroupitem where 
			menugroupitem.setID=setitem.setID and 
			available=0 and 
			setitem.setID=:setID and
			setitem.restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetTitle($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("select * from settitle where 
			setID=:setID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerFavouriteSetChoice($fsID,$custID)
		{
			$params=array(
			':fsID'=>$fsID,
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("select * from favouritesetchoice where
			fsID=:fsID and
			custID=:custID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuItemSetFood($titleNo)
		{
			$params=array(
			':titleNo'=>$titleNo
			);
			
			$stmt=$this->conn->prepare("select * from food,setfood,menugroupitem where
			menugroupitem.foodID=food.foodID and
			available=0 and 
			food.foodID=setfood.foodID and 
			setfood.titleNo=:titleNo");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteChoiceOption($fscID)
		{
			$params=array(
			':fscID'=>$fscID
			);
			
			$stmt=$this->conn->prepare("select * from favouritechoiceoption where 
			fscID=:fscID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuItemSetFoodBySetID($setID,$titleNo)
		{
			$params=array(
			':setID'=>$setID,
			':titleNo'=>$titleNo
			);
			
			$stmt=$this->conn->prepare("select * from food,setfood,menugroupitem where
			menugroupitem.foodID=food.foodID and
			available=0 and 
			food.foodID=setfood.foodID and 
			setfood.setID=:setID and
			setfood.titleNo=:titleNo");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getOptionAllow($foodID)
		{
			$params=array(
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("select * from specialoption where 
			optid in (select optid from optionallow where 
			foodID=:foodID)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerInvoice($custID)
		{
			$params=array(
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("select * from invoice where 
			custID=:custID
			order by orderDateTime desc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getInvoiceTakeout($invoiceID)
		{
			$params=array(
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from takeout where 
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerById($custID)
		{
			$params=array(
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("select * from customer where 
			custID=:custID and 
			locked=0");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantTable($tableID)
		{
			$params=array(
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region,resttable where
			resttable.restid=restaurant.restid and 
			restcompany.companyID=restaurant.companyID and
			restaurant.rgID=region.rgID and 
			restaurant.locked=0 and 
			restcompany.locked=0 and
			tableID=:tableID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getInvoiceCharge($invoiceID)
		{
			$params=array(
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from invoicecharge where 
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getOrderFood($invoiceID)
		{
			$params=array(
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from orderfood where 
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getOrderOption($orderNo,$invoiceID)
		{
			$params=array(
			':orderNo'=>$orderNo,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from orderoption where
			orderNo=:orderNo and 
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetOrder($invoiceID)
		{
			$params=array(
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from setorder where 
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetOrderChoice($setOrderNo,$invoiceID)
		{
			$params=array(
			':setOrderNo'=>$setOrderNo,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from setorderchoice where 
			setOrderNo=:setOrderNo and invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getChoiceOption($setOrderChoiceNo,$setOrderNo,$invoiceID)
		{
			$params=array(
			':setOrderChoiceNo'=>$setOrderChoiceNo,
			':setOrderNo'=>$setOrderNo,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from choiceoption where
			setOrderChoiceNo=:setOrderChoiceNo and 
			setOrderNo=:setOrderNo and 
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getInvoiceId()
		{
			$stmt=$this->conn->prepare("select invoiceID from invoice
			ORDER BY invoiceID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getTakeoutId()
		{
			$stmt=$this->conn->prepare("select takeoutID from takeout
			ORDER BY takeoutID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantTableByRestaurantID($restID,$tableID)
		{
			$params=array(
			':restID'=>$restID,
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("select * from restaurant,resttable where
			restaurant.restID=resttable.restID and
			restaurant.restID=:restID and
			resttable.tableID=:tableID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}		
		
		public function getInvoiceTableNo()
		{
			$stmt=$this->conn->prepare("select * from invoice where
			tableID is null and 
			orderDateTime>CURDATE()");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}	
		
		public function getOrderFoodNo()
		{
			$stmt=$this->conn->prepare("select orderNo from orderfood
			ORDER BY orderNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}	
		
		public function getFood($foodID)
		{
			$params=array(
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("select * from food where
			foodID=:foodID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}	
		
		public function getSetOrderNo()
		{
			$stmt=$this->conn->prepare("select setOrderNo from setorder 
			ORDER BY setOrderNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}	
		
		public function getSetItem($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("select * from setitem where 
			setID=:setID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetOrderChoiceNo()
		{
			$stmt=$this->conn->prepare("select setOrderChoiceNo from setorderchoice
			ORDER BY setOrderChoiceNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}	
		
		public function getSetFood($foodNo)
		{
			$params=array(
			':foodNo'=>$foodNo
			);
			
			$stmt=$this->conn->prepare("select * from setfood,food where
			setfood.foodID=food.foodID and 
			foodNo=:foodNo");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getInvoiceChargeNo()
		{
			$stmt=$this->conn->prepare("select iChargeNo from invoicecharge 
			ORDER BY iChargeNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCharge($chargeID)
		{
			$params=array(
			':chargeID'=>$chargeID
			);
			
			$stmt=$this->conn->prepare("select * from charge where
			chargeID=:chargeID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getInvoice($invoiceID)
		{
			$params=array(
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("select * from invoice where
			invoiceID=:invoiceID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerAddress($custID)
		{
			$params=array(
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("select * from custaddress where
			custID=:custID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerAddressNo()
		{
			$stmt=$this->conn->prepare("select cAddressNo from custaddress
			ORDER BY cAddressNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantMenu($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from menugroup where 
			restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantMenuGroupItem($restID,$menuID)
		{
			$params=array(
			':restID'=>$restID,
			':menuID'=>$menuID
			);
			
			$stmt=$this->conn->prepare("select * from menugroupitem where
			restID=:restID and 
			groupNo=:menuID 
			order by rowNumber,columnNumber");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuWidgetByID($widgetID)
		{
			$params=array(
			':widgetID'=>$widgetID
			);
			
			$stmt=$this->conn->prepare("select * from menuwidget where
			widgetID=:widgetID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetFoodByTitle($titleNo)
		{
			$params=array(
			':titleNo'=>$titleNo
			);
			
			$stmt=$this->conn->prepare("select * from setfood where 
			titleNo=:titleNo");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFoodByKeywords($keywords)
		{
			$params=array(
			':keywords'=>"%$keywords%"
			);
			
			$stmt=$this->conn->prepare("select * from food,restaurant,restcompany,region where 
			restaurant.rgID=region.rgID and 
			restcompany.companyID=restaurant.companyID and
			food.restID=restaurant.restID and 
			(foodChiName like :keywords or foodEngName like :keywords) and
			restaurant.locked=0 and 
			restcompany.locked=0 
			order by food.foodEngName asc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getChargeByRestaurantID($restID)
		{
			$params=array(
			':restID'=>$restID
			);

			$stmt=$this->conn->prepare("select * from charge where
			restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetItemByKeywords($keywords)
		{
			$params=array(
			':keywords'=>"%$keywords%"
			);
			
			$stmt=$this->conn->prepare("select * from setitem,restaurant,restcompany where 
			restcompany.companyID=restaurant.companyID and
			setitem.restID=restaurant.restID and
			(setChiName like :keywords or setEngName like :keywords) and 
			restaurant.locked=0 and
			restcompany.locked=0 
			order by setItem.setEngName asc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFoodInSetFood($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("select * from food where 
			foodID in 
			(select foodID from setFood where 
			setID=:setID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetTitleInSetFood($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("select * from settitle where 
			titleNo in 
			(select titleNo from setFood where
			setID=:setID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByKeywords($keywords)
		{
			$params=array(
			':keywords'=>"%$keywords%"
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and 
			restaurant.rgID=region.rgID and 
			(restChiName like :keywords or restEngName like :keywords) and 
			restaurant.locked=0 and 
			restcompany.locked=0");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByRegion($region)
		{
			$params=array(
			':region'=>"%$region%"
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and
			restaurant.rgID=region.rgID and 
			(rgChiName like :region or rgEngName like :region) and 
			restaurant.locked=0 and 
			restcompany.locked=0 
			order by restaurant.restEngName asc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRegion()
		{			
			$stmt=$this->conn->prepare("
			select region.rgID,rgChiName,rgEngName from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and 
			restaurant.rgID=region.rgID and 
			restaurant.locked=0 and 
			restcompany.locked=0 
			group by region.rgID
			order by region.rgEngName asc");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByRegionID($regionID)
		{
			$params=array(
			':regionID'=>$regionID
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and
			restaurant.rgID=region.rgID and 
			restaurant.rgID=:regionID and
			restaurant.locked=0 and
			restcompany.locked=0 
			order by restaurant.restEngName asc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByKeywordsRegion($keywords,$region)
		{
			$params=array(
			':keywords'=>"%$keywords%",
			':region'=>"%$region%"
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and 
			restaurant.rgID=region.rgID and 
			(restChiName like :keywords or restEngName like :keywords) and 
			(rgChiName like :region or rgEngName like :region) and
			restaurant.locked=0 and
			restcompany.locked=0 
			order by restaurant.restEngName asc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByLocation($minLatitude,$maxLatitude,$minLongitude,$maxLongitude)
		{
			$params=array(
			':minLatitude'=>$minLatitude,
			':maxLatitude'=>$maxLatitude,
			':minLongitude'=>$minLongitude,
			':maxLongitude'=>$maxLongitude
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and 
			restaurant.rgID=region.rgID and 
			latitude between :minLatitude and :maxLatitude and 
			longitude between :minLongitude and :maxLongitude and 
			restaurant.locked=0 and
			restcompany.locked=0 
			order by restaurant.restEngName asc");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteFoodID()
		{
			$stmt=$this->conn->prepare("select ffID from favouritefood
			ORDER BY ffID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteOrderOptionNo()
		{
			$stmt=$this->conn->prepare("select fooNo from favouriteorderoption 
			ORDER BY fooNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteSetID()
		{
			$stmt=$this->conn->prepare("select fsID from favouriteset
			ORDER BY fsID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteSetChoiceID()
		{
			$stmt=$this->conn->prepare("select fsID from favouriteset
			ORDER BY fsID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFavouriteChoiceOptionNo()
		{
			$stmt=$this->conn->prepare("select fcoNo from favouritechoiceoption 
			ORDER BY fcoNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSMSByCode($smsCode)
		{
			$params=array(
			':smsCode'=>$smsCode
			);
			
			$stmt=$this->conn->prepare("select * from sms where 
			verifyCode=:smsCode
			order by id desc limit 1");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getInvoiceByDate($restID,$minOrderDate,$maxOrderDate)
		{
			$params=array(
			':restID'=>$restID,
			':minOrderDate'=>$minOrderDate,
			':maxOrderDate'=>$maxOrderDate
			);
			
			$stmt=$this->conn->prepare("select * from invoice where 
			restID=:restID and
			orderDateTime between DATE(:minOrderDate) and DATE(:maxOrderDate)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuWidget()
		{			
			$stmt=$this->conn->prepare("select * from menuwidget");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getManagerByID($managerID)
		{
			$params=array(
			':managerID'=>$managerID
			);
			
			$stmt=$this->conn->prepare("select * from manager where
			managerID=:managerID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getChargeID()
		{
			$stmt=$this->conn->prepare("select chargeID from charge
			ORDER BY chargeID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSpecialOption()
		{
			$stmt=$this->conn->prepare("select * from specialoption");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getOptionAllowID()
		{
			$stmt=$this->conn->prepare("select oaID from optionallow 
			ORDER BY oaID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantCode($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from restaurant where
			restID=:restID and
			qrCode is not null");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantTableCode($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from resttable where 
			restID=:restID and 
			qrCode is not null");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFoodByRestaurantID($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from food where
			restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetItemByRestaurantID($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from setitem where 
			restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetItemID()
		{
			$stmt=$this->conn->prepare("select setID from setitem
			ORDER BY setID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetFoodNo()
		{
			$stmt=$this->conn->prepare("select foodNo from setfood 
			ORDER BY foodNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetFoodPrice($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("select foodPrice from setfood,food where 
			setfood.foodID=food.foodID and 
			setfood.setID=:setID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFoodID()
		{
			$stmt=$this->conn->prepare("select foodID from food 
			ORDER BY foodID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuGroupNo()
		{
			$stmt=$this->conn->prepare("select groupNo from menugroup 
			ORDER BY groupNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getMenuGroupItemNo()
		{
			$stmt=$this->conn->prepare("select itemNo from menugroupitem
			ORDER BY itemNo DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantTableID()
		{
			$stmt=$this->conn->prepare("select tableID from resttable
			ORDER BY tableID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerReportID()
		{
			$stmt=$this->conn->prepare("select reportID from custreport
			ORDER BY reportID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getTableFloorPlan($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from tablefloorplan where
			restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantTableByFloor($floor,$restID)
		{
			$params=array(
			':floor'=>$floor,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from resttable where
			floor=:floor and
			restID=:restID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getFoodProfit($lastYear,$currentYear,$restID)
		{
			$params=array(
			':lastYear'=>$lastYear,
			':currentYear'=>$currentYear,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select SUM(quantity) as sum,foodEngName from orderfood,invoice where
			orderfood.invoiceID=invoice.invoiceID and 
			orderDateTime between Date(:lastYear) and Date(:currentYear) and
			restID=:restID
			group by foodEngName");

			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getSetProfit($lastYear,$currentYear,$restID)
		{
			$params=array(
			':lastYear'=>$lastYear,
			':currentYear'=>$currentYear,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select SUM(quantity) as sum,setEngName from setorder,invoice where
			setorder.invoiceID=invoice.invoiceID and
			orderDateTime between Date(:lastYear) and Date(:currentYear) and 
			restID=:restID
			group by setEngName");

			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getTimeFoodOrder($lastYear,$currentYear,$restID,$start,$end)
		{
			$params=array(
			':lastYear'=>$lastYear,
			':currentYear'=>$currentYear,
			':restID'=>$restID,
			':start'=>$start,
			':end'=>$end
			);
			
			$stmt=$this->conn->prepare("select Count(*) as count from orderfood,invoice where
			orderfood.invoiceID=invoice.invoiceID and 
			orderDateTime between Date(:lastYear) and Date(:currentYear) and
			restID=:restID and 
			cast(orderDateTime as time) BETWEEN ':start:00' and ':end:00'");

			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getTimeSetOrder($lastYear,$currentYear,$restID,$start,$end)
		{
			$params=array(
			':lastYear'=>$lastYear,
			':currentYear'=>$currentYear,
			':restID'=>$restID,
			':start'=>$start,
			':end'=>$end
			);
			
			$stmt=$this->conn->prepare("select Count(*) as count from setorder,invoice where 
			setorder.invoiceID=invoice.invoiceID and 
			orderDateTime between Date(:lastYear) and Date(:currentYear) and
			restID=:restID and 
			cast(orderDateTime as time) BETWEEN ':start:00' and ':end:00'");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantProfitByCompany($firstDayMonth,$lastDayMonth,$companyID)
		{
			$params=array(
			':firstDayMonth'=>$firstDayMonth,
			':lastDayMonth'=>$lastDayMonth,
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("select * from invoice where 
			orderDateTime between Date(:firstDayMonth) and Date(:lastDayMonth) and
			restID in (select restID from restaurant where companyID=:companyID)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantProfit($restID,$firstDayMonth,$lastDayMonth)
		{
			$params=array(
			':restID'=>$restID,
			':firstDayMonth'=>$firstDayMonth,
			':lastDayMonth'=>$lastDayMonth
			);
			
			$stmt=$this->conn->prepare("select * from invoice where 
			restID=:restID and 
			orderDateTime between Date(:firstDayMonth) and Date(:lastDayMonth)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCompanyByID($companyID)
		{
			$params=array(
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("select * from restcompany where 
			companyID=:companyID and
			restcompany.locked=0");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantByCompany($companyID)
		{
			$params=array(
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("select * from restcompany,restaurant,region where 
			restcompany.companyID=restaurant.companyID and 
			restaurant.rgID=region.rgID and
			restaurant.locked=0 and
			restcompany.locked=0 and
			restaurant.companyID=:companyID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getManagerByCompany($companyID)
		{
			$params=array(
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("select * from manager where 
			companyID=:companyID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}

		public function getManagerID()
		{			
			$stmt=$this->conn->prepare("select managerID from manager 
			ORDER BY managerID DESC LIMIT 1");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantNotice($companyID)
		{
			$params=array(
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("select * from restnotice where
			companyID=:companyID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}

		public function getCustomerNotice($custID)
		{
			$params=array(
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("select * from custnotice where
			custID=:custID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getAllRestaurant()
		{
			$stmt=$this->conn->prepare("select * from restaurant");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getAllCompany()
		{
			$stmt=$this->conn->prepare("select * from restcompany");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getAllRegion()
		{
			$stmt=$this->conn->prepare("select * from region");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getTrigger($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("select * from trigger_invoice,invoice where
			invoice.invoiceID=trigger_invoice.invoiceID and 
			restID=:restID
			order by invoiceID desc limit 1");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getRestaurantRegister($firstDayMonth,$lastDayMonth)
		{
			$params=array(
			':firstDayMonth'=>$firstDayMonth,
			':lastDayMonth'=>$lastDayMonth
			);
			
			$stmt=$this->conn->prepare("select * from restaurant where 
			registeredDate between Date(:firstDayMonth) and Date(:lastDayMonth)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerRegister($firstDayMonth,$lastDayMonth)
		{
			$params=array(
			':firstDayMonth'=>$firstDayMonth,
			':lastDayMonth'=>$lastDayMonth
			);
			
			$stmt=$this->conn->prepare("select * from customer where 
			registeredDate between Date(:firstDayMonth) and Date(:lastDayMonth)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getAllRestaurantProfit($firstDayMonth,$lastDayMonth)
		{
			$params=array(
			':firstDayMonth'=>$firstDayMonth,
			':lastDayMonth'=>$lastDayMonth
			);
			
			$stmt=$this->conn->prepare("select * from invoice where 
			orderDateTime between Date(:firstDayMonth) and Date(:lastDayMonth)");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getCustomerReport()
		{
			$stmt=$this->conn->prepare("select * from custreport,customer where
			custreport.custID=customer.custID");
			$stmt->execute();
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function getAdminByID($adminID)
		{
			$params=array(
			':adminID'=>$adminID
			);
			
			$stmt=$this->conn->prepare("select * from admin where
			adminID=:adminID");
			$stmt->execute($params);
			$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
			return $result;
		}
		
		public function createCustomer($custID,$custDevice,$custTel)
		{
			$params=array(
			':custID'=>$custID,
			':custDevice'=>password_hash($custDevice,PASSWORD_BCRYPT),
			':custTel'=>$custTel
			);
			
			$stmt=$this->conn->prepare("insert into customer(custID,custDevice,custTel) values 
			(:custID,:custDevice,:custTel)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSMS($phone,$verifyCode)
		{
			$params=array(
			':phone'=>$phone,
			':verifyCode'=>$verifyCode
			);
			
			$stmt=$this->conn->prepare("insert into sms(phone,verifyCode) values 
			(:phoneNo,:verifyCode)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerNotice($cNID,$custID,$title,$titleEng,$description,$descriptionEng)
		{
			$params=array(
			':cNID'=>$cNID,
			':custID'=>$custID,
			':title'=>$title,
			':titleEng'=>$titleEng,
			':description'=>$description,
			':descriptionEng'=>$descriptionEng
			);
			
			$stmt=$this->conn->prepare("
			insert into custnotice(cNID,custID,title,titleEng,description,descriptionEng) values 
			(:cNID,:custID,:title,:titleEng,:description,:descriptionEng)"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createInvoiceOfTable($invoiceID,$restID,$custID,$tableID)
		{
			$params=array(
			':invoiceID'=>$invoiceID,
			':restID'=>$restID,
			':custID'=>$custID,
			':tableID'=>$tableID,
			':orderDateTime'=>$orderDateTime
			);
			
			$stmt=$this->conn->prepare("
			insert into invoice(invoiceID,restID,custID,tableID,foodTotalCost,totalCost,orderDateTime) values 
			(:invoiceID,:restID,:custID,:tableID,0,0,:orderDateTime)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createInvoiceOfTakeout($invoiceID,$restID,$custID,$takeoutID)
		{
			$params=array(
			':invoiceID'=>$invoiceID,
			':restID'=>$restID,
			':custID'=>$custID,
			':takeoutID'=>$takeoutID,
			':foodTotalCost'=>0,
			':totalCost'=>0,
			':orderDateTime'=>$this->today
			);
			
			$stmt=$this->conn->prepare("
			insert into invoice(invoiceID,restID,custID,takeoutID,foodTotalCost,totalCost,orderDateTime) values 
			(:invoiceID,:restID,:custID,:takeoutID,:foodTotalCost,:totalCost,:orderDateTime)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createTakeoutOfAddress($takeoutID,$address,$invoiceID)
		{
			$params=array(
			':takeoutID'=>$takeoutID,
			':address'=>$address,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("
			insert into takeout(takeoutID,address,invoiceID) values 
			(:takeoutID,:address,:invoiceID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createTakeoutOfNo($takeoutID,$takeoutNo,$invoiceID)
		{
			$params=array(
			':takeoutID'=>$takeoutID,
			':takeoutNo'=>$takeoutNo,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("
			insert into takeout(takeoutID,takeoutNo,invoiceID) values
			(:takeoutID,:takeoutNo,:invoiceID)");

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createOrderFood($orderNo,$invoiceID,$foodChiName,$foodEngName,$foodPrice,$quantity)
		{
			$params=array(
			':orderNo'=>$orderNo,
			':invoiceID'=>$invoiceID,
			':foodChiName'=>$foodChiName,
			':foodEngName'=>$foodEngName,
			':foodPrice'=>$foodPrice,
			':quantity'=>$quantity
			);
			
			$stmt=$this->conn->prepare("
			insert into orderfood(orderNo,invoiceID,foodChiName,foodEngName,foodPrice,quantity,foodSubPrice) values
			(:orderNo,:invoiceID,:foodChiName,:foodEngName,:foodPrice,:quantity,0)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createOrderOption($optID,$orderNo,$invoiceID)
		{
			$params=array(
			':optID'=>$optID,
			':orderNo'=>$orderNo,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("
			insert into orderoption(optID,orderNo,invoiceID) values 
			(:optID,:orderNo,:invoiceID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSetOrder($setOrderNo,$invoiceID,$setChiName,$setEngName,$setPrice,$quantity)
		{
			$params=array(
			':setOrderNo'=>$setOrderNo,
			':invoiceID'=>$invoiceID,
			':setChiName'=>$setChiName,
			':setEngName'=>$setEngName,
			':setPrice'=>$setPrice,
			':quantity'=>$quantity
			);
			
			$stmt=$this->conn->prepare("
			insert into setorder(setOrderNo,invoiceID,setChiName,setEngName,setPrice,quantity,setSubPrice) values
			(:setOrderNo,:invoiceID,:setChiName,:setEngName,:setPrice,:quantity,0)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSetOrderChoice($setOrderChoiceNo,$setOrderNo,$invoiceID,$foodChiName,$foodEngName,$extraPrice,$quantity,$extraSubPrice)
		{
			$params=array(
			':setOrderChoiceNo'=>$setOrderChoiceNo,
			':setOrderNo'=>$setOrderNo,
			':invoiceID'=>$invoiceID,
			':foodChiName'=>$foodChiName,
			':foodEngName'=>$foodEngName,
			':extraPrice'=>$extraPrice,
			':quantity'=>$quantity,
			':extraSubPrice'=>$extraSubPrice
			);
			
			$stmt=$this->conn->prepare("
			insert into setorderchoice(setOrderChoiceNo,setOrderNo,invoiceID,foodChiName,foodEngName,extraPrice,quantity,extraSubPrice) values 
			(:setOrderChoiceNo,:setOrderNo,:invoiceID,:foodChiName,:foodEngName,:extraPrice,:quantity,:extraSubPrice)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createChoiceOption($optID,$setOrderChoiceNo,$setOrderNo,$invoiceID)
		{
			$params=array(
			':optID'=>$optID,
			':setOrderChoiceNo'=>$setOrderChoiceNo,
			':setOrderNo'=>$setOrderNo,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("
			insert into choiceoption(optID,setOrderChoiceNo,setOrderNo,invoiceID) values
			(:optID,:setOrderChoiceNo,:setOrderNo,:invoiceID)");

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createInvoiceCharge($iChargeNo,$invoiceID,$detailChi,$detailEng,$charge)
		{
			$params=array(
			':iChargeNo'=>$iChargeNo,
			':invoiceID'=>$invoiceID,
			':detailChi'=>$detailChi,
			':detailEng'=>$detailEng,
			':charge'=>$charge
			);
			
			$stmt=$this->conn->prepare("
			insert into invoicecharge(iChargeNo,invoiceID,detailChi,detailEng,charge) values
			(:iChargeNo,:invoiceID,:detailChi,:detailEng,:charge)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerAddress($cAddressNo,$address,$custID)
		{
			$params=array(
			':cAddressNo'=>$cAddressNo,
			':address'=>$address,
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("
			insert into custaddress(cAddressNo,address,custID) values 
			(:cAddressNo,:address,:custID)");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerFavouriteRestaurant($custID,$restID)
		{
			$params=array(
			':custID'=>$custID,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("
			insert into favourite(custID,restID) values
			(:custID,:restID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerFavouriteFood($ffID,$custID,$restID,$foodID)
		{
			$params=array(
			':ffID'=>$ffID,
			':custID'=>$custID,
			':restID'=>$restID,
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("
			insert into favouritefood(ffID,custID,restID,foodID) values 
			(:ffID,:custID,:restID,:foodID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerFavouriteOrderOption($fooNo,$ffID,$optID)
		{
			$params=array(
			':fooNo'=>$fooNo,
			':ffID'=>$ffID,
			':optID'=>$optID
			);
			
			$stmt=$this->conn->prepare("
			insert into favouriteorderoption(fooNo,ffID,optID) values
			(:fooNo,:ffID,:optID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerFavouriteSet($fsID,$custID,$restID,$setID)
		{
			$params=array(
			':fsID'=>$fsID,
			':custID'=>$custID,
			':restID'=>$restID,
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("
			insert into favouriteset(fsID,custID,restID,setID) values
			(:fsID,:custID,:restID,:setID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerFavouriteSetChoice($fscID,$fsID,$custID,$foodNo,$quantity)
		{
			$params=array(
			':fscID'=>$fscID,
			':fsID'=>$fsID,
			':custID'=>$custID,
			':foodNo'=>$foodNo,
			':quantity'=>$quantity
			);
			
			$stmt=$this->conn->prepare("
			insert into favouritesetchoice(fscID,fsID,custID,foodNo,quantity) values
			(:fscID,:fsID,:custID,:foodNo,:quantity)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerFavouriteChoiceOption($fcoNo,$fscID,$optID)
		{
			$params=array(
			':fcoNo'=>$fcoNo,
			':fscID'=>$fscID,
			':optID'=>$optID
			);
			
			$stmt=$this->conn->prepare("
			insert into favouritechoiceoption(fcoNo,fscID,optID) values 
			(:fcoNo,:fscID,:optID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSMSWithOldPhone($phoneNo,$verifyCode,$oldPhone)
		{
			$params=array(
			':phoneNo'=>$phoneNo,
			':verifyCode'=>$verifyCode,
			':oldPhone'=>$oldPhone
			);
			
			$stmt=$this->conn->prepare("
			insert into sms(phone,verifyCode,oldPhone) values
			(:phoneNo,:verifyCode,:oldPhone)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCharge($chargeID,$restID,$charge,$hide,$detailChi,$detailEng,$orderIn)
		{
			$params=array(
			':chargeID'=>$chargeID,
			':restID'=>$restID,
			':charge'=>$charge,
			':hide'=>$hide,
			':detailChi'=>$detailChi,
			':detailEng'=>$detailEng,
			':orderIn'=>$orderIn
			);
			
			$stmt=$this->conn->prepare("
			insert into charge(chargeID,restID,charge,hide,detailChi,detailEng,orderIn) values
			(:chargeID,:restID,:charge,:hide,:detailChi,:detailEng,:orderIn)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createOptionAllow($oaID,$optID,$foodID)
		{
			$params=array(
			':oaID'=>$oaID,
			':optID'=>$optID,
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("
			insert into optionallow(oaID,optID,foodID) values 
			(:oaID,:optID,:foodID)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createRestaurantTableCode($qrCode,$tableID)
		{
			$params=array(
			':qrCode'=>$qrCode,
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("
			update resttable set 
			qrcode=:qrCode where
			tableID=:tableID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createRestaurantCode($qrCode,$restID)
		{
			$params=array(
			':qrCode'=>$qrCode,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("
			update restaurant set 
			qrcode=:qrCode where
			restID=:restID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSetItem($setID,$restID,$groupNo,$setChiName,$setEngName,$totalPrice,$setPhoto,$setDesc,$setDescEng,$setTakeout,$managerID)
		{
			$params=array(
			':setID'=>$setID,
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':setChiName'=>$setChiName,
			':setEngName'=>$setEngName,
			':totalPrice'=>$totalPrice,
			':setPhoto'=>$setPhoto,
			':setDesc'=>$setDesc,
			':setDescEng'=>$setDescEng,
			':setTakeout'=>$setTakeout,
			':managerID'=>$managerID
			);
			
			$stmt=$this->conn->prepare("
			insert into setitem(setID,restID,groupNo,setChiName,setEngName,totalPrice,setPhoto,setDesc,setDescEng,setTakeout,managerID) values 
			(:setID,:restID,:groupNo,:setChiName,:setEngName,:totalPrice,:setPhoto,:setDesc,:setDescEng,:setTakeout,:managerID)"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSetTitle($setID,$title,$titleEng,$count)
		{
			$params=array(
			':setID'=>$setID,
			':title'=>$title,
			':titleEng'=>$titleEng,
			':count'=>$count
			);
			
			$stmt=$this->conn->prepare("
			insert into settitle(setID,title,titleEng,count) values 
			(:setID,:title,:titleEng,:count)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createSetFood($foodNo,$setID,$foodID,$titleNo,$extraPrice)
		{
			$params=array(
			':foodNo'=>$foodNo,
			':setID'=>$setID,
			':foodID'=>$foodID,
			':titleNo'=>$titleNo,
			':extraPrice'=>$extraPrice
			);
			
			$stmt=$this->conn->prepare("
			insert into setfood(foodNo,setID,foodID,titleNo,extraPrice) values 
			(:foodNo,:setID,:foodID,:titleNo,:extraPrice)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createFood($foodID,$restID,$groupNo,$foodChiName,$foodEngName,$foodPrice,$foodPhoto,$foodDesc,$foodDescEng,$foodTakeout,$managerID)
		{
			$params=array(
			':foodID'=>$foodID,
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':foodChiName'=>$foodChiName,
			':foodEngName'=>$foodEngName,
			':foodPrice'=>$foodPrice,
			':foodPhoto'=>$foodPhoto,
			':foodDesc'=>$foodDesc,
			':foodDescEng'=>$foodDescEng,
			':foodTakeout'=>$foodTakeout,
			':managerID'=>$managerID
			);
			
			$stmt=$this->conn->prepare("
			insert into food(foodID,restID,groupNo,foodChiName,foodEngName,foodPrice,foodPhoto,foodDesc,foodDescEng,foodTakeout,managerID) values
			(:foodID,:restID,:groupNo,:foodChiName,:foodEngName,:foodPrice,:foodPhoto,:foodDesc,:foodDescEng,:foodTakeout,:managerID)"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}

		public function createMenugroup($restID,$groupNo,$groupChiName,$groupEngName,$startTime,$openHour,$showDay,$managerID)
		{
			$params=array(
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':groupChiName'=>$groupChiName,
			':groupEngName'=>$groupEngName,
			':startTime'=>$startTime,
			':openHour'=>$openHour,
			':showDay'=>$showDay,
			':managerID'=>$managerID,
			':lastModify'=>$this->today
			);
			
			$stmt=$this->conn->prepare("
			insert into menugroup(restID,groupNo,groupChiName,groupEngName,startTime,openHour,showDay,managerID,lastModify) values 
			(:restID,:groupNo,:groupChiName,:groupEngName,:startTime,:openHour,:showDay,:managerID,:lastModify)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createMenugroupItemOfFood($itemNo,$restID,$groupNo,$foodID,$widgetID,$rowNumber,$columnNumber,$color)
		{
			$params=array(
			':itemNo'=>$itemNo,
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':foodID'=>$foodID,
			':widgetID'=>$widgetID,
			':rowNumber'=>$rowNumber,
			':columnNumber'=>$columnNumber,
			':color'=>$color
			);
			
			$stmt=$this->conn->prepare("
			insert into menugroupitem(itemNo,restID,groupNo,foodID,widgetID,rowNumber,columnNumber,color) values
			(:itemNo,:restID,:groupNo,:foodID,:widgetID,:rowNumber,:columnNumber,:color)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createMenugroupItemOfSet($itemNo,$restID,$groupNo,$setID,$widgetID,$rowNumber,$columnNumber,$color)
		{
			$params=array(
			':itemNo'=>$itemNo,
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':setID'=>$setID,
			':widgetID'=>$widgetID,
			':rowNumber'=>$rowNumber,
			':columnNumber'=>$columnNumber,
			':color'=>$color
			);
			
			$stmt=$this->conn->prepare("
			insert into menugroupitem(itemNo,restID,groupNo,setID,widgetID,rowNumber,columnNumber,color) values
			(:itemNo,:restID,:groupNo,:setID,:widgetID,:rowNumber,:columnNumber,:color)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createTableFloorPlan($restID,$floor,$sizeX,$sizeY,$managerID)
		{
			$params=array(
			':restID'=>$restID,
			':floor'=>$floor,
			':sizeX'=>$sizeX,
			':sizeY'=>$sizeY,
			':managerID'=>$managerID,
			':lastModify'=>$this->today
			);
			
			$stmt=$this->conn->prepare("
			insert into tablefloorplan(restID,floor,sizeX,sizeY,managerID,lastModify) values
			(:restID,:floor,:sizeX,:sizeY,:managerID,:lastModify)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createRestaurantTable($tableID,$tableNo,$restID,$floor,$posX,$posY,$maxNo,$width,$height)
		{
			$params=array(
			':tableID'=>$tableID,
			':tableNo'=>$tableNo,
			':restID'=>$restID,
			':floor'=>$floor,
			':posX'=>$posX,
			':posY'=>$posY,
			':maxNo'=>$maxNo,
			':width'=>$width,
			':height'=>$height
			);
			
			$stmt=$this->conn->prepare("
			insert into resttable(tableID,tableNo,restID,floor,posX,posY,maxNo,width,height) values 
			(:tableID,:tableNo,:restID,:floor,:posX,:posY,:maxNo,:width,:height)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerReport($reportID,$custID,$custComment,$managerID)
		{
			$params=array(
			':reportID'=>$reportID,
			':custID'=>$custID,
			':custComment'=>$custComment,
			':managerID'=>$managerID
			);
			
			$stmt=$this->conn->prepare("
			insert into custreport(reportID,custID,custComment,managerID) values 
			(:reportID,:custID,:custComment,:managerID)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createTriggerInvoice($invoiceID)
		{
			$params=array(
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("
			insert into trigger_invoice(invoiceID) values 
			(:invoiceID)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createManager($managerID,$managerPW,$companyID,$restID,$managerEmail,$locked)
		{
			$params=array(
			':managerID'=>$managerID,
			':managerPW'=>password_hash($managerPW,PASSWORD_BCRYPT),
			':companyID'=>$companyID,
			':restID'=>$restID,
			':managerEmail'=>$managerEmail,
			':locked'=>0
			);
			
			$stmt=$this->conn->prepare("
			insert into manager(managerID,managerPW,companyID,restID,managerEmail,locked) values
			(:managerID,:managerPW,:companyID,:restID,:managerEmail,:locked)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCompany($companyID,$companyPW,$companyChiName,$companyEngName,$companyEmail,$locked)
		{
			$params=array(
			':companyID'=>$companyID,
			':companyPW'=>password_hash($companyPW,PASSWORD_BCRYPT),
			':companyChiName'=>$companyChiName,
			':companyEngName'=>$companyEngName,
			':companyEmail'=>$companyEmail,
			':locked'=>0
			);
			
			$stmt=$this->conn->prepare("
			insert into restcompany(companyID,companyPW,companyChiName,companyEngName,companyEmail,locked)
			values (:companyID,:companyPW,:companyChiName,:companyEngName,:companyEmail,:locked)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerWithName($custID,$custDevice,$custName,$custTel,$locked)
		{
			$params=array(
			':custID'=>$custID,
			':custDevice'=>password_hash($custDevice,PASSWORD_BCRYPT),
			':custName'=>$custName,
			':custTel'=>$custTel,
			':locked'=>0
			);
			
			$stmt=$this->conn->prepare("
			insert into customer(custID,custDevice,custName,custTel,locked)
			values (:custID,:custDevice,:custName,:custTel,:locked)");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createRestaurant($restID,$restPW,$companyID,$restChiName,$restEngName,$restAddress,$restAddressEng,$rgID,$printer,$restTel,$restEmail,$restPhoto,$restDesc,$restDescEng,$locked,$latitude,$longitude,$deliveryPrice)
		{
			$params=array(
			':restID'=>$restID,
			':restPW'=>$restPW,
			':companyID'=>$companyID,
			':restChiName'=>$restChiName,
			':restEngName'=>$restEngName,
			':restAddress'=>$restAddress,
			':restAddressEng'=>$restAddressEng,
			':printer'=>$printer,
			':restTel'=>$restTel,
			':restEmail'=>$restEmail,
			':restPhoto'=>$restPhoto,
			':restDesc'=>$restDesc,
			':restDesc'=>$restDescEng,
			':registeredDate'=>$this->today,
			':locked'=>$locked,
			':latitude'=>$latitude,
			':longitude'=>$longitude,
			':deliveryPrice'=>$deliveryPrice
			);
			
			$stmt=$this->conn->prepare("
			insert into restaurant(restID,companyID,restPW,restChiName,restEngName,restAddress,restAddressEng,rgID,printer,restTel,restEmail,restPhoto,restDesc,restDescEng,registeredDate,locked,latitude,longitude,deliveryPrice)
			values (:restID,:companyID,:restPW,:restChiName,:restEngName,:restAddress,:restAddressEng,:rgID,:printer,:restTel,:restEmail,:restPhoto,:restDesc,:restDescEng,:registeredDate,:locked,:latitude,:longitude,:deliveryPrice)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createAdminMessage($companyID,$message)
		{
			$params=array(
			':companyID'=>$companyID,
			':locked'=>$message
			);
			
			$stmt=$this->conn->prepare("
			insert into adminmessage(companyID,message) values 
			(:companyID,:message)"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerNoticeWithRestaurant($cNID,$custID,$adminID,$title,$titleEng,$description,$descriptionEng,$restID)
		{
			$params=array(
			':cNID'=>$cNID,
			':custID'=>$custID,
			':adminID'=>$adminID,
			':title'=>$title,
			':titleEng'=>$titleEng,
			':description'=>$description,
			':descriptionEng'=>$descriptionEng,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("
			insert into custnotice(cNID,custID,adminID,title,titleEng,description,descriptionEng,restID) values
			(:cNID,:custID,:adminID,:title,:titleEng,:description,:descriptionEng,:restID)"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createCustomerNoticeWithAdmin($cNID,$custID,$adminID,$title,$titleEng,$description,$descriptionEng)
		{
			$params=array(
			':cNID'=>$cNID,
			':custID'=>$custID,
			':adminID'=>$adminID,
			':title'=>$title,
			':titleEng'=>$titleEng,
			':description'=>$description,
			':descriptionEng'=>$descriptionEng
			);
			
			$stmt=$this->conn->prepare("
			insert into custnotice(cNID,custID,adminID,title,titleEng,description,descriptionEng) values
			(:cNID,:custID,:adminID,:title,:titleEng,:description,:descriptionEng)"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function createRestaurantNoticeWithAdmin($rNID,$companyID,$adminID,$title,$titleEng,$description,$descriptionEng)
		{
			$params=array(
			':rNID'=>$rNID,
			':companyID'=>$companyID,
			':adminID'=>$adminID,
			':title'=>$title,
			':titleEng'=>$titleEng,
			':description'=>$description,
			':descriptionEng'=>$descriptionEng
			);
			
			$stmt=$this->conn->prepare("
			insert into restnotice(rNID,companyID,adminID,title,titleEng,description,descriptionEng) values
			(:rNID,:companyID,:adminID,:title,:titleEng,:description,:descriptionEng)"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateTable($tableID)
		{
			$params=array(
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("update resttable set 
			tableLock=0 where 
			tableID=:tableID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateOrderFoodPrice($foodSubPrice,$orderNo)
		{
			$params=array(
			':foodSubPrice'=>$foodSubPrice,
			':orderNo'=>$orderNo
			);
			
			$stmt=$this->conn->prepare("update orderfood set 
			foodSubPrice=:foodSubPrice where 
			orderNo=:orderNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateSetOrderPrice($setSubPrice,$setOrderNo)
		{
			$params=array(
			':setSubPrice'=>$setSubPrice,
			':setOrderNo'=>$setOrderNo
			);
			
			$stmt=$this->conn->prepare("update setorder set 
			setSubPrice=:setSubPrice where
			setOrderNo=:setOrderNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateInvoicePrice($totalCost,$foodTotalCost,$invoiceID)
		{
			$params=array(
			':totalCost'=>$totalCost,
			':foodTotalCost'=>$foodTotalCost,
			':invoiceID'=>$invoiceID
			);
			
			$stmt=$this->conn->prepare("update invoice set 
			totalCost=:totalCost,
			foodTotalCost=:foodTotalCost where
			invoiceID=:invoiceID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCustomerAddress($address,$cAddressNo)
		{
			$params=array(
			':address'=>$address,
			':cAddressNo'=>$cAddressNo
			);
			
			$stmt=$this->conn->prepare("update custaddress set 
			address=:address where 
			cAddressNo=:cAddressNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateRestaurantTableLock($tableID)
		{
			$params=array(
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("update resttable set
			tableLock=1 where
			tableID=:tableID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCustomerDeviceWithOldPhone($custDevice,$phoneNo,$oldPhone)
		{
			$params=array(
			':custDevice'=>password_hash($custDevice, PASSWORD_BCRYPT),
			':phoneNo'=>$phoneNo,
			':oldPhone'=>$oldPhone
			);
			
			$stmt=$this->conn->prepare("update customer set 
			custDevice=:custDevice,
			custTel=:phoneNo where
			custTel=:oldPhone");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCustomerDevice($custDevice,$custID)
		{
			$params=array(
			':custDevice'=>password_hash($custDevice, PASSWORD_BCRYPT),
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("update customer set
			custDevice=:custDevice where
			custID=:custID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCustomerName($custName,$custID)
		{
			$params=array(
			':custName'=>$custName,
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("update customer set 
			custName=:custName where
			custID=:custID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateManager($managerPW,$managerEmail,$managerID)
		{
			$params=array(
			':managerPW'=>$managerPW,
			':managerEmail'=>$managerEmail,
			':managerEmail'=>$managerID
			);
			
			$stmt=$this->conn->prepare("update manager set
			managerPW=:managerPW,
			managerEmail=:managerEmail where
			managerID=:managerID"); 
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCharge($chargeID,$charge,$hide,$detailChi,$detailEng,$orderIn)
		{
			$params=array(
			':chargeID'=>$chargeID,
			':charge'=>$charge,
			':hide'=>$hide,
			':detailChi'=>$detailChi,
			':detailEng'=>$detailEng,
			':orderIn'=>$orderIn
			);
			
			$stmt=$this->conn->prepare("
			update charge set 
			charge=:charge,
			detailChi=:detailChi,
			detailEng=:detailEng,
			hide=:hide,
			orderIn=:orderIn where
			chargeID=:chargeID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateOptionAllow($oaID,$optID,$foodID)
		{
			$params=array(
			':oaID'=>$oaID,
			':optID'=>$optID,
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("
			update optionallow set 
			optID=:optID,
			foodID=:foodID where
			oaID=:oaID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateRestaurant($latitude,$longitude,$deliveryPrice,$restPW,$restChiName,$restEngName,$restAddress,$restAddressEng,$rgID,$printer,$restTel,$restEmail,$restPhoto,$restDesc,$restDescEng,$locked,$restID)
		{
			$params=array(
			':latitude'=>$latitude,
			':longitude'=>$longitude,
			':deliveryPrice'=>$deliveryPrice,
			':restPW'=>$restPW,
			':restChiName'=>$restChiName,
			':restEngName'=>$restEngName,
			':restAddress'=>$restAddress,
			':restAddressEng'=>$restAddressEng,
			':printer'=>$printer,
			':restTel'=>$restTel,
			':restEmail'=>$restEmail,
			':restPhoto'=>$restPhoto,
			':restDesc'=>$restDesc,
			':restDescEng'=>$restDescEng,
			':locked'=>$locked,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("
			update restaurant set 
			latitude=:latitude,
			longitude=:longitude,
			deliveryPrice=:deliveryPrice,
			restPw=':restPW,
			restChiName=':restChiName,
			restEngName=':restEngName,
			restAddress=':restAddress,
			restAddressEng=':restAddressEng,
			rgID=':rgID,
			printer=':printer,
			restTel=':restTel,
			restEmail=':restEmail,
			restPhoto=':restPhoto,
			restDesc=':restDesc,
			restDescEng=':restDescEng,
			locked=:locked where 
			restID=':restID"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateSetItemPrice($setItemPrice,$setID)
		{
			$params=array(
			':setItemPrice'=>$setItemPrice,
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("
			update setitem set
			totalPrice=:setItemPrice where
			setID=:setID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateSetItem($available,$groupNo,$setChiName,$setEngName,$totalPrice,$setPhoto,$setDesc,$setDescEng,$setTakeout,$managerID,$setID)
		{
			$params=array(
			':available'=>$available,
			':groupNo'=>$groupNo,
			':setChiName'=>$setChiName,
			':setEngName'=>$setEngName,
			':totalPrice'=>$totalPrice,
			':setPhoto'=>$setPhoto,
			':setDesc'=>$setDesc,
			':setDescEng'=>$setDescEng,
			':setTakeout'=>$setTakeout,
			':managerID'=>$managerID,
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("
			update setitem set
			available=:available,
			groupNo=:groupNo,
			setChiName=:setChiName,
			setEngName=:setEngName,
			totalPrice=:totalPrice,
			setPhoto=:setPhoto,
			setDesc=:setDesc,
			setDescEng=:setDescEng,
			setTakeout=:setTakeout,
			managerID=:managerID where 
			setID=:setID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateSetTitle($setID,$titleName,$titleEng,$count,$titleNo)
		{
			$params=array(
			':setID'=>$setID,
			':titleName'=>$titleName,
			':titleEng'=>$titleEng,
			':count'=>$count,
			':titleNo'=>$titleNo
			);
			
			$stmt=$this->conn->prepare("
			update settitle set 
			setID=:setID,
			title=:titleName,
			titleEng=:titleEng,
			count=:count where 
			titleNo=:titleNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateSetFood($setID,$foodID,$titleNo,$extraPrice,$foodNo)
		{
			$params=array(
			':setID'=>$setID,
			':foodID'=>$foodID,
			':titleNo'=>$titleNo,
			':extraPrice'=>$extraPrice,
			':foodNo'=>$foodNo
			);
			
			$stmt=$this->conn->prepare("
			update setfood set
			setID=:setID,
			foodID=:foodID,
			titleNo=:titleNo,
			extraPrice=:extraPrice where
			foodNo=:foodNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateFood($available,$groupNo,$foodChiName,$foodEngName,$foodPrice,$foodPhoto,$foodDesc,$foodDescEng,$foodTakeout,$managerID,$foodID)
		{
			$params=array(
			':available'=>$available,
			':groupNo'=>$groupNo,
			':foodChiName'=>$foodChiName,
			':foodEngName'=>$foodEngName,
			':foodPrice'=>$foodPrice,
			':foodPhoto'=>$foodPhoto,
			':foodDesc'=>$foodDesc,
			':foodDescEng'=>$foodDescEng,
			':foodTakeout'=>$foodTakeout,
			':managerID'=>$managerID,
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("
			update food set 
			available=:available,
			groupNo=:groupNo,
			foodChiName=:foodChiName,
			foodEngName=:foodEngName,
			foodPrice=:foodPrice,
			foodDescEng=:foodDescEng,
			foodTakeout=:foodTakeout,
			foodPhoto=:foodPhoto,
			foodDesc=:foodDesc,
			managerID=:managerID where 
			foodID=:foodID"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateMenugroup($restID,$groupNo,$groupChiName,$groupEngName,$startTime,$openHour,$showDay,$managerID)
		{
			$params=array(
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':groupChiName'=>$groupChiName,
			':groupEngName'=>$groupEngName,
			':startTime'=>$startTime,
			':openHour'=>$openHour,
			':showDay'=>$showDay,
			':managerID'=>$managerID,
			':lastModify'=>$this->today
			);
			
			$stmt=$this->conn->prepare("
			update menugroup set
			groupChiName=:groupChiName,
			groupEngName=:groupEngName,
			startTime=:startTime,
			openHour=:openHour,
			showDay=:showDay,
			managerID=:managerID,
			lastModify=:lastModify where 
			restID=:restID and 
			groupNo=:groupNo"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateMenugroupItemOfFood($itemNo,$restID,$groupNo,$foodID,$widgetID,$rowNumber,$columnNumber,$color)
		{
			$params=array(
			':itemNo'=>$itemNo,
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':foodID'=>$foodID,
			':widgetID'=>$widgetID,
			':rowNumber'=>$rowNumber,
			':columnNumber'=>$columnNumber,
			':color'=>$color
			);
			
			$stmt=$this->conn->prepare("
			update menugroupitem set
			color=:color,
			restID=:restID,
			groupNo=:groupNo,
			foodID=:foodID,
			widgetID=:widgetID,
			rowNumber=:rowNumber,
			columnNumber=:columnNumber where 
			itemNo=:itemNo"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateMenugroupItemOfSet($itemNo,$restID,$groupNo,$setID,$widgetID,$rowNumber,$columnNumber,$color)
		{
			$params=array(
			':itemNo'=>$itemNo,
			':restID'=>$restID,
			':groupNo'=>$groupNo,
			':setID'=>$setID,
			':widgetID'=>$widgetID,
			':rowNumber'=>$rowNumber,
			':columnNumber'=>$columnNumber,
			':color'=>$color
			);
			
			$stmt=$this->conn->prepare("
			update menugroupitem set
			color=:color,
			restID=:restID,
			groupNo=:groupNo,
			setID=:setID,
			widgetID=:widgetID,
			rowNumber=:rowNumber,
			columnNumber=:columnNumber where 
			itemNo=:itemNo"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateTableFloorPlan($restID,$floor,$sizeX,$sizeY,$managerID)
		{
			$params=array(
			':restID'=>$restID,
			':floor'=>$floor,
			':sizeX'=>$sizeX,
			':sizeY'=>$sizeY,
			':managerID'=>$managerID,
			':lastModify'=>$this->today
			);
			
			$stmt=$this->conn->prepare("
			update tablefloorplan set
			sizeX=:sizeX,
			sizeY=:sizeY,
			managerID=:managerID,
			lastModify=:lastModify where
			restID=:restID and
			floor=:floor"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateRestaurantTable($tableID,$tableNo,$restID,$floor,$posX,$posY,$maxNo,$width,$height)
		{
			$params=array(
			':tableID'=>$tableID,
			':tableNo'=>$tableNo,
			':restID'=>$restID,
			':floor'=>$floor,
			':posX'=>$posX,
			':posY'=>$posY,
			':maxNo'=>$maxNo,
			':width'=>$width,
			':height'=>$height
			);
			
			$stmt=$this->conn->prepare("
			update resttable set 
			width=:width,
			height=:height,
			tableNo=:tableNo,
			restID=:restID,
			floor=:floor',
			posX=:posX,
			posY=:posY,
			maxNo=:maxNo where
			tableID=:tableID"); 

			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateSetItemAvailable($available,$setID)
		{
			$params=array(
			':available'=>$available,
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("
			update setitem set 
			available=:available where
			setID=:setID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateFoodAvailable($available,$foodID)
		{
			$params=array(
			':available'=>$available,
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("
			update food set 
			available=:available where
			foodID=:foodID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCompany($companyPW,$companyChiName,$companyEngName,$companyEmail,$companyID)
		{
			$params=array(
			':companyPW'=>$companyPW,
			':companyChiName'=>$companyChiName,
			':companyEngName'=>$companyEngName,
			':companyEmail'=>$companyEmail,
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("
			update restcompany set 
			companyPW=:companyPW,
			companyChiName=:companyChiName,
			companyEngName=:companyEngName,
			companyEmail=:companyEmail where 
			companyID=:companyID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateManagerByCompany($managerPW,$restID,$managerEmail,$locked,$managerID)
		{
			$params=array(
			':managerPW'=>$managerPW,
			':restID'=>$restID,
			':managerEmail'=>$managerEmail,
			':locked'=>$locked,
			':managerID'=>$managerID
			);
			
			$stmt=$this->conn->prepare("
			update manager set 
			managerPW=:managerPW,
			restID=:restID,
			managerEmail=:managerEmail,
			locked=:locked where
			managerID=:managerID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateRestaurantLock($locked,$restID)
		{
			$params=array(
			':locked'=>$locked,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("
			update restaurant set 
			locked=:locked where 
			restID=:restID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCompanyLock($locked,$companyID)
		{
			$params=array(
			':locked'=>$locked,
			':companyID'=>$companyID
			);
			
			$stmt=$this->conn->prepare("
			update restcompany set 
			locked=:locked where 
			companyID=:companyID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateCustomerLock($locked,$custID)
		{
			$params=array(
			':locked'=>$locked,
			':custID'=>$custID
			);
			
			$stmt=$this->conn->prepare("
			update customer set 
			locked=:locked where 
			custID=:custID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function updateAdmin($password,$userName,$adminID)
		{
			$params=array(
			':password'=>$password,
			':userName'=>$userName,
			':adminID'=>$adminID
			);
			
			$stmt=$this->conn->prepare("
			update admin set 
			password=:password,
			userName=:userName where 
			adminID=:adminID"); 


			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteSmsByPhone($phone)
		{
			$params=array(
			':phone'=>$phone
			);
			
			$stmt=$this->conn->prepare("delete from sms where 
			phone=:phone");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteFavouriteRestaurant($custID,$restID)
		{
			$params=array(
			':custID'=>$custID,
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("delete from favouriteorderoption where 
			ffID in (select ffID from favouritefood where custID=:custID and restID=:restID)");
			$result=$stmt->execute($params);
			
			$stmt=$this->conn->prepare("delete from favouritefood where 
			custID=:custID and restID=:restID");
			$result=$stmt->execute($params);
			
			$stmt=$this->conn->prepare("delete from favouritechoiceoption where
			fscID in (select fscID from favouritesetchoice where
			fsID in (select fsID from favouriteset where
			custID=:custID and restID=:restID)
			)");
			$result=$stmt->execute($params);
			
			$stmt=$this->conn->prepare("delete from favouritesetchoice where
			fsID in (select fsID from favouriteset where 
			custID=:custID and restID=:restID)");
			$result=$stmt->execute($params);
			
			$stmt=$this->conn->prepare("delete from favouriteset where 
			custID=:custID and restID=:restID");
			$result=$stmt->execute($params);
			
			$stmt=$this->conn->prepare("delete from favourite where 
			custID=:custID and restID=:restID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteFavouriteFood($foodID)
		{
			$params=array(
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("delete from favouriteorderoption where
			ffID in (select ffID from favouritefood where
			foodID=:foodID)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritefood where 
			foodID=:foodID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteFavouriteSet($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("delete from favouritechoiceoption where 
			fscID in (select fscID from favouritesetchoice where 
			fsID in (select fsID from favouriteset where 
			setID=:setID)
			)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritesetchoice where 
			fsID in (select fsID from favouriteset where
			setID=:setID)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouriteset where
			setID=:setID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteCustomerAddress($cAddressNo)
		{
			$params=array(
			':cAddressNo'=>$cAddressNo
			);
			
			$stmt=$this->conn->prepare("delete from custaddress where 
			cAddressNo=:cAddressNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteCharge($chargeID)
		{
			$params=array(
			':chargeID'=>$chargeID
			);
			
			$stmt=$this->conn->prepare("delete from charge where
			chargeID=:chargeID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteOptionAllow($oaID)
		{
			$params=array(
			':oaID'=>$oaID
			);
			
			$stmt=$this->conn->prepare("delete optionallow where 
			oaID=:oaID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteRestaurantCode($restID)
		{
			$params=array(
			':restID'=>$restID
			);
			
			$stmt=$this->conn->prepare("update restaurant set 
			qrcode=null where 
			restID=:restID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteRestaurantTableCode($tableID)
		{
			$params=array(
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("update resttable set 
			qrcode=null where 
			tableID=:tableID");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteSetItem($setID)
		{
			$params=array(
			':setID'=>$setID
			);
			
			$stmt=$this->conn->prepare("delete from favouritechoiceoption where 
			fscID in (select fscID from favouritesetchoice where 
			foodNo in (select foodNo from setfood where 
			setID=setID)
			)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritesetchoice where 
			foodNo in (select foodNo from setfood where 
			setID=setID)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from setfood where 
			setID=setID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from settitle where 
			setID=setID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from menugroupitem where
			setID=setID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritechoiceoption where 
			fscID in (select fscID from favouritesetchoice where
			fsID in (select fsID from favouriteset where
			setID=setID)
			)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritesetchoice where
			fsID in (select fsID from favouriteset where
			setID=setID)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouriteset where
			setID=setID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from setitem where 
			setID=setID");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteFood($foodID)
		{
			$params=array(
			':foodID'=>$foodID
			);
			
			$stmt=$this->conn->prepare("delete from menugroupitem where 
			foodID=:foodID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from optionallow where 
			foodID=:foodID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouriteorderoption where
			ffID in (select ffID from favouritefood where 
			foodID=:foodID)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from setfood where
			foodID=:foodID");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from food where 
			foodID=:foodID");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteSetFood($foodNo)
		{
			$params=array(
			':foodNo'=>$foodNo
			);
			
			$stmt=$this->conn->prepare("delete from favouritechoiceoption where 
			fscID in (select fscID from favouritesetchoice where
			foodNo=:foodNo)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritesetchoice where 
			foodNo=:foodNo");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from setfood where
			foodNo=:foodNo");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteSetTitle($titleNo)
		{
			$params=array(
			':titleNo'=>$titleNo
			);
			
			$stmt=$this->conn->prepare("delete from favouritechoiceoption where 
			fscID in (select fscID from favouritesetchoice where
			foodNo in (select foodNo from setfood where
			titleNo=:titleNo))");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from favouritesetchoice where 
			foodNo in (select foodNo from setfood where
			titleNo=:titleNo)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from setfood where 
			titleNo=:titleNo");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from settitle where 
			titleNo=:titleNo");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteMenugroupItem($itemNo,$restID,$groupNo)
		{
			$params=array(
			':itemNo'=>$itemNo,
			':restID'=>$restID,
			':groupNo'=>$groupNo
			);
			
			$stmt=$this->conn->prepare("delete from menugroupitem where 
			itemNo=:itemNo and
			restID=:restID and 
			groupNo=:groupNo");
			$result=$stmt->execute($params);
			
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteMenugroup($restID,$groupNo)
		{
			$params=array(
			':restID'=>$restID,
			':groupNo'=>$groupNo
			);
			
			$stmt=$this->conn->prepare("delete from menugroupitem where 
			restID=:restID and
			groupNo=:groupNo");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from menugroup where 
			restID=:restID and 
			groupNo=:groupNo");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteTableFloor($restID,$floor)
		{
			$params=array(
			':restID'=>$restID,
			':floor'=>$floor
			);
			
			$stmt=$this->conn->prepare("delete from resttable where 
			tableID in (select tableID from tablefloorplan where
			restID=:restID and
			floor=:floor)");
			$result=$stmt->execute($params);
			$stmt=$this->conn->prepare("delete from tablefloorplan where
			restID=:restID and 
			floor=:floor");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteRestaurantTable($tableID)
		{
			$params=array(
			':tableID'=>$tableID
			);
			
			$stmt=$this->conn->prepare("delete from resttable where 
			tableID=:tableID");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteManager($managerID)
		{
			$params=array(
			':managerID'=>$managerID
			);
			
			$stmt=$this->conn->prepare("delete from manager where
			managerID=:managerID");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteRestaurantNotice($rNID)
		{
			$params=array(
			':rNID'=>$rNID
			);
			
			$stmt=$this->conn->prepare("delete from restnotice where
			rNID=:rNID");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
		
		public function deleteCustomerNotice($cNID)
		{
			$params=array(
			':cNID'=>$cNID
			);
			
			$stmt=$this->conn->prepare("delete from custnotice where
			cNID=:cNID");
			$result=$stmt->execute($params);
			if($result){
				return true;
				}else{
				return false;
			}
		}
	}
?>