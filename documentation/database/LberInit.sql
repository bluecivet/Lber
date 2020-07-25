-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2020 at 06:26 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lber`
--

-- --------------------------------------------------------

--
-- Table structure for table `currentorders`
--

CREATE TABLE IF NOT EXISTS `currentorders` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `orderName` varchar(20) DEFAULT NULL,
  `carring` varchar(30) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `fromAddress` tinytext NOT NULL,
  `toAddress` tinytext NOT NULL,
  `deliveryDate` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`orderId`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `driverinfo`
--

CREATE TABLE IF NOT EXISTS `driverinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `selfDescription` tinytext DEFAULT NULL,
  `carType` varchar(30) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `driverinfo`
--

INSERT INTO `driverinfo` (`id`, `userName`, `selfDescription`, `carType`, `password`) VALUES
(12, 'Andy', NULL, NULL, '123'),
(13, 'Bend', NULL, NULL, '123'),
(14, 'Denny', NULL, NULL, '123');

-- --------------------------------------------------------

--
-- Table structure for table `generaluser`
--

CREATE TABLE IF NOT EXISTS `generaluser` (
  `generalId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `driverId` int(11) DEFAULT NULL,
  `firstName` varchar(20) NOT NULL,
  `lastName` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `age` tinyint(4) DEFAULT NULL,
  `birthDate` date NOT NULL,
  `point` int(11) DEFAULT 0,
  `rigesterTime` datetime DEFAULT NULL,
  PRIMARY KEY (`generalId`),
  UNIQUE KEY `driverId` (`driverId`),
  UNIQUE KEY `userId` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `generaluser`
--

INSERT INTO `generaluser` (`generalId`, `userId`, `driverId`, `firstName`, `lastName`, `email`, `phone`, `age`, `birthDate`, `point`, `rigesterTime`) VALUES
(1, 28, 13, 'firstOne', 'lastOne', 'test@test.com', '7781233215', 23, '2020-05-03', 100, '2020-07-25 05:52:30'),
(2, 29, 12, 'dfirstOne', 'dlastOne', 'test@test.com', '7783214569', 20, '2020-07-01', 100, '2020-07-25 05:53:48'),
(3, 30, NULL, 'testfirstTwo', 'testLastTwo', 'test2@test.com', '7781231231', 20, '2020-06-28', 250, '2020-07-25 05:58:40'),
(4, NULL, 14, 'testThree', 'lastThree', 'test@test.com', '7781231231', 35, '2020-06-29', 50, '2020-07-25 06:00:03');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `orderId` int(11) NOT NULL AUTO_INCREMENT,
  `orderName` varchar(20) DEFAULT NULL,
  `carring` varchar(30) DEFAULT NULL,
  `placeOrderTime` datetime NOT NULL,
  `finishOrderTime` datetime DEFAULT NULL,
  `driverId` int(11) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `finishState` tinyint(1) DEFAULT 0,
  `waitingState` tinyint(1) DEFAULT 0,
  `fromAddress` tinytext NOT NULL,
  `toAddress` tinytext NOT NULL,
  `description` text DEFAULT NULL,
  `deliveryDate` date NOT NULL,
  PRIMARY KEY (`orderId`),
  KEY `userId` (`userId`),
  KEY `driverId` (`driverId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `orderName`, `carring`, `placeOrderTime`, `finishOrderTime`, `driverId`, `userId`, `finishState`, `waitingState`, `fromAddress`, `toAddress`, `description`, `deliveryDate`) VALUES
(53, 'candyo1', 'box', '2020-07-25 06:02:37', NULL, 12, 30, 1, 0, 'Langara Vancouver', 'UBC Vancouver', 'this is candy order1', '2020-07-28'),
(54, 'bentest1', 'box', '2020-07-25 06:05:12', NULL, 12, 28, 1, 0, 'Gladstone Secondary School Vancouver', 'Queen Elizabeth Park Vancouver', 'this is ben order1', '2020-07-31'),
(55, 'bentest2', 'box', '2020-07-25 06:19:10', NULL, 14, 28, 1, 0, 'Langara Vancouver', 'UBC Vancouver', 'ben order test2', '2020-08-06');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE IF NOT EXISTS `userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(30) NOT NULL,
  `selfDescription` tinytext DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `userName`, `selfDescription`, `password`) VALUES
(28, 'Ben', NULL, '123'),
(29, 'Andyu', NULL, '123'),
(30, 'Candy', NULL, '123');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `currentorders`
--
ALTER TABLE `currentorders`
  ADD CONSTRAINT `currentorders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `currentorders_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`);

--
-- Constraints for table `generaluser`
--
ALTER TABLE `generaluser`
  ADD CONSTRAINT `generaluser_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `generaluser_ibfk_2` FOREIGN KEY (`driverId`) REFERENCES `driverinfo` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `userinfo` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`driverId`) REFERENCES `driverinfo` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
