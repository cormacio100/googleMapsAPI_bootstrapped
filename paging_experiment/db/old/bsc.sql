-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 25, 2015 at 03:44 AM
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
-- Table structure for table `bsc`
--

CREATE TABLE IF NOT EXISTS `bsc` (
  `bsc` int(11) NOT NULL,
  `bscLatitude` varchar(15) NOT NULL,
  `bscLongitude` varchar(15) NOT NULL,
  `controllerMSC` int(11) NOT NULL,
  PRIMARY KEY (`bsc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bsc`
--

INSERT INTO `bsc` (`bsc`, `bscLatitude`, `bscLongitude`, `controllerMSC`) VALUES
(1, '53.300937', '-6.418035', 1),
(2, '53.877491', '-6.449989', 2),
(3, '53.622489', '-6.617510', 2),
(4, '53.168825', '-6.943560', 2),
(5, '53.543578', '-7.415803', 2),
(6, '53.729480', '-7.819035', 2),
(7, '54.013759', '-7.293390', 4),
(8, '54.236571', '-6.956156', 4),
(9, '53.058581', '-6.345666', 2),
(10, '52.345026', '-6.499798', 2),
(11, '53.028617', '-7.404794', 2),
(12, '52.665368', '-7.280513', 2),
(13, '52.822708', '-6.919637', 2),
(14, '53.209075', '-7.603574', 2),
(15, '52.672309', '-8.016707', 3),
(16, '52.251551', '-7.121785', 3),
(17, '52.914009', '-8.893029', 3),
(18, '52.637089', '-8.602674', 3),
(19, '51.878894', '-8.480903', 3),
(20, '52.059940', '-9.698286', 3),
(21, '52.639068', '-8.607996', 3),
(22, '54.290098', '-8.468456', 4),
(23, '53.616089', '-8.304720', 4),
(24, '53.977369', '-9.340027', 4),
(25, '53.295045', '-9.024714', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
