-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2015 at 03:45 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `googlemaps`
--

-- --------------------------------------------------------

--
-- Table structure for table `fault`
--

CREATE TABLE IF NOT EXISTS `fault` (
  `faultId` int(3) NOT NULL AUTO_INCREMENT,
  `faultReportEmail` varchar(30) NOT NULL,
  `faultMsisdn` varchar(12) DEFAULT NULL,
  `faultAddress` varchar(50) NOT NULL,
  `faultCounty` varchar(10) NOT NULL,
  `faultType` varchar(6) NOT NULL,
  `faultFrequency` varchar(15) NOT NULL,
  `faultDescription` varchar(200) NOT NULL,
  `faultDateFrom` datetime NOT NULL,
  `faultDateTo` datetime NOT NULL,
  `faultLatitude` varchar(10) NOT NULL,
  `faultLongitude` varchar(10) NOT NULL,
  `faultStatus` varchar(9) NOT NULL,
  `faultUpdate` varchar(200) DEFAULT NULL,
  `_adminId` int(3) DEFAULT NULL,
  PRIMARY KEY (`faultId`),
  KEY `_adminId` (`_adminId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `fault`
--

INSERT INTO `fault` (`faultId`, `faultReportEmail`, `faultMsisdn`, `faultAddress`, `faultCounty`, `faultType`, `faultFrequency`, `faultDescription`, `faultDateFrom`, `faultDateTo`, `faultLatitude`, `faultLongitude`, `faultStatus`, `faultUpdate`, `_adminId`) VALUES
(1, 'cormac.liston@gmail.com', '353872930841', '141 Biscayne Malahide ', 'Dublin', 'sms', 'constant', 'can''t SMS from bedroom', '2015-03-29 09:36:22', '0000-00-00 00:00:00', '53.445300', '-6.137320', 'open', NULL, NULL),
(6, 'cormac.liston@gmail.com', '353872463534', 'Salthill Hotel', 'Galway', 'sms', 'intermittent', 'Intermittenty unable to send texts from upstairs window', '2015-02-25 15:36:29', '0000-00-00 00:00:00', '53.258805', '-9.087245', 'open', '', 1),
(7, 'cormac.liston@gmail.com', '353857972726', 'Clifden Station House Hotel, Clifden', 'Galway', 'sms', 'intermittent', 'Intermittenty unable to send texts from upstairs window', '2015-02-25 15:36:29', '0000-00-00 00:00:00', '53.488826', '-10.017729', 'open', '', 1),
(8, 'cormac.liston@gmail.com', '353857972336', '372 Harolds Cross Road, Dublin 6W', 'Dublin', 'sms', 'intermittent', 'Unable to send SMS when using 4G', '2015-02-25 15:36:29', '0000-00-00 00:00:00', '53.317098', '-6.281120', 'open', '', 1),
(9, 'cormac.liston@gmail.com', NULL, '69 Somerton, Donabate', 'Dublin', 'data', 'constant', 'Unable to connnect to internet', '2015-02-26 15:36:29', '0000-00-00 00:00:00', '53.492864', '-6.143775', 'closed', 'test update', 1),
(22, 'cormac.liston@gmail.com', '353872000000', '143 Seapark', 'Dublin', 'voice', 'intermittent', 'Cant&#39;s send SMS or make calls in living room', '2015-02-26 15:36:29', '0000-00-00 00:00:00', '53.445324', '-6.139652', 'closed', 'closing fault 22', 1),
(26, 'cormac.liston@outlook.com', '353873000000', 'Cavan Town Hall', 'Cavan', 'data', 'intermittent', 'test', '2015-02-25 15:36:29', '0000-00-00 00:00:00', '53.991357', '-7.362171', 'open', 'test update', 1),
(27, 'cormac.music@gmail.com', '353852000000', 'Eircom, Bianconi Avenue, Citywest', 'Dublin', 'data', 'constant', 'test', '2015-03-16 18:14:32', '0000-00-00 00:00:00', '53.291222', '-6.432875', 'open', '', 1),
(28, 'cormac.music@gmail.com', '353873000000', 'Meteor, Parkwest', 'Dublin', 'data', 'intermittent', 'test', '2015-03-17 18:14:32', '0000-00-00 00:00:00', '53.331659', '-6.374764', 'closed', 'closing. no fault', 1),
(29, 'cormac.liston@gmail.com', '353892000000', 'Tickknock', 'Dublin', 'data', 'intermittent', 'test', '2015-03-12 09:12:13', '0000-00-00 00:00:00', '53.251460', '-6.250024', 'closed', 'closing no fault faound', 1),
(30, 'cormac.liston@gmail.com', '353891000000', 'Carrigaline', 'Cork', 'data', 'intermittent', 'test', '2015-03-15 09:12:13', '0000-00-00 00:00:00', '51.827525', '-8.381345', 'closed', 'loadsa coverage', 1),
(31, 'cormac.liston@outlook.com', '353852000000', 'Abbey Hotel', 'Donegal', 'data', 'intermittent', 'test', '2015-03-28 16:14:00', '0000-00-00 00:00:00', '54.653866', '-8.110806', 'open', '', 1),
(32, 'cormac.liston@gmail.com', '353868000000', '16 Brighton Gardens, Rathgar', 'Dublin', 'sms', 'constant', 'test', '2015-02-28 16:14:00', '0000-00-00 00:00:00', '53.312957', '-6.279470', 'closed', 'closing no fault', 1),
(33, 'cormac.liston@gmail.com', '353852000000', '15 Quay Road, Dungloe', 'Donegal', 'data', 'intermittent', 'Intermittently failing to connect to data', '2015-04-08 00:00:00', '0000-00-00 00:00:00', '54.9500474', '-8.3614379', 'open', 'test update', 1),
(39, 'cormac.liston@gmail.com', '353866000000', 'Hoey&#39;s Lane Dundalk', 'Louth', 'sms', 'intermittent', 'Not receiving SMS', '2015-04-15 00:00:00', '0000-00-00 00:00:00', '53.9876522', '-6.3857951', 'closed', 'plenty of coverage', 1),
(40, 'cormac.liston@gmail.com', '353866321322', 'Hoey&#39;s Lane Dundalk', 'Louth', 'sms', 'intermittent', 'Not receiving SMS', '2015-04-15 00:00:00', '0000-00-00 00:00:00', '53.9876522', '-6.3857951', 'closed', 'loadsa coverage', 1),
(41, 'cormac.liston@gmail.com', '353866321322', 'Hoey&#39;s Lane Dundalk', 'Louth', 'sms', 'intermittent', 'Not receiving SMS', '2015-04-15 00:00:00', '0000-00-00 00:00:00', '53.9876522', '-6.3857951', 'open', '', 1),
(42, 'cormac.liston@gmail.com', '353851715286', 'Old Cavan Road, Cootehill', 'Cavan', 'all', 'intermittent', 'Cant call or send SMS', '2015-04-15 00:00:00', '0000-00-00 00:00:00', '54.0687209', '-7.0834270', 'closed', 'test', 1),
(43, 'cormac.liston@gmail.com', '353872463534', 'Lisbrack Road, Longford', 'Longford', 'data', 'intermittent', 'can&#39;t connect to FACEBOOK', '2015-04-09 00:00:00', '0000-00-00 00:00:00', '53.7377282', '-7.8035505', 'open', 'test update', 1),
(44, 'cormac.liston@gmail.com', '353856012320', 'Chapel Road, Dungloe', 'Donegal', 'data', 'intermittent', 'can&#39;t connect to facebook', '2015-04-16 00:00:00', '0000-00-00 00:00:00', '54.9588050', '-8.0536007', 'open', '', 1),
(45, 'cormac.liston@gmail.com', '353871725286', '1 Main Street, Carlow Town', 'Carlow', 'sms', 'constant', 'C=Unable to get signal', '2015-04-08 00:00:00', '0000-00-00 00:00:00', '52.8331063', '-6.9293689', 'open', 'update test&#39;1', 1),
(46, 'cormac.liston@gmail.com', '353851715286', 'Blarney Castle, Cork', 'Cork', 'sms', 'intermittent', 'Unable to send SMS from castle', '2015-04-22 00:00:00', '0000-00-00 00:00:00', '51.9396616', '-8.5745716', 'closed', 'loadsa coverage', 1),
(47, 'cormac.liston@gmail.com', '353851715286', 'Blarney Castle, Cork', 'Cork', 'sms', 'intermittent', 'Unable to send SMS from castle', '2015-04-22 00:00:00', '0000-00-00 00:00:00', '51.9396616', '-8.5745716', 'open', '', 1),
(48, 'cormac.liston@gmail.com', '353892463835', 'test', 'Cork', 'all', 'constant', 'tes', '2015-04-08 00:00:00', '0000-00-00 00:00:00', '52.1356480', '-7.9730701', 'open', '', 1),
(49, 'cormac.music@gmail.com', '353861123344', 'Anascaull House n&#39; Bar', 'Leitrim', 'sms', 'intermittent', 'can&#39;t send SMS at the church', '2015-05-14 00:00:00', '0000-00-00 00:00:00', '53.9914795', '-8.0653059', 'open', '', 1),
(50, 'cormac.liston@outlook.com', '353861234152', 'BallyRagget', 'Kilkenny', 'all', 'constant', 'test', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '52.7700065', '-7.3825550', 'open', '', 1),
(51, 'cormac.liston@outlook.com', '355851715286', 'Mountrath Laois', 'Laois', 'all', 'intermittent', 'test', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '52.9937620', '-7.4319934', 'open', '', 1),
(52, 'cormac.liston@outlook.com', '355851715286', 'Mountrath Laois', 'Laois', 'all', 'intermittent', 'test', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '52.9937620', '-7.4319934', 'open', '', 1),
(53, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'open', '', 1),
(54, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(55, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(56, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(57, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(58, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(59, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(60, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(61, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(62, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(63, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(64, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(65, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(66, 'cormac.liston@outlook.com', '353845524886', 'Belderrig', 'Mayo', 'all', 'intermittent', 'test', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '54.3009498', '-9.5029163', 'closed', 'duplicate', 1),
(67, 'luhvenechenique@gmail.com', '353852175286', 'Corofin', 'Clare', 'data', 'constant', 'Can&#39;t connect to data in living room', '2015-05-05 00:00:00', '0000-00-00 00:00:00', '52.9375175', '-9.0579700', 'closed', 'No fault found\r\n\r\nsites on air around fault. Performance being checked', 1),
(68, 'luhvenechenique@gmail.com', '353851761322', 'CastleDillon', 'Kildare', 'voice', 'intermittent', 'calls dropping on main street', '2015-05-01 00:00:00', '0000-00-00 00:00:00', '53.3003702', '-6.6099607', 'open', '', 1),
(69, 'luhvenechenique@gmail.com', '353879910121', 'Ruan', 'Clare', 'all', 'constant', 'no service', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '52.9264073', '-8.9915585', 'closed', 'all sites on air and performing ok', 1),
(70, 'cormac.liston@outlook.com', '353861234222', 'farnham estate', 'Cavan', 'sms', 'intermittent', 'no data in farnham estate', '2015-05-12 00:00:00', '0000-00-00 00:00:00', '53.9726977', '-7.3441028', 'open', '', 1),
(71, 'cormac.liston@outlook.com', '353861231132', 'Dundalk', 'Louth', 'sms', 'constant', 'no calls', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '53.9953711', '-6.4104580', 'open', '', 1),
(72, 'luhvenechenique@gmail.com', '353879124445', 'Three Mile House', 'Monaghan', 'sms', 'constant', 'can&#39;t send sms', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '54.2207992', '-7.0318722', 'open', '', 1),
(73, 'luhvenechenique@gmail.com', '353871725287', 'test', 'Cavan', 'sms', 'intermittent', 'test', '2015-05-06 00:00:00', '0000-00-00 00:00:00', '53.9936934', '-7.1765613', 'open', '', 1),
(74, 'luhvenechenique@gmail.com', '353851326774', 'Bruff', 'Limerick', 'sms', 'constant', 'no sms can be sent', '2015-05-07 00:00:00', '0000-00-00 00:00:00', '52.4696321', '-8.5252618', 'open', '', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fault`
--
ALTER TABLE `fault`
  ADD CONSTRAINT `fault_ibfk_1` FOREIGN KEY (`_adminId`) REFERENCES `admin` (`adminId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
