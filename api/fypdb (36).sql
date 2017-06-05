-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2017 at 02:54 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.5.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

SET storage_engine = InnoDB;

-- Create and use database
drop database IF EXISTS fypdb;
create database fypdb character set utf8;
use fypdb; 

ALTER DATABASE fypdb CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Database: `fypdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesstoken`
--

CREATE TABLE `accesstoken` (
  `tokenID` int(11) NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expireDate` datetime NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `accesstoken`
--

INSERT INTO `accesstoken` (`tokenID`, `token`, `uid`, `expireDate`, `ip`) VALUES
(14, 'e52b6d2f45798e965d4b1d54e1222b9c', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(15, 'c91913bdac0ac3c12f82c58941c6d5d1', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(16, 'ba5d6c6ef4c42bd4e849e980ee332bf5', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(17, '9620e5a6b3c692c07e4ff3b786a0f3e0', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(18, 'd26992d5de0235ad713d0ffb5fcf1872', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(19, 'd178fe650c8858490786518a3a1577e6', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(20, '212fb27f9b6c93a9b54103d483ed806f', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(21, 'fc1acd18762d1908e4f5925268be6b5a', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(22, '5542564bb8b3dd33ecb6f9f1b00da80a', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(23, '2b76559151661a18dcefa986b53ce948', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(24, '9d87d233fad22513af5034d2a1d1a893', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(25, 'b04ef21c9f976de12b3823821c9d3c9e', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(26, 'e090e2bad9a549dca5973199d8ebb154', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(27, 'a2b175220b71284c47f0b4d3f7a70f35', 'R00001', '2016-12-23 00:00:00', NULL),
(28, '05a3bd890b346bf269f57d0982fb3193', 'R00001', '2016-12-23 00:00:00', NULL),
(29, 'b45497aeb94d6295598493a10f901248', 'R00001', '2016-12-23 00:00:00', NULL),
(30, '2ce016b0509deb78adf754412e56778e', 'R00001', '2016-12-23 00:00:00', NULL),
(31, '7433cf12abde08df1609f4f92720332f', 'R00001', '2016-12-23 00:00:00', NULL),
(32, '4a15e2dd4cfa1c68fb03479edbad8821', 'R00001', '2016-12-23 00:00:00', NULL),
(33, '779cc4ac5d19ca673d419c3f7626a4ed', 'R00001', '2016-12-23 00:00:00', NULL),
(34, '82895e57417396449f4546a4847e24a5', 'R00001', '2016-12-23 00:00:00', NULL),
(35, '1d137b6a5442e812bef95bc5c3bb28fd', 'R00001', '2016-12-23 00:00:00', NULL),
(36, '92e8b0cc5f455f14056ff99fae9b2bb0', 'R00001', '2016-12-23 00:00:00', NULL),
(37, '4d64c703218ba07d0f9b938cef3cc7d6', 'R00001', '2016-12-23 00:00:00', NULL),
(38, 'e85abd9c9b632fa80022dde5a41cd061', 'M00001', '2017-12-23 00:00:00', NULL),
(39, '63d9f2aa2bbf2478e52ed103b4a9b36e', 'R00001', '2016-12-23 00:00:00', NULL),
(40, 'a59a370f9539b6154c2598afc70d9872', 'R00001', '2016-12-23 00:00:00', NULL),
(41, '205bc2654562a000d8d2efd69c31b777', 'R00001', '2016-12-23 00:00:00', NULL),
(42, 'fbf8fa81364bc603303623932cdf2e62', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(43, '7644291c3072af6bb83969bc92e66a65', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(44, '8ec34b4e8c08b66be6ed556f1e5c0c8e', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(45, 'b798dfab8c3cbd916bf083f8a5b8b137', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(46, '9fab3d4bcd6ca6080b7c45873d2ba98b', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(47, 'd81b8b188401024b8ebdd0970c4443c1', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(48, '7a78d0acac3d375ada372a452c7682af', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(49, 'b701dbb9b885ef8f77dbcd3acf9a019c', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(50, 'ceca58ec37ab16fe4f7d5208dd018847', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(51, 'af4cd356c52b1d313d30c7b7688c6f67', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(52, 'e21303faf146f90db0c0a621048abf51', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(53, '584e417d33bdb7cc92b71cfa23b30a5c', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(54, '817d98c3ab884d51c171b01dbd698449', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(55, '3a969543d88f9fb2efac27565e5c5130', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(56, '4cefae05565c2b4c1a690fb145097037', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(57, '685a9d67cd4a399a776055daa3406aa8', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(58, 'f733bc8824c479584e8e2a4edf04aa12', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(59, 'f54a2403f05b7b4ae2a27f25244f547b', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(60, 'd527ec58c01a5d5ba408036de441d8cd', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(61, 'c169179bd81306569735c4ca92fb3ef7', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(62, '69bccfadc75180f1ec77fb71373c50e3', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(63, '3beac1a146cc135bb639846bc7bdec12', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(64, '831420ffa660b0634e749fb3ddaf22e9', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(65, 'b13b4bb5f7f2356b37af5c1ebedb6fa1', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(66, '0181db32938e29bb6ecea006ea85f104', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(67, '3d0e61b6f163ca91d3d055035a6f7534', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(68, '475d4ca7f44b7c3e402ab2d80320b91c', 'R00001', '2016-12-23 00:00:00', '127.0.0.1'),
(69, '3dd4ff30eebed98babbce4fc49dca3a1', 'R00001', '2016-12-24 00:00:00', '127.0.0.1'),
(70, '8d02b0d42d05675b13a3a127f86c4e30', 'R00001', '2016-12-24 00:00:00', '127.0.0.1'),
(71, 'dc98a93bd9f825e856453d779d74ef96', 'R00001', '2016-12-24 00:00:00', '127.0.0.1'),
(72, 'bd22c8ee33c1c17cfe861256b7ad8f17', 'R00001', '2016-12-24 00:00:00', '127.0.0.1'),
(73, '4066afe7a40e804ee6210dc79a22d4f0', 'A00000', '2016-12-26 00:00:00', NULL),
(74, '1d3773d4643f029f884060f4a45c11f4', 'A00000', '2016-12-26 00:00:00', NULL),
(75, '4b6d32a3d8b43d58a50656c1b274006d', 'A00000', '2016-12-26 00:00:00', NULL),
(76, '4c83d3f243c3cc9f3507fa60bd4ed815', 'A00000', '2016-12-26 00:00:00', NULL),
(77, '9e16ecd772ef3bf516fba64f9bfe293e', 'A00000', '2016-12-26 00:00:00', NULL),
(78, '8bee7aa0f1dbc80cfef48582a11821c3', 'A00000', '2016-12-26 00:00:00', NULL),
(79, 'd1215975b2a995538133353bcc9572e2', 'A00000', '2016-12-26 00:00:00', NULL),
(80, '0e2631501d257d65b4e2dc9360fb90a3', 'A00000', '2016-12-26 00:00:00', NULL),
(81, 'bacdc3a6ce262aba8e152ad0b4267dbe', 'A00000', '2016-12-26 00:00:00', NULL),
(82, '6722c682c7aaa9ebec8b45e779dd9d70', 'A00000', '2016-12-26 00:00:00', NULL),
(83, 'ded9819835d5180c3462c395cc7bba52', 'A00000', '2016-12-26 00:00:00', NULL),
(84, 'b2e26a8cf8d7cee1b7a01db47e65da6a', 'A00000', '2016-12-26 00:00:00', NULL),
(85, 'ba5226dfb4365f15a822cb68bc8170e3', 'A00000', '2016-12-26 00:00:00', '::1'),
(86, 'd606311d77f6de37fb760bef491e6a79', 'A00000', '2016-12-26 00:00:00', '::1'),
(87, '3c3ad1160de7c3fd8b90f75e219d2080', 'A00000', '2016-12-26 00:00:00', NULL),
(88, 'b9afb8c799749de77a1605fa093c4353', 'A00000', '2016-12-26 00:00:00', '::1'),
(89, '639e8b763220299e5c1b2e5700e9d542', 'A00000', '2016-12-26 00:00:00', '::1'),
(90, '987a2af9e41f780810a8641e84bb9488', 'A00000', '2016-12-26 00:00:00', '::1'),
(91, 'c7c554af136a365373eaa190568e5bdf', 'A00000', '2016-12-26 00:00:00', '::1'),
(92, '8cbfcdf1f33457d0a54405c104ca1e3e', 'A00000', '2016-12-26 00:00:00', '::1'),
(93, 'c41cadd03676ca8e4e8f3a47c82d874a', 'A00000', '2016-12-26 00:00:00', '::1'),
(94, '22c7a85678474ea2ed0a347e6c444560', 'A00000', '2016-12-26 00:00:00', '::1'),
(95, 'e92dbd3c385c635f5c61fa1feef5c5cd', 'A00000', '2016-12-26 00:00:00', '::1'),
(96, 'aae80b392864645313f750697947246d', 'A00000', '2016-12-26 00:00:00', '::1'),
(97, '8cfe412c37a2575b3a140ac26ead8ba6', 'A00000', '2016-12-26 00:00:00', '::1'),
(98, '659c563698716950132a4263a033f0cf', 'A00000', '2017-01-11 00:00:00', '::1'),
(99, '7cbc18f5f168889ea1b08d678ead4e79', 'R00001', '2017-01-16 00:00:00', NULL),
(100, '7ada5851f304ffd1efecc412c0421115', 'R00001', '2017-01-16 00:00:00', NULL),
(101, '2c6b3b5295fbe6fbdb1db588dc2db10a', 'M00001', '2017-01-16 00:00:00', NULL),
(102, 'a2b517b1813a6ec1a4dcdce78a026cba', 'R00001', '2017-01-16 00:00:00', NULL),
(103, '660fb42063208c5583850eadb830b13d', 'R00001', '2017-01-16 00:00:00', NULL),
(104, '92fe92bcd8e49cc2d60faa93e6c00218', 'R00001', '2017-01-16 00:00:00', NULL),
(105, '150170767cab4db8f4efdc6c72703910', 'R00001', '2017-01-16 00:00:00', NULL),
(106, 'daa32a0991a2a0f6aa3154b4258d4811', 'R00001', '2017-01-16 00:00:00', NULL),
(107, '34aa7cac8b77ac16943df94d823f7c84', 'R00001', '2017-01-16 00:00:00', NULL),
(108, '9a9d1bccd7e400395c4b8eea2d34ae31', 'R00001', '2017-01-16 00:00:00', NULL),
(109, '614c73e159674915866ce11408f07dd7', 'R00001', '2017-01-17 00:00:00', '127.0.0.1'),
(110, '059f88ed90911d19d1674ffcac8d88cc', 'R00001', '2017-01-17 00:00:00', '127.0.0.1'),
(111, 'bc3d4bfa840c846df72bc2eb5caf3111', 'M00001', '2017-01-17 00:00:00', '127.0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `userName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `userName`, `password`) VALUES
('A00000', 'demo', 'demo');

