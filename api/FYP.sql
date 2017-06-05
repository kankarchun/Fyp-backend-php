
SET storage_engine = InnoDB;

-- Create and use database
drop database IF EXISTS fypdb;
create database fypdb character set utf8;
use fypdb; 

ALTER DATABASE fypdb CHARACTER SET utf8 COLLATE utf8_unicode_ci;


-- Create table
drop table IF EXISTS Admin;

CREATE TABLE Admin (
	
	adminID VARCHAR(255) NOT NULL,
	
	userName VARCHAR(255) NOT NULL,
	
	password VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (adminID)
)
ENGINE = InnoDB;

drop table IF EXISTS AdminMessage;

CREATE TABLE AdminMessage (
	
	messageID int(11) NOT NULL AUTO_INCREMENT,
	
	companyID VARCHAR(255) NOT NULL,
	
	message VARCHAR(255) NOT NULL,
		
	PRIMARY KEY (messageID),
	FOREIGN KEY (companyID)
    REFERENCES RestCompany (companyID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS RestCompany ;

CREATE TABLE RestCompany (
	
	companyID VARCHAR(255) NOT NULL,
	companyPW VARCHAR(255) NOT NULL,
	companyChiName VARCHAR(255) NOT NULL,
	companyEngName VARCHAR(255) NOT NULL,
	companyEmail VARCHAR(255) NOT NULL,
	locked BIT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (companyID)
)
ENGINE = InnoDB;


DROP TABLE IF EXISTS RestNotice;

CREATE TABLE RestNotice (
	
	rNID VARCHAR(255) NOT NULL,
	
	companyID VARCHAR(255) NOT NULL,
	
	adminID VARCHAR(255) NOT NULL,
	
	title VARCHAR(255) NOT NULL,
	
	description varchar(255) NOT NULL,
	
	dateTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	
	PRIMARY KEY (rNID),
	
	FOREIGN KEY (companyID)
    REFERENCES RestCompany (companyID),
	FOREIGN KEY (adminID)
    REFERENCES Admin (adminID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Region ;

CREATE TABLE Region (
	
	rgID VARCHAR(255) NOT NULL,
	
	rgChiName VARCHAR(255) NOT NULL,
	
	rgEngName VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (rgID)
	
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Restaurant ;

CREATE TABLE Restaurant (
	
	restID VARCHAR(255) NOT NULL,
	
	companyID VARCHAR(255) NOT NULL,
	
	restPW VARCHAR(255) NOT NULL,
	
	restChiName VARCHAR(255) NOT NULL,
	
	restEngName VARCHAR(255) NOT NULL,
	
	restAddress VARCHAR(255) NOT NULL,
	
	restAddressEng VARCHAR(255) NOT NULL,
	
	rgID VARCHAR(255) NOT NULL,
	
	printer VARCHAR(255) NOT NULL,
	
	restTel VARCHAR(255) NOT NULL,
	
	restEmail VARCHAR(255) NOT NULL,
	
	restPhoto VARCHAR(255) NOT NULL,
	
	restDesc VARCHAR(255) NOT NULL,
	
	restDescEng VARCHAR(255) NOT NULL,
	
	registeredDate DATETIME DEFAULT NULL,
	
	locked BIT(1) NOT NULL DEFAULT 0,
	
	qrCode VARCHAR(255),
	
	latitude double(10,7) not null,
	
	longitude double(10,7) not null,
	
	deliveryPrice double(10,1) not null,
	
	PRIMARY KEY (restID),
	FOREIGN KEY (companyID)
	REFERENCES RestCompany (companyID),
	FOREIGN KEY (rgID)
	REFERENCES Region (rgID)
	
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Manager ;

CREATE TABLE Manager (
	
	managerID VARCHAR(255) NOT NULL,
	
	managerPW VARCHAR(255) NOT NULL,
	
	companyID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	managerEmail VARCHAR(255) NOT NULL,
	
	locked BIT(1) NOT NULL DEFAULT 0,
	
	PRIMARY KEY (managerID),
	FOREIGN KEY (companyID)
	REFERENCES RestCompany (companyID),
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS TableFloorPlan ;


CREATE TABLE TableFloorPlan (
	
	restID VARCHAR(255) NOT NULL,
	
	floor CHAR(20) NOT NULL,
	
	sizeX INT(255) NOT NULL,
	
	sizeY INT(255) NOT NULL,
	
	managerID VARCHAR(255) NOT NULL,
	
	lastModify DATETIME NOT NULL,
	
	PRIMARY KEY (restID,floor),
	
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID),
	FOREIGN KEY (managerID)
	REFERENCES Manager (managerID)
	
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS RestTable ;

CREATE TABLE RestTable (
	
	tableID VARCHAR(255) NOT NULL,
	
	tableNo INT(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	floor CHAR(1) NOT NULL,
	
	posX INT(255) NOT NULL,
	
	posY INT(255) NOT NULL,
	
	width int(11) not null,
	
	height int(11) not null,
	
	maxNo INT(255) NOT NULL,
	
	qrCode varchar(255),
	
	tableLock bit(1) not null default 0,
	
	UNIQUE (posX,posY),
	
	PRIMARY KEY (tableID),
	
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID),
	FOREIGN KEY (restID,floor)
	REFERENCES TableFloorPlan (restID,floor)
	
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS MenuGroup ;

CREATE TABLE MenuGroup (
	
	restID VARCHAR(255) NOT NULL,
	
	groupNo INT(255) NOT NULL,
	
	groupChiName VARCHAR(255) NOT NULL,
	
	groupEngName VARCHAR(255) NOT NULL,
	
	startTime time NOT NULL,
	
	openHour double(10,3) NOT NULL,
	
	showDay VARCHAR(255) NOT NULL,
	
	managerID VARCHAR(255) NOT NULL,
	
	lastModify dateTime NOT NULL,
	
	PRIMARY KEY (restID,groupNo),
	
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID),
	FOREIGN KEY (managerID)
	REFERENCES Manager (managerID)
	
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS MenuWidget ;

CREATE TABLE MenuWidget (
	
	widgetID VARCHAR(255) NOT NULL,
	
	showPhotos BIT(1) NOT NULL DEFAULT 0,
	
	rowSpan int(11) NOT NULL,
	
	colSpan int(11) NOT NULL,
	
	PRIMARY KEY (widgetID)
	
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS SetItem ;

CREATE TABLE SetItem (
	
	setID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	groupNo int(255),
	
	setChiName VARCHAR(255) NOT NULL,
	
	setEngName VARCHAR(255) not null,
	
	totalPrice double(10,3) default 0,
	
	setPhoto VARCHAR(255),
	
	setDesc VARCHAR(255),
	
	setDescEng VARCHAR(255),
	
	setTakeout BIT(1) NOT NULL default 0,
	
	managerID VARCHAR(255) NOT NULL,
	
	available bit(1) not null default 0,
	
	PRIMARY KEY (setID),
	
	FOREIGN KEY (restID,groupNo)
	REFERENCES MenuGroup (restID,groupNo),
	FOREIGN KEY (managerID)
	REFERENCES Manager (managerID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS SpecialOption ;

CREATE TABLE SpecialOption (
	
	optID VARCHAR(255) NOT NULL,
	
	contentChi VARCHAR(255) NOT NULL,
	
	contentEng VARCHAR(255) NOT NULL,
	
	extraPrice double(10,3) not null,
	
	PRIMARY KEY (optID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Food ;

CREATE TABLE Food (
	
	foodID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	groupNo int(255),
	
	foodChiName VARCHAR(255) NOT NULL,
	
	foodEngName VARCHAR(255) NOT NULL,
	
	foodPrice double(10,3) NOT NULL,
	
	foodPhoto VARCHAR(255) default 0,
	
	foodDesc VARCHAR(255),
	
	foodDescEng VARCHAR(255),
	
	foodTakeout BIT(1) NOT NULL,
	
	managerID VARCHAR(255) NOT NULL,
	
	available bit(1) not null default 0,
	
	PRIMARY KEY (foodID),
	
	FOREIGN KEY (restID,groupNo)
	REFERENCES MenuGroup (restID,groupNo),
	FOREIGN KEY (managerID)
	REFERENCES Manager (managerID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS OptionAllow ;

CREATE TABLE OptionAllow (
	
	oaID VARCHAR(255) NOT NULL,
	
	optID VARCHAR(255) NOT NULL,
	
	foodID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (oaID,foodID),
	
	FOREIGN KEY (optID)
	REFERENCES SpecialOption (optID),
	FOREIGN KEY (foodID)
	REFERENCES Food (foodID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS SetFood ;

CREATE TABLE SetFood (
	
	foodNo INT(255) NOT NULL,
	
	setID VARCHAR(255) NOT NULL,
	
	foodID VARCHAR(255) NOT NULL,
	
	titleNo int(11) not null,
	
	extraPrice double(10,3) NOT null default 0,
	
	PRIMARY KEY (foodNo),
	
	FOREIGN KEY (setID,titleNo)
	REFERENCES SetTitle (setID,titleNo),
	FOREIGN KEY (foodID)
	REFERENCES Food (foodID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS MenuGroupItem ;

CREATE TABLE MenuGroupItem (
	
	itemNo VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	groupNo INT(255) NOT NULL,
	
	foodID VARCHAR(255),
	
	setID VARCHAR(255),
	
	widgetID VARCHAR(255) NOT NULL,
	
	rowNumber INT(255) NOT NULL,
	
	columnNumber INT(255) NOT NULL,
	
	color varchar(255) not null default "#FFFFFF",
	
	unique(groupNo,rowNumber,columnNumber),
	
	PRIMARY KEY (itemNo,restID,groupNo),
	
	FOREIGN KEY (restID,groupNo)
	REFERENCES MenuGroup (restID,groupNo),
	FOREIGN KEY (foodID)
	REFERENCES Food (foodID),
	FOREIGN KEY (setID)
	REFERENCES SetItem (setID),
	FOREIGN KEY (widgetID)
	REFERENCES MenuWidget (widgetID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Charge ;

CREATE TABLE Charge (
	
	chargeID VARCHAR(255) NOT NULL,
	
	restID varchar(255) not null,
	
	charge VARCHAR(255) NOT NULL,
	
	detailChi VARCHAR(255) not null,
	
	detailEng VARCHAR(255) not null,
	
	hide BIT(1) not null default 0,
	
	orderIn int(11) not null,
	
	unique(restID,orderIn),
	
	PRIMARY KEY (chargeID),
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Customer ;

CREATE TABLE Customer (
	
	custID VARCHAR(255) NOT NULL,
	
	custDevice VARCHAR(255) NOT NULL,
	
	custName VARCHAR(255),
	
	custTel VARCHAR(255) not null,
	
	locked BIT(1) not null default 0,
	
	registeredDate TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	
	unique(custDevice,custTel),
	
	PRIMARY KEY (custID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS ControlLog ;

CREATE TABLE ControlLog (
	
	logID INT(255) NOT NULL AUTO_INCREMENT,
	adminID VARCHAR(255) NOT NULL,
	changeDateTime DATETIME NOT NULL,
	title VARCHAR(255) NOT NULL,
	custID VARCHAR(255),
	companyID VARCHAR(255),
	PRIMARY KEY (logID),
	
	FOREIGN KEY (adminID)
    REFERENCES Admin (adminID),
	FOREIGN KEY (custID)
    REFERENCES Customer (custID),
	FOREIGN KEY (companyID)
    REFERENCES RestCompany (companyID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS CustAddress ;

CREATE TABLE CustAddress (
	
	cAddressNo int(255) NOT NULL,
	
	address VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (cAddressNo),
	
	FOREIGN KEY (custID)
	REFERENCES Customer (custID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS CustNotice ;

CREATE TABLE CustNotice (
	
	cNID VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	adminID VARCHAR(255),
	
	restID varchar(255),
	
	title VARCHAR(255) NOT NULL,
	
	titleEng VARCHAR(255) NOT NULL,
	
	description VARCHAR(255) NOT NULL,
	
	descriptionEng VARCHAR(255) NOT NULL,
	
	dateTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
	
	PRIMARY KEY (cNID),
	
	FOREIGN KEY (custID)
	REFERENCES Customer (custID),
	FOREIGN KEY (adminID)
	REFERENCES Admin (adminID),
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS CustReport ;

CREATE TABLE CustReport (
	
	reportID VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	custComment VARCHAR(255) NOT NULL,
	
	managerID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (reportID),
	
	FOREIGN KEY (custID)
	REFERENCES Customer (custID),
	FOREIGN KEY (managerID)
	REFERENCES Manager (managerID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Favourite ;

CREATE TABLE Favourite (
	
	custID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (custID,restID),
	
	FOREIGN KEY (custID)
	REFERENCES Customer (custID),
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS FavouriteFood ;

CREATE TABLE FavouriteFood (
	
	ffID VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	foodID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (ffID),
	
	FOREIGN KEY (custID,restID)
	REFERENCES Favourite (custID,restID),
	FOREIGN KEY (foodID)
	REFERENCES Food (foodID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS FavouriteOrderOption ;

CREATE TABLE FavouriteOrderOption (
	
	fooNo VARCHAR(255) NOT NULL,
	
	ffID VARCHAR(255) NOT NULL,
	
	optID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (fooNo,ffID),
	
	FOREIGN KEY (ffID)
	REFERENCES FavouriteFood (ffID),
	FOREIGN KEY (optID)
	REFERENCES SpecialOption (optID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS FavouriteSet ;

CREATE TABLE FavouriteSet (
	
	fsID VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	setID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (fsID,custID),
	
	FOREIGN KEY (custID,restID)
	REFERENCES Favourite (custID,restID),
	FOREIGN KEY (setID)
	REFERENCES SetItem (setID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS FavouriteSetChoice ;

CREATE TABLE FavouriteSetChoice (
	
	fscID VARCHAR(255) NOT NULL,
	
	fsID VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	foodNo INT(255) NOT NULL,
	
	quantity int(11) not null,
	
	PRIMARY KEY (fscID),
	
	FOREIGN KEY (fsID,custID)
	REFERENCES FavouriteSet (fsID,custID),
	FOREIGN KEY (foodNo)
	REFERENCES SetFood (foodNo)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS FavouriteChoiceOption ;

CREATE TABLE FavouriteChoiceOption (
	
	fcoNo INT(255) NOT NULL,
	
	fscID VARCHAR(255) NOT NULL,
	
	optID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (fcoNo,fscID),
	
	FOREIGN KEY (fscID)
	REFERENCES FavouriteSetChoice (fscID),
	FOREIGN KEY (optID)
	REFERENCES SpecialOption (optID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Invoice ;

CREATE TABLE Invoice (
	
	invoiceID VARCHAR(255) NOT NULL,
	
	restID VARCHAR(255) NOT NULL,
	
	custID VARCHAR(255) NOT NULL,
	
	tableID VARCHAR(255),
	
	takeoutID VARCHAR(255),
	
	totalCost double(10,3) NOT NULL default 0,
	
	foodTotalCost double(10,1) not null,
	
	orderDateTime dateTime,
	
	PRIMARY KEY (invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Takeout ;

CREATE TABLE Takeout (
	
	takeoutID VARCHAR(255) NOT NULL,
	
	takeoutNo INT(11) ,
	
	address VARCHAR(255),
	
	invoiceID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (takeoutID,invoiceID),
	
	FOREIGN KEY (invoiceID)
	REFERENCES Invoice (invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS InvoiceCharge ;

CREATE TABLE InvoiceCharge (
	
	iChargeNo VARCHAR(255) NOT NULL,
	
	invoiceID VARCHAR(255) NOT NULL,
	
	detailChi VARCHAR(255) NOT NULL,
	
	detailEng VARCHAR(255) NOT NULL,
	
	charge VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (iChargeNo,invoiceID),
	
	FOREIGN KEY (invoiceID)
	REFERENCES Invoice (invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS OrderFood ;

CREATE TABLE OrderFood (
	
	orderNo VARCHAR(255) NOT NULL,
	
	invoiceID VARCHAR(255) NOT NULL,
	
	foodChiName VARCHAR(255) NOT NULL,
	
	foodEngName VARCHAR(255) NOT NULL,
	
	foodPrice VARCHAR(255) NOT NULL default 0,
	
	quantity int(255) not null,
	
	foodSubPrice double(10,3) not null,
	
	PRIMARY KEY (orderNo,invoiceID),
	
	FOREIGN KEY (invoiceID)
	REFERENCES Invoice (invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS OrderOption ;

CREATE TABLE OrderOption (
	
	optID VARCHAR(255) NOT NULL,
	
	orderNo VARCHAR(255) NOT NULL,
	
	invoiceID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (optID,orderNo,invoiceID),
	
	FOREIGN KEY (optID)
	REFERENCES SpecialOption (optID),
	FOREIGN KEY (orderNo,invoiceID)
	REFERENCES OrderFood (orderNo,invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS SetOrder ;

CREATE TABLE SetOrder (
	
	setOrderNo INT(255) NOT NULL,
	
	invoiceID VARCHAR(255) NOT NULL,
	
	setChiName VARCHAR(255) NOT NULL,
	
	setEngName VARCHAR(255) NOT NULL,
	
	setPrice double(10,3) NOT NULL default 0,
	
	quantity int(255) not null,
	
	setSubPrice double(10,3) not null,
	
	PRIMARY KEY (setOrderNo,invoiceID),
	
	FOREIGN KEY (invoiceID)
	REFERENCES Invoice (invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS SetOrderChoice ;

CREATE TABLE SetOrderChoice (
	
	setOrderChoiceNo INT(255) NOT NULL,
	
	setOrderNo INT(255) NOT NULL,
	
	invoiceID VARCHAR(255) NOT NULL,
	
	foodChiName VARCHAR(255) NOT NULL,
	
	foodEngName VARCHAR(255) NOT NULL,
	
	extraPrice double(10,3) NOT NULL default 0,
	
	quantity int(11) not null,
	
	extraSubPrice double(10,3) not null,
	
	PRIMARY KEY (setOrderChoiceNo,setOrderNo,invoiceID),
	
	FOREIGN KEY (setOrderNo,invoiceID)
	REFERENCES SetOrder (setOrderNo,invoiceID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS ChoiceOption ;

CREATE TABLE ChoiceOption (
	
	optID VARCHAR(255) NOT NULL,
	
	setOrderChoiceNo INT(255) NOT NULL,
	
	setOrderNo INT(255) NOT NULL,
	
	invoiceID VARCHAR(255) NOT NULL,
	
	PRIMARY KEY (optID,setOrderChoiceNo,setOrderNo,invoiceID),
	
	FOREIGN KEY (setOrderChoiceNo,setOrderNo,invoiceID)
	REFERENCES SetOrderChoice (setOrderChoiceNo,setOrderNo,invoiceID),
	FOREIGN KEY (optID)
	REFERENCES SpecialOption (optID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS AccessToken ;

CREATE TABLE AccessToken (
	
	tokenID int(11) NOT NULL AUTO_INCREMENT,
	
	token VARCHAR(255) NOT NULL,
	
	uid VARCHAR(255) NOT NULL,
	
	expireDate DATETIME NOT NULL,
	
	ip VARCHAR(255),
	
	thirdParty bit(1) not null default 0,
	
	PRIMARY KEY (tokenID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS sms ;

CREATE TABLE IF NOT EXISTS sms (
  id int(11) NOT NULL AUTO_INCREMENT,
  phone varchar(50) DEFAULT NULL,
  verifyCode int(11) DEFAULT NULL,
  verified bit(1) NOT NULL default 0,
  oldphone varchar(255),
  PRIMARY KEY (`id`)
) 
ENGINE = InnoDB;

DROP TABLE IF EXISTS SetTitle ;

CREATE TABLE SetTitle (
	
	titleNo int(11) NOT NULL AUTO_INCREMENT,
	
	setID varchar(255) not null,
	
	title VARCHAR(255) NOT NULL,
	
	titleEng varchar(255) not null,
	
	count int(11) NOT NULL,
	
	PRIMARY KEY (titleNo),
	FOREIGN KEY (setID)
	REFERENCES SetItem (setID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS Coupon ;

CREATE TABLE Coupon (
	
	couponID VARCHAR(255) NOT NULL,
	
	restID varchar(255) not null,
	
	coupon VARCHAR(255) NOT NULL,
	
	price double(10,3) not null,
	
	detailChi VARCHAR(255) not null,
	
	detailEng VARCHAR(255) not null,
	
	expireDateTime timestamp not null,
	
	PRIMARY KEY (couponID),
	FOREIGN KEY (restID)
	REFERENCES Restaurant (restID)
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS trigger_invoice ;

CREATE TABLE trigger_invoice (
	
	invoiceID varchar(255) not null
)
ENGINE = InnoDB;

DROP TABLE IF EXISTS thirdParty ;

CREATE TABLE thirdParty (
	
	partyID int(11) NOT NULL AUTO_INCREMENT,
	api_key varchar(255) not null,
	redirect_uri varchar(255) not null,
	secret varchar(255) not null,
	
	PRIMARY KEY (partyID)
)
ENGINE = InnoDB;

CREATE TRIGGER user_invoice before insert on invoice for each row insert into trigger_invoice value(new.invoiceID);
-- Insert testing data for table