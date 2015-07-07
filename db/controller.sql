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
-- Table structure for table `controller`
--

CREATE TABLE IF NOT EXISTS `controller` (
  `controllerId` int(2) NOT NULL,
  `controllerType` varchar(3) NOT NULL,
  `controllerLatitude` varchar(15) NOT NULL,
  `controllerLongitude` varchar(15) DEFAULT NULL,
  `controllerMSC` int(2) NOT NULL,
  PRIMARY KEY (`controllerId`,`controllerType`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `controller`
--

INSERT INTO `controller` (`controllerId`, `controllerType`, `controllerLatitude`, `controllerLongitude`, `controllerMSC`) VALUES
(1, 'BSC', '53.300937', '-6.418035', 1),
(1, 'RNC', '53.298064', '-6.417692', 1),
(2, 'BSC', '53.877491', '-6.449989', 2),
(2, 'RNC', '53.721141', '-7.094659', 2),
(3, 'BSC', '53.622489', '-6.617510', 2),
(3, 'RNC', '52.782881', '-7.281427', 2),
(4, 'BSC', '53.168825', '-6.943560', 2),
(4, 'RNC', '52.422574', '-8.901910', 3),
(5, 'BSC', '53.543578', '-7.415803', 2),
(5, 'RNC', '54.070972', '-8.217765', 4),
(6, 'BSC', '53.729480', '-7.819035', 2),
(7, 'BSC', '54.013759', '-7.293390', 4),
(8, 'BSC', '54.236571', '-6.956156', 4),
(9, 'BSC', '53.058581', '-6.345666', 2),
(10, 'BSC', '52.345026', '-6.499798', 2),
(11, 'BSC', '53.028617', '-7.404794', 2),
(12, 'BSC', '52.665368', '-7.280513', 2),
(13, 'BSC', '52.822708', '-6.919637', 2),
(14, 'BSC', '53.209075', '-7.603574', 2),
(15, 'BSC', '52.672309', '-8.016707', 3),
(16, 'BSC', '52.251551', '-7.121785', 3),
(17, 'BSC', '52.914009', '-8.893029', 3),
(18, 'BSC', '52.637089', '-8.602674', 3),
(19, 'BSC', '51.878894', '-8.480903', 3),
(20, 'BSC', '52.059940', '-9.698286', 3),
(21, 'BSC', '52.639068', '-8.607996', 3),
(22, 'BSC', '54.290098', '-8.468456', 4),
(23, 'BSC', '53.616089', '-8.304720', 4),
(24, 'BSC', '53.977369', '-9.340027', 4),
(25, 'BSC', '53.295045', '-9.024714', 4),
(26, 'BSC', '54.840479', '-7.995946', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