-- --------------------------------------------------------

--
-- Table structure for table `adminmessage`
--

CREATE TABLE `adminmessage` (
  `messageID` int(11) NOT NULL,
  `message` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `adminmessage`
--

INSERT INTO `adminmessage` (`messageID`, `message`) VALUES
(1, 'hello');

-- --------------------------------------------------------

--
-- Table structure for table `charge`
--

CREATE TABLE `charge` (
  `chargeID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `charge` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detailChi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detailEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hide` bit(1) NOT NULL DEFAULT b'0',
  `orderIn` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `charge`
--

INSERT INTO `charge` (`chargeID`, `restID`, `charge`, `detailChi`, `detailEng`, `hide`, `orderIn`) VALUES
('CH00000', 'R00001', '*0.7', '特價', 'special', b'0', 0);

-- --------------------------------------------------------

--
-- Table structure for table `choiceoption`
--

CREATE TABLE `choiceoption` (
  `optID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setOrderChoiceNo` int(255) NOT NULL,
  `setOrderNo` int(255) NOT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `choiceoption`
--

INSERT INTO `choiceoption` (`optID`, `setOrderChoiceNo`, `setOrderNo`, `invoiceID`) VALUES
('OPT00001', 0, 0, 'I00000'),
('OPT00001', 1, 1, 'I00001'),
('OPT00001', 2, 2, 'I00002'),
('OPT00001', 3, 3, 'I00003'),
('OPT00001', 4, 4, 'I00004'),
('OPT00001', 5, 5, 'I00005');

-- --------------------------------------------------------

--
-- Table structure for table `controllog`
--

CREATE TABLE `controllog` (
  `logID` int(255) NOT NULL,
  `adminID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `changeDateTime` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `companyID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE `coupon` (
  `couponID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coupon` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double(10,3) NOT NULL,
  `detailChi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detailEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expireDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custaddress`
--

CREATE TABLE `custaddress` (
  `cAddressNo` int(255) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custnotice`
--

CREATE TABLE `custnotice` (
  `cNID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adminID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custnotice`
--

INSERT INTO `custnotice` (`cNID`, `custID`, `adminID`, `title`, `description`, `dateTime`) VALUES
('CN00001', 'C00001', 'A00000', 'hello', 'welcome', '2016-12-17 11:17:19'),
('CN00002', 'C00001', 'A00000', 'warning', 'stop bad behavior', '2017-01-09 19:02:59');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custDevice` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custName` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `custTel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locked` bit(1) NOT NULL DEFAULT b'0',
  `registeredDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`custID`, `custDevice`, `custName`, `custTel`, `locked`, `registeredDate`) VALUES
('C00001', '123abc', '陳小明', '123', b'0', '2017-01-14 18:39:05'),
('C00002', '202cb962ac59075b964b07152d234b71', '王小明', '977', b'1', '2016-11-07 18:39:05');

-- --------------------------------------------------------

--
-- Table structure for table `custreport`
--

CREATE TABLE `custreport` (
  `reportID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custComment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `managerID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `custreport`
--

INSERT INTO `custreport` (`reportID`, `custID`, `custComment`, `managerID`) VALUES
('CR00000', 'C00001', 'bad behavior', 'M00001');

-- --------------------------------------------------------

--
-- Table structure for table `favourite`
--

CREATE TABLE `favourite` (
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favouritechoiceoption`
--

CREATE TABLE `favouritechoiceoption` (
  `fcoNo` int(255) NOT NULL,
  `fscID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `optID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favouritefood`
--

CREATE TABLE `favouritefood` (
  `ffID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favouriteorderoption`
--

CREATE TABLE `favouriteorderoption` (
  `fooNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ffID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `optID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favouriteset`
--

CREATE TABLE `favouriteset` (
  `fsID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favouritesetchoice`
--

CREATE TABLE `favouritesetchoice` (
  `fscID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fsID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodNo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `foodID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupNo` int(255) NOT NULL,
  `foodChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodPrice` double(10,3) NOT NULL,
  `foodPhoto` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `foodDesc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `foodTakeout` bit(1) NOT NULL,
  `managerID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `available` bit(1) NOT NULL DEFAULT b'0',
  `foodDescEng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`foodID`, `restID`, `groupNo`, `foodChiName`, `foodEngName`, `foodPrice`, `foodPhoto`, `foodDesc`, `foodTakeout`, `managerID`, `available`, `foodDescEng`) VALUES
('F00001', 'R00001', 1, '點心', 'dim sum', 10.000, 'image/food/dimsum.jpg', '好點心', b'0', 'M00001', b'0', 'nice dim sum'),
('F00002', 'R00001', 1, '炒飯', 'Fried rice', 20.000, 'image/food/friedrice.jpg', '好飯', b'0', 'M00001', b'0', 'good rice'),
('F00003', 'R00001', 1, '米粉', 'rice flour', 25.000, 'image/food/riceflour.jpg', '最好食物', b'0', 'M00001', b'0', 'best food');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `custID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tableID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `takeoutID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `totalCost` double(10,3) NOT NULL DEFAULT '0.000',
  `orderDateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoiceID`, `restID`, `custID`, `tableID`, `takeoutID`, `totalCost`, `orderDateTime`) VALUES
('I00000', 'R00001', 'C00001', NULL, 'T00000', 100.000, '2016-12-15 00:00:00'),
('I00001', 'R00001', 'C00001', NULL, 'T00002', 100.000, '2017-01-09 21:21:45'),
('I00002', 'R00001', 'C00001', NULL, 'T00003', 100.000, '2017-01-10 18:49:22'),
('I00003', 'R00001', 'C00001', 'TB00001', NULL, 100.000, '2017-01-10 18:51:30'),
('I00004', 'R00001', 'C00001', NULL, 'T00004', 100.000, '2017-01-10 19:17:56'),
('I00005', 'R00001', 'C00001', 'TB00001', NULL, 100.000, '2017-01-10 19:18:27');

--
-- Triggers `invoice`
--
DELIMITER $$
CREATE TRIGGER `user_invoice` BEFORE INSERT ON `invoice` FOR EACH ROW insert into trigger_invoice value(new.invoiceID)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoicecharge`
--

CREATE TABLE `invoicecharge` (
  `iChargeNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detailEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `charge` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detailChi` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `invoicecharge`
--

INSERT INTO `invoicecharge` (`iChargeNo`, `invoiceID`, `detailEng`, `charge`, `detailChi`) VALUES
('IC00000', 'I00000', 'special offer', '*0.9', '特價');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `managerID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `managerPW` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `managerEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locked` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`managerID`, `managerPW`, `companyID`, `restID`, `managerEmail`, `locked`) VALUES
('M00001', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'CM00001', 'R00001', 'manager@gmail.com', b'0'),
('M00002', '919', 'CM00001', 'R00001', 'test@yahoo.com', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `menugroup`
--

CREATE TABLE `menugroup` (
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupNo` int(255) NOT NULL,
  `groupChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startTime` time NOT NULL,
  `openHour` double(10,3) NOT NULL,
  `showDay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `managerID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastModify` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menugroup`
--

INSERT INTO `menugroup` (`restID`, `groupNo`, `groupChiName`, `groupEngName`, `startTime`, `openHour`, `showDay`, `managerID`, `lastModify`) VALUES
('R00001', 1, '早餐', 'breakfast', '06:00:00', 24.000, '0,1,2,3,4,5,6', 'M00001', '2016-12-15 00:00:00'),
('R00001', 2, '午餐', 'lunch', '12:00:00', 24.000, '0,1,2,3,4,5,6', 'M00001', '2016-12-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `menugroupitem`
--

CREATE TABLE `menugroupitem` (
  `itemNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupNo` int(255) NOT NULL,
  `foodID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `widgetID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rowNumber` int(255) NOT NULL,
  `columnNumber` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menugroupitem`
--

INSERT INTO `menugroupitem` (`itemNo`, `restID`, `groupNo`, `foodID`, `setID`, `widgetID`, `rowNumber`, `columnNumber`) VALUES
('IT00001', 'R00001', 1, 'F00001', NULL, 'W00001', 5, 0),
('IT00002', 'R00001', 1, NULL, 'S00001', 'W00002', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menuwidget`
--

CREATE TABLE `menuwidget` (
  `widgetID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `showPhotos` bit(1) NOT NULL DEFAULT b'0',
  `rowSpan` int(11) NOT NULL,
  `colSpan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menuwidget`
--

INSERT INTO `menuwidget` (`widgetID`, `showPhotos`, `rowSpan`, `colSpan`) VALUES
('W00001', b'0', 1, 1),
('W00002', b'1', 1, 2),
('W00003', b'1', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `optionallow`
--

CREATE TABLE `optionallow` (
  `oaID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `optID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderfood`
--

CREATE TABLE `orderfood` (
  `orderNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodPrice` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `quantity` int(255) NOT NULL,
  `foodSubPrice` double(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orderfood`
--

INSERT INTO `orderfood` (`orderNo`, `invoiceID`, `foodChiName`, `foodEngName`, `foodPrice`, `quantity`, `foodSubPrice`) VALUES
('OF00000', 'I00000', '點心', 'dim sum', '10', 1, 10.000),
('OF00001', 'I00001', '炒飯', 'Fried rice', '20.000', 3, 60.000),
('OF00002', 'I00002', '點心', 'dim sum', '10.000', 2, 20.000),
('OF00003', 'I00003', '點心', 'dim sum', '10.000', 3, 30.000),
('OF00004', 'I00004', '點心', 'dim sum', '10.000', 5, 50.000),
('OF00005', 'I00005', '炒飯', 'Fried rice', '20.000', 3, 60.000);

-- --------------------------------------------------------

--
-- Table structure for table `orderoption`
--

CREATE TABLE `orderoption` (
  `optID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `orderNo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orderoption`
--

INSERT INTO `orderoption` (`optID`, `orderNo`, `invoiceID`) VALUES
('OPT00001', 'OF00000', 'I00000'),
('OPT00001', 'OF00001', 'I00001'),
('OPT00001', 'OF00002', 'I00002'),
('OPT00001', 'OF00003', 'I00003'),
('OPT00001', 'OF00004', 'I00004'),
('OPT00001', 'OF00005', 'I00005');

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `rgID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rgChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rgEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`rgID`, `rgChiName`, `rgEngName`) VALUES
('RG00001', '中西區', 'Central and Western'),
('RG00002', '灣仔區', 'Wan Chai'),
('RG00003', '東區', 'Eastern'),
('RG00004', '南區', 'Southern'),
('RG00005', '油尖旺區', 'Yau Tsim Mong'),
('RG00006', '深水埗區', 'Sham Shui Po'),
('RG00007', '九龍城區', 'Kowloon City'),
('RG00008', '黃大仙區', 'Wong Tai Sin'),
('RG00009', '觀塘區', 'Kwun Tong'),
('RG00010', '葵青區', 'Kwai Tsing'),
('RG00011', '荃灣區', 'Tsuen Wan'),
('RG00012', '屯門區', 'Tuen Mun'),
('RG00013', '元朗區', 'Yuen Long'),
('RG00014', '北區', 'North'),
('RG00015', '大埔區', 'Tai Po'),
('RG00016', '沙田區', 'Sha Tin'),
('RG00017', '西貢區', 'Sai Kung'),
('RG00018', '離島區', 'Islands');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restPW` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restAddress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `printer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restTel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restPhoto` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restDesc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `registeredDate` datetime DEFAULT NULL,
  `locked` bit(1) NOT NULL DEFAULT b'0',
  `rgID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `qrCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `latitude` double(10,7) NOT NULL,
  `longitude` double(10,7) NOT NULL,
  `restAddressEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restDescEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`restID`, `companyID`, `restPW`, `restChiName`, `restEngName`, `restAddress`, `printer`, `restTel`, `restEmail`, `restPhoto`, `restDesc`, `registeredDate`, `locked`, `rgID`, `qrCode`, `latitude`, `longitude`, `restAddressEng`, `restDescEng`) VALUES
('R00001', 'CM00001', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', '大家樂(將軍澳)', 'Coral(TKO)', '117, 尚德廣場2 Tong Ming St, Tseung Kwan O', '123.123.123.123', '2178 4070', 'demo@gmail.com', 'image/restaurant/profile.png', '最好餐廳', '2016-12-15 00:00:00', b'0', 'RG00001', NULL, 22.3122826, 114.2298390, '117, Sheung Tak Plaza2 Tong Ming St, Tseung Kwan O', 'best restaurant'),
('R00002', 'CM00001', '456', '大快活(將軍澳)', 'Fairwood(TKO)', ' 將軍澳坑口培成路連理街', '0.0.0.0', '23456789', 'test@yahoo.com', 'image/restaurant/profile.png', '歡迎來餐廳', '2016-12-16 00:30:00', b'0', 'RG00001', NULL, 22.3069518, 114.2593485, 'Even the street,Pui Cheng Road,Hang Hau,Tseung Kwan O', 'welcome to restaurant');

-- --------------------------------------------------------

--
-- Table structure for table `restcompany`
--

CREATE TABLE `restcompany` (
  `companyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyPW` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyEmail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locked` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `restcompany`
--

INSERT INTO `restcompany` (`companyID`, `companyPW`, `companyChiName`, `companyEngName`, `companyEmail`, `locked`) VALUES
('CM00001', '123', '大家樂', 'Coral', 'demo@gmail.com', b'1'),
('CM00003', '9919', '大快活', 'Fairwood ', 'test@yahoo.com', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `restnotice`
--

CREATE TABLE `restnotice` (
  `rNID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `companyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `adminID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `restnotice`
--

INSERT INTO `restnotice` (`rNID`, `companyID`, `adminID`, `title`, `description`, `dateTime`) VALUES
('RN00001', 'CM00001', 'A00000', 'hello', 'Welcome', '2016-12-17 11:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `resttable`
--

CREATE TABLE `resttable` (
  `tableID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tableNo` int(255) NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `floor` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `posX` int(255) NOT NULL,
  `posY` int(255) NOT NULL,
  `maxNo` int(255) NOT NULL,
  `qrCode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `resttable`
--

INSERT INTO `resttable` (`tableID`, `tableNo`, `restID`, `floor`, `posX`, `posY`, `maxNo`, `qrCode`) VALUES
('TB00001', 1, 'R00001', '2', 10, 20, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setfood`
--

CREATE TABLE `setfood` (
  `foodNo` int(255) NOT NULL,
  `setID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extraPrice` double(10,3) NOT NULL DEFAULT '0.000',
  `titleNo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setfood`
--

INSERT INTO `setfood` (`foodNo`, `setID`, `foodID`, `extraPrice`, `titleNo`) VALUES
(1, 'S00001', 'F00001', 0.000, 1),
(3, 'S00001', 'F00001', 15.000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `setitem`
--

CREATE TABLE `setitem` (
  `setID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `groupNo` int(255) NOT NULL,
  `setChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `totalPrice` double(10,3) DEFAULT '0.000',
  `setPhoto` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setDesc` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `setTakeout` bit(1) NOT NULL DEFAULT b'0',
  `managerID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `available` bit(1) NOT NULL DEFAULT b'0',
  `setDescEng` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setitem`
--

INSERT INTO `setitem` (`setID`, `restID`, `groupNo`, `setChiName`, `setEngName`, `totalPrice`, `setPhoto`, `setDesc`, `setTakeout`, `managerID`, `available`, `setDescEng`) VALUES
('S00001', 'R00001', 1, '早餐', 'breakfast', 10.000, 'image/set/breakfast.jpg', '最好早餐', b'0', 'M00001', b'0', 'best breakfast'),
('S00002', 'R00001', 1, '午餐', 'lunch', 20.000, 'image/set/lunch.jpg', '好午餐', b'1', 'M00001', b'0', 'good lunch');

-- --------------------------------------------------------

--
-- Table structure for table `setorder`
--

CREATE TABLE `setorder` (
  `setOrderNo` int(255) NOT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `setPrice` double(10,3) NOT NULL DEFAULT '0.000',
  `quantity` int(255) NOT NULL,
  `setSubPrice` double(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setorder`
--

INSERT INTO `setorder` (`setOrderNo`, `invoiceID`, `setChiName`, `setEngName`, `setPrice`, `quantity`, `setSubPrice`) VALUES
(0, 'I00000', '早餐', 'breakfast', 10.000, 1, 10.000),
(1, 'I00001', '早餐', 'breakfast', 10.000, 2, 20.000),
(2, 'I00002', '早餐', 'breakfast', 10.000, 1, 10.000),
(3, 'I00003', '午餐', 'lunch', 20.000, 1, 20.000),
(4, 'I00004', '午餐', 'lunch', 20.000, 2, 40.000),
(5, 'I00005', '午餐', 'lunch', 20.000, 3, 60.000);

-- --------------------------------------------------------

--
-- Table structure for table `setorderchoice`
--

CREATE TABLE `setorderchoice` (
  `setOrderChoiceNo` int(255) NOT NULL,
  `setOrderNo` int(255) NOT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodChiName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foodEngName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extraPrice` double(10,3) NOT NULL DEFAULT '0.000',
  `quantity` int(11) NOT NULL,
  `extraSubPrice` double(10,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `setorderchoice`
--

INSERT INTO `setorderchoice` (`setOrderChoiceNo`, `setOrderNo`, `invoiceID`, `foodChiName`, `foodEngName`, `extraPrice`, `quantity`, `extraSubPrice`) VALUES
(0, 0, 'I00000', '點心', 'dim sum', 20.000, 1, 20.000),
(1, 1, 'I00001', '點心', 'dim sum', 20.000, 2, 40.000),
(2, 2, 'I00002', '點心', 'dim sum', 20.000, 2, 40.000),
(3, 3, 'I00003', '炒飯', 'fried rice', 10.000, 2, 20.000),
(4, 4, 'I00004', '點心', 'dim sum', 20.000, 2, 40.000),
(5, 5, 'I00005', '點心', 'dim sum', 20.000, 3, 60.000);

-- --------------------------------------------------------

--
-- Table structure for table `settitle`
--

CREATE TABLE `settitle` (
  `titleNo` int(11) NOT NULL,
  `setID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `count` int(11) NOT NULL,
  `titleEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settitle`
--

INSERT INTO `settitle` (`titleNo`, `setID`, `title`, `count`, `titleEng`) VALUES
(1, 'S00001', '前菜', 1, 'Appetizer'),
(2, 'S00001', '主菜', 1, 'main course');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` int(11) NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `verifyCode` int(11) DEFAULT NULL,
  `verified` bit(1) NOT NULL DEFAULT b'0',
  `oldPhone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sms`
--

INSERT INTO `sms` (`id`, `phone`, `verifyCode`, `verified`, `oldPhone`) VALUES
(3, '55416453', 4917, b'0', NULL),
(4, '55416453', 4033, b'0', NULL),
(5, '55416453', 2425, b'0', NULL),
(6, '55416453', 1865, b'0', NULL),
(7, '55416453', 5977, b'0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `specialoption`
--

CREATE TABLE `specialoption` (
  `optID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentChi` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contentEng` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `extraPrice` double(10,3) NOT NULL DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `specialoption`
--

INSERT INTO `specialoption` (`optID`, `contentChi`, `contentEng`, `extraPrice`) VALUES
('OPT00001', '少油', 'less oil', 0.000),
('OPT00002', '少糖', 'less sugar', 0.000);

-- --------------------------------------------------------

--
-- Table structure for table `tablefloorplan`
--

CREATE TABLE `tablefloorplan` (
  `restID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `floor` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `sizeX` int(255) NOT NULL,
  `sizeY` int(255) NOT NULL,
  `managerID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastModify` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tablefloorplan`
--

INSERT INTO `tablefloorplan` (`restID`, `floor`, `sizeX`, `sizeY`, `managerID`, `lastModify`) VALUES
('R00001', '2', 20, 20, 'M00001', '2016-12-16 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `takeout`
--

CREATE TABLE `takeout` (
  `takeoutID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `takeoutNo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `takeout`
--

INSERT INTO `takeout` (`takeoutID`, `address`, `invoiceID`, `takeoutNo`) VALUES
('T00001', NULL, 'I00000', 1),
('T00002', '將軍澳景嶺路3號', 'I00000', NULL),
('T00002', '將軍澳景嶺路3號', 'I00001', NULL),
('T00003', '將軍澳景嶺路3號', 'I00002', NULL),
('T00004', '將軍澳景嶺路3號', 'I00004', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trigger_invoice`
--

CREATE TABLE `trigger_invoice` (
  `invoiceID` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesstoken`
--
ALTER TABLE `accesstoken`
  ADD PRIMARY KEY (`tokenID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `adminmessage`
--
ALTER TABLE `adminmessage`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `charge`
--
ALTER TABLE `charge`
  ADD PRIMARY KEY (`chargeID`),
  ADD UNIQUE KEY `restID` (`restID`,`orderIn`);

--
-- Indexes for table `choiceoption`
--
ALTER TABLE `choiceoption`
  ADD PRIMARY KEY (`optID`,`setOrderChoiceNo`,`setOrderNo`,`invoiceID`),
  ADD KEY `setOrderChoiceNo` (`setOrderChoiceNo`,`setOrderNo`,`invoiceID`);

--
-- Indexes for table `controllog`
--
ALTER TABLE `controllog`
  ADD PRIMARY KEY (`logID`),
  ADD KEY `adminID` (`adminID`),
  ADD KEY `custID` (`custID`),
  ADD KEY `companyID` (`companyID`);

--
-- Indexes for table `coupon`
--
ALTER TABLE `coupon`
  ADD PRIMARY KEY (`couponID`),
  ADD KEY `restID` (`restID`);

--
-- Indexes for table `custaddress`
--
ALTER TABLE `custaddress`
  ADD PRIMARY KEY (`cAddressNo`),
  ADD KEY `custID` (`custID`);

--
-- Indexes for table `custnotice`
--
ALTER TABLE `custnotice`
  ADD PRIMARY KEY (`cNID`),
  ADD KEY `custID` (`custID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custID`),
  ADD UNIQUE KEY `custDevice` (`custDevice`,`custTel`);

--
-- Indexes for table `custreport`
--
ALTER TABLE `custreport`
  ADD PRIMARY KEY (`reportID`),
  ADD KEY `custID` (`custID`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `favourite`
--
ALTER TABLE `favourite`
  ADD PRIMARY KEY (`custID`,`restID`),
  ADD KEY `restID` (`restID`);

--
-- Indexes for table `favouritechoiceoption`
--
ALTER TABLE `favouritechoiceoption`
  ADD PRIMARY KEY (`fcoNo`,`fscID`),
  ADD KEY `fscID` (`fscID`),
  ADD KEY `optID` (`optID`);

--
-- Indexes for table `favouritefood`
--
ALTER TABLE `favouritefood`
  ADD PRIMARY KEY (`ffID`),
  ADD KEY `custID` (`custID`,`restID`),
  ADD KEY `foodID` (`foodID`);

--
-- Indexes for table `favouriteorderoption`
--
ALTER TABLE `favouriteorderoption`
  ADD PRIMARY KEY (`fooNo`,`ffID`),
  ADD KEY `ffID` (`ffID`),
  ADD KEY `optID` (`optID`);

--
-- Indexes for table `favouriteset`
--
ALTER TABLE `favouriteset`
  ADD PRIMARY KEY (`fsID`,`custID`),
  ADD KEY `custID` (`custID`,`restID`),
  ADD KEY `setID` (`setID`);

--
-- Indexes for table `favouritesetchoice`
--
ALTER TABLE `favouritesetchoice`
  ADD PRIMARY KEY (`fscID`),
  ADD KEY `fsID` (`fsID`,`custID`),
  ADD KEY `foodNo` (`foodNo`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`foodID`),
  ADD KEY `restID` (`restID`,`groupNo`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoiceID`),
  ADD KEY `restID` (`restID`),
  ADD KEY `custID` (`custID`),
  ADD KEY `tableID` (`tableID`);

--
-- Indexes for table `invoicecharge`
--
ALTER TABLE `invoicecharge`
  ADD PRIMARY KEY (`iChargeNo`,`invoiceID`),
  ADD KEY `invoiceID` (`invoiceID`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`managerID`),
  ADD KEY `companyID` (`companyID`),
  ADD KEY `restID` (`restID`);

--
-- Indexes for table `menugroup`
--
ALTER TABLE `menugroup`
  ADD PRIMARY KEY (`restID`,`groupNo`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `menugroupitem`
--
ALTER TABLE `menugroupitem`
  ADD PRIMARY KEY (`itemNo`,`restID`,`groupNo`),
  ADD UNIQUE KEY `rowNumber` (`rowNumber`,`columnNumber`),
  ADD KEY `restID` (`restID`,`groupNo`),
  ADD KEY `foodID` (`foodID`),
  ADD KEY `setID` (`setID`),
  ADD KEY `widgetID` (`widgetID`);

--
-- Indexes for table `menuwidget`
--
ALTER TABLE `menuwidget`
  ADD PRIMARY KEY (`widgetID`);

--
-- Indexes for table `optionallow`
--
ALTER TABLE `optionallow`
  ADD PRIMARY KEY (`oaID`,`foodID`),
  ADD KEY `optID` (`optID`),
  ADD KEY `foodID` (`foodID`);

--
-- Indexes for table `orderfood`
--
ALTER TABLE `orderfood`
  ADD PRIMARY KEY (`orderNo`,`invoiceID`),
  ADD KEY `invoiceID` (`invoiceID`);

--
-- Indexes for table `orderoption`
--
ALTER TABLE `orderoption`
  ADD PRIMARY KEY (`optID`,`orderNo`,`invoiceID`),
  ADD KEY `orderNo` (`orderNo`,`invoiceID`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`rgID`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`restID`),
  ADD KEY `companyID` (`companyID`),
  ADD KEY `rgID` (`rgID`);

--
-- Indexes for table `restcompany`
--
ALTER TABLE `restcompany`
  ADD PRIMARY KEY (`companyID`);

--
-- Indexes for table `restnotice`
--
ALTER TABLE `restnotice`
  ADD PRIMARY KEY (`rNID`),
  ADD KEY `companyID` (`companyID`),
  ADD KEY `adminID` (`adminID`);

--
-- Indexes for table `resttable`
--
ALTER TABLE `resttable`
  ADD PRIMARY KEY (`tableID`),
  ADD UNIQUE KEY `posX` (`posX`,`posY`),
  ADD KEY `restID` (`restID`,`floor`);

--
-- Indexes for table `setfood`
--
ALTER TABLE `setfood`
  ADD PRIMARY KEY (`foodNo`),
  ADD KEY `setID` (`setID`),
  ADD KEY `foodID` (`foodID`),
  ADD KEY `titleNo` (`titleNo`);

--
-- Indexes for table `setitem`
--
ALTER TABLE `setitem`
  ADD PRIMARY KEY (`setID`),
  ADD KEY `restID` (`restID`,`groupNo`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `setorder`
--
ALTER TABLE `setorder`
  ADD PRIMARY KEY (`setOrderNo`,`invoiceID`),
  ADD KEY `invoiceID` (`invoiceID`);

--
-- Indexes for table `setorderchoice`
--
ALTER TABLE `setorderchoice`
  ADD PRIMARY KEY (`setOrderChoiceNo`,`setOrderNo`,`invoiceID`),
  ADD KEY `setOrderNo` (`setOrderNo`,`invoiceID`);

--
-- Indexes for table `settitle`
--
ALTER TABLE `settitle`
  ADD PRIMARY KEY (`titleNo`),
  ADD KEY `setID` (`setID`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specialoption`
--
ALTER TABLE `specialoption`
  ADD PRIMARY KEY (`optID`);

--
-- Indexes for table `tablefloorplan`
--
ALTER TABLE `tablefloorplan`
  ADD PRIMARY KEY (`restID`,`floor`),
  ADD KEY `managerID` (`managerID`);

--
-- Indexes for table `takeout`
--
ALTER TABLE `takeout`
  ADD PRIMARY KEY (`takeoutID`,`invoiceID`),
  ADD KEY `invoiceID` (`invoiceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesstoken`
--
ALTER TABLE `accesstoken`
  MODIFY `tokenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;
--
-- AUTO_INCREMENT for table `adminmessage`
--
ALTER TABLE `adminmessage`
  MODIFY `messageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `controllog`
--
ALTER TABLE `controllog`
  MODIFY `logID` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settitle`
--
ALTER TABLE `settitle`
  MODIFY `titleNo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `charge`
--
ALTER TABLE `charge`
  ADD CONSTRAINT `charge_ibfk_1` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`);

--
-- Constraints for table `choiceoption`
--
ALTER TABLE `choiceoption`
  ADD CONSTRAINT `choiceoption_ibfk_1` FOREIGN KEY (`setOrderChoiceNo`,`setOrderNo`,`invoiceID`) REFERENCES `setorderchoice` (`setOrderChoiceNo`, `setOrderNo`, `invoiceID`),
  ADD CONSTRAINT `choiceoption_ibfk_2` FOREIGN KEY (`optID`) REFERENCES `specialoption` (`optID`);

--
-- Constraints for table `controllog`
--
ALTER TABLE `controllog`
  ADD CONSTRAINT `controllog_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`),
  ADD CONSTRAINT `controllog_ibfk_2` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`),
  ADD CONSTRAINT `controllog_ibfk_3` FOREIGN KEY (`companyID`) REFERENCES `restcompany` (`companyID`);

--
-- Constraints for table `coupon`
--
ALTER TABLE `coupon`
  ADD CONSTRAINT `coupon_ibfk_1` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`);

--
-- Constraints for table `custaddress`
--
ALTER TABLE `custaddress`
  ADD CONSTRAINT `custaddress_ibfk_1` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`);

--
-- Constraints for table `custnotice`
--
ALTER TABLE `custnotice`
  ADD CONSTRAINT `custnotice_ibfk_1` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`),
  ADD CONSTRAINT `custnotice_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`);

--
-- Constraints for table `custreport`
--
ALTER TABLE `custreport`
  ADD CONSTRAINT `custreport_ibfk_1` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`),
  ADD CONSTRAINT `custreport_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `favourite`
--
ALTER TABLE `favourite`
  ADD CONSTRAINT `favourite_ibfk_1` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`),
  ADD CONSTRAINT `favourite_ibfk_2` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`);

--
-- Constraints for table `favouritechoiceoption`
--
ALTER TABLE `favouritechoiceoption`
  ADD CONSTRAINT `favouritechoiceoption_ibfk_1` FOREIGN KEY (`fscID`) REFERENCES `favouritesetchoice` (`fscID`),
  ADD CONSTRAINT `favouritechoiceoption_ibfk_2` FOREIGN KEY (`optID`) REFERENCES `specialoption` (`optID`);

--
-- Constraints for table `favouritefood`
--
ALTER TABLE `favouritefood`
  ADD CONSTRAINT `favouritefood_ibfk_1` FOREIGN KEY (`custID`,`restID`) REFERENCES `favourite` (`custID`, `restID`),
  ADD CONSTRAINT `favouritefood_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `food` (`foodID`);

--
-- Constraints for table `favouriteorderoption`
--
ALTER TABLE `favouriteorderoption`
  ADD CONSTRAINT `favouriteorderoption_ibfk_1` FOREIGN KEY (`ffID`) REFERENCES `favouritefood` (`ffID`),
  ADD CONSTRAINT `favouriteorderoption_ibfk_2` FOREIGN KEY (`optID`) REFERENCES `specialoption` (`optID`);

--
-- Constraints for table `favouriteset`
--
ALTER TABLE `favouriteset`
  ADD CONSTRAINT `favouriteset_ibfk_1` FOREIGN KEY (`custID`,`restID`) REFERENCES `favourite` (`custID`, `restID`),
  ADD CONSTRAINT `favouriteset_ibfk_2` FOREIGN KEY (`setID`) REFERENCES `setitem` (`setID`);

--
-- Constraints for table `favouritesetchoice`
--
ALTER TABLE `favouritesetchoice`
  ADD CONSTRAINT `favouritesetchoice_ibfk_1` FOREIGN KEY (`fsID`,`custID`) REFERENCES `favouriteset` (`fsID`, `custID`),
  ADD CONSTRAINT `favouritesetchoice_ibfk_2` FOREIGN KEY (`foodNo`) REFERENCES `setfood` (`foodNo`);

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`restID`,`groupNo`) REFERENCES `menugroup` (`restID`, `groupNo`),
  ADD CONSTRAINT `food_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`),
  ADD CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`custID`) REFERENCES `customer` (`custID`),
  ADD CONSTRAINT `invoice_ibfk_3` FOREIGN KEY (`tableID`) REFERENCES `resttable` (`tableID`);

--
-- Constraints for table `invoicecharge`
--
ALTER TABLE `invoicecharge`
  ADD CONSTRAINT `invoicecharge_ibfk_1` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`);

--
-- Constraints for table `manager`
--
ALTER TABLE `manager`
  ADD CONSTRAINT `manager_ibfk_1` FOREIGN KEY (`companyID`) REFERENCES `restcompany` (`companyID`),
  ADD CONSTRAINT `manager_ibfk_2` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`);

--
-- Constraints for table `menugroup`
--
ALTER TABLE `menugroup`
  ADD CONSTRAINT `menugroup_ibfk_1` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`),
  ADD CONSTRAINT `menugroup_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `menugroupitem`
--
ALTER TABLE `menugroupitem`
  ADD CONSTRAINT `menugroupitem_ibfk_1` FOREIGN KEY (`restID`,`groupNo`) REFERENCES `menugroup` (`restID`, `groupNo`),
  ADD CONSTRAINT `menugroupitem_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `food` (`foodID`),
  ADD CONSTRAINT `menugroupitem_ibfk_3` FOREIGN KEY (`setID`) REFERENCES `setitem` (`setID`),
  ADD CONSTRAINT `menugroupitem_ibfk_4` FOREIGN KEY (`widgetID`) REFERENCES `menuwidget` (`widgetID`);

--
-- Constraints for table `optionallow`
--
ALTER TABLE `optionallow`
  ADD CONSTRAINT `optionallow_ibfk_1` FOREIGN KEY (`optID`) REFERENCES `specialoption` (`optID`),
  ADD CONSTRAINT `optionallow_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `food` (`foodID`);

--
-- Constraints for table `orderfood`
--
ALTER TABLE `orderfood`
  ADD CONSTRAINT `orderfood_ibfk_1` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`);

--
-- Constraints for table `orderoption`
--
ALTER TABLE `orderoption`
  ADD CONSTRAINT `orderoption_ibfk_1` FOREIGN KEY (`optID`) REFERENCES `specialoption` (`optID`),
  ADD CONSTRAINT `orderoption_ibfk_2` FOREIGN KEY (`orderNo`,`invoiceID`) REFERENCES `orderfood` (`orderNo`, `invoiceID`);

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`companyID`) REFERENCES `restcompany` (`companyID`),
  ADD CONSTRAINT `restaurant_ibfk_2` FOREIGN KEY (`rgID`) REFERENCES `region` (`rgID`);

--
-- Constraints for table `restnotice`
--
ALTER TABLE `restnotice`
  ADD CONSTRAINT `restnotice_ibfk_1` FOREIGN KEY (`companyID`) REFERENCES `restcompany` (`companyID`),
  ADD CONSTRAINT `restnotice_ibfk_2` FOREIGN KEY (`adminID`) REFERENCES `admin` (`adminID`);

--
-- Constraints for table `resttable`
--
ALTER TABLE `resttable`
  ADD CONSTRAINT `resttable_ibfk_1` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`),
  ADD CONSTRAINT `resttable_ibfk_2` FOREIGN KEY (`restID`,`floor`) REFERENCES `tablefloorplan` (`restID`, `floor`);

--
-- Constraints for table `setfood`
--
ALTER TABLE `setfood`
  ADD CONSTRAINT `setfood_ibfk_1` FOREIGN KEY (`setID`) REFERENCES `setitem` (`setID`),
  ADD CONSTRAINT `setfood_ibfk_2` FOREIGN KEY (`foodID`) REFERENCES `food` (`foodID`),
  ADD CONSTRAINT `setfood_ibfk_3` FOREIGN KEY (`titleNo`) REFERENCES `settitle` (`titleNo`);

--
-- Constraints for table `setitem`
--
ALTER TABLE `setitem`
  ADD CONSTRAINT `setitem_ibfk_1` FOREIGN KEY (`restID`,`groupNo`) REFERENCES `menugroup` (`restID`, `groupNo`),
  ADD CONSTRAINT `setitem_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `setorder`
--
ALTER TABLE `setorder`
  ADD CONSTRAINT `setorder_ibfk_1` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`);

--
-- Constraints for table `setorderchoice`
--
ALTER TABLE `setorderchoice`
  ADD CONSTRAINT `setorderchoice_ibfk_1` FOREIGN KEY (`setOrderNo`,`invoiceID`) REFERENCES `setorder` (`setOrderNo`, `invoiceID`);

--
-- Constraints for table `settitle`
--
ALTER TABLE `settitle`
  ADD CONSTRAINT `settitle_ibfk_1` FOREIGN KEY (`setID`) REFERENCES `setitem` (`setID`);

--
-- Constraints for table `tablefloorplan`
--
ALTER TABLE `tablefloorplan`
  ADD CONSTRAINT `tablefloorplan_ibfk_1` FOREIGN KEY (`restID`) REFERENCES `restaurant` (`restID`),
  ADD CONSTRAINT `tablefloorplan_ibfk_2` FOREIGN KEY (`managerID`) REFERENCES `manager` (`managerID`);

--
-- Constraints for table `takeout`
--
ALTER TABLE `takeout`
  ADD CONSTRAINT `takeout_ibfk_1` FOREIGN KEY (`invoiceID`) REFERENCES `invoice` (`invoiceID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
