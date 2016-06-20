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
-- Table structure for table `rnc`
--

CREATE TABLE IF NOT EXISTS `rnc` (
  `rnc` int(11) NOT NULL,
  `rncLatitude` varchar(15) NOT NULL,
  `rncLongitude` varchar(15) NOT NULL,
  `controllerMSC` int(11) NOT NULL,
  PRIMARY KEY (`rnc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rnc`
--

INSERT INTO `rnc` (`rnc`, `rncLatitude`, `rncLongitude`, `controllerMSC`) VALUES
(1, '53.298064', '-6.417692', 1),
(2, '53.721141', '-7.094659', 2),
(3, '52.782881', '-7.281427', 2),
(4, '52.422574', '-8.901910', 3),
(5, '54.070972', '-8.217765', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
