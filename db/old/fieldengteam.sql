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
-- Table structure for table `fieldengteam`
--

CREATE TABLE IF NOT EXISTS `fieldengteam` (
  `fieldEngId` varchar(6) NOT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL,
  `teamRegion` varchar(20) NOT NULL,
  `teamLead` varchar(4) NOT NULL DEFAULT 'No',
  PRIMARY KEY (`fieldEngId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fieldengteam`
--

INSERT INTO `fieldengteam` (`fieldEngId`, `firstName`, `lastName`, `password`, `teamRegion`, `teamLead`) VALUES
('AA', 'Adam', 'Arkin', '7c6a180b36896a0a8c02787eeafb0e4c', 'Dublin', ''),
('BB', 'Barry', 'Byrne', '7c6a180b36896a0a8c02787eeafb0e4c', 'Dublin', 'Yes'),
('CC', 'Carl', 'Cooke', '7c6a180b36896a0a8c02787eeafb0e4c', 'Dublin', ''),
('DD', 'David', 'Dwyer', '7c6a180b36896a0a8c02787eeafb0e4c', 'Dublin', ''),
('EE', 'Eddie', 'Evans', '7c6a180b36896a0a8c02787eeafb0e4c', 'North Leinster', 'Yes'),
('FF', 'Fergus', 'Frampton', '7c6a180b36896a0a8c02787eeafb0e4c', 'North Leinster', 'No'),
('GG', 'Gerald', 'Gaffney', '7c6a180b36896a0a8c02787eeafb0e4c', 'North Leinster', 'No'),
('HH', 'Henry', 'Hall', '7c6a180b36896a0a8c02787eeafb0e4c', 'North Leinster', 'No'),
('II', 'Ian', 'Ivers', '7c6a180b36896a0a8c02787eeafb0e4c', 'South Leinster', 'No'),
('JJ', 'John', 'Jones', '7c6a180b36896a0a8c02787eeafb0e4c', 'South Leinster', 'No'),
('KK', 'Kevin', 'Kelly', '7c6a180b36896a0a8c02787eeafb0e4c', 'South Leinster', 'Yes'),
('LL', 'Liam', 'Lynch', '7c6a180b36896a0a8c02787eeafb0e4c', 'South Leinster', 'No'),
('MM', 'Mark', 'Mooney', '7c6a180b36896a0a8c02787eeafb0e4c', 'South West', 'No'),
('NN', 'Noel', 'Nally', '7c6a180b36896a0a8c02787eeafb0e4c', 'South West', 'No'),
('OO', 'Oscar', 'Owens', '7c6a180b36896a0a8c02787eeafb0e4c', 'South West', 'No'),
('PP', 'Peter', 'Prunty', '7c6a180b36896a0a8c02787eeafb0e4c', 'South West', 'Yes'),
('QQ', 'Quinten', 'Quinn', '7c6a180b36896a0a8c02787eeafb0e4c', 'North West', 'No'),
('RR', 'Robert', 'Reilly', '7c6a180b36896a0a8c02787eeafb0e4c', 'North West', 'No'),
('SS', 'Steven', 'Simmons', '7c6a180b36896a0a8c02787eeafb0e4c', 'North West', 'No'),
('TT', 'Terry', 'Tierney', '7c6a180b36896a0a8c02787eeafb0e4c', 'North West', 'Yes');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
