-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 13, 2012 at 01:06 PM
-- Server version: 5.1.66
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `push`
--

-- --------------------------------------------------------

--
-- Table structure for table `AndroidDevices`
--

DROP TABLE IF EXISTS `AndroidDevices`;
CREATE TABLE IF NOT EXISTS `AndroidDevices` (
  `DeviceId` int(32) NOT NULL AUTO_INCREMENT,
  `RegistrationID` varchar(512) CHARACTER SET latin1 NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Activate` bit(1) NOT NULL DEFAULT b'1',
  `Longitude` double DEFAULT NULL,
  `Latitude` double DEFAULT NULL,
  `Country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `City` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EcardNo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NoAlertTimeStart` time DEFAULT NULL,
  `NoAlertTimeEnd` time DEFAULT NULL,
  PRIMARY KEY (`DeviceId`),
  UNIQUE KEY `RegistrationID_UNIQUE` (`RegistrationID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `AppleDevices`
--

DROP TABLE IF EXISTS `AppleDevices`;
CREATE TABLE IF NOT EXISTS `AppleDevices` (
  `DeviceId` int(32) NOT NULL AUTO_INCREMENT,
  `DeviceToken` varchar(71) COLLATE utf8_unicode_ci NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Activate` bit(1) NOT NULL DEFAULT b'1',
  `Longitude` double DEFAULT NULL,
  `Latitude` double DEFAULT NULL,
  `Country` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `City` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EcardNo` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `NoAlertTimeStart` time DEFAULT NULL,
  `NoAlertTimeEnd` time DEFAULT NULL,
  PRIMARY KEY (`DeviceId`),
  UNIQUE KEY `DeviceToken_UNIQUE` (`DeviceToken`),
  KEY `DeviceToken` (`DeviceToken`),
  KEY `DeviceToken_test` (`DeviceToken`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `FeedDevices`
--

DROP TABLE IF EXISTS `FeedDevices`;
CREATE TABLE IF NOT EXISTS `FeedDevices` (
  `FeedDeviceId` int(11) NOT NULL AUTO_INCREMENT,
  `FeedId` int(11) NOT NULL,
  `AppDeviceId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`FeedDeviceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `FeedDevices`
--


-- --------------------------------------------------------

--
-- Table structure for table `Feeds`
--

DROP TABLE IF EXISTS `Feeds`;
CREATE TABLE IF NOT EXISTS `Feeds` (
  `FeedId` int(11) NOT NULL AUTO_INCREMENT,
  `FeedName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `FeedUrl` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `DateLastChecked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateLastUpdated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FeedId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Feeds`
--


-- --------------------------------------------------------

--
-- Table structure for table `MessageBatch`
--

DROP TABLE IF EXISTS `MessageBatch`;
CREATE TABLE IF NOT EXISTS `MessageBatch` (
  `BatchID` int(11) NOT NULL AUTO_INCREMENT,
  `UserID` int(11) NOT NULL,
  `ReviewedBy` int(11) DEFAULT NULL,
  `Devices` smallint(6) NOT NULL DEFAULT '3',
  `Message` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `Sound` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Badge` int(11) DEFAULT NULL,
  `KeyValue` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ECardNos` text COLLATE utf8_unicode_ci,
  `Country` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `City` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Longitude` double DEFAULT NULL,
  `Latitude` double DEFAULT NULL,
  `Distance` double DEFAULT NULL,
  `Status` int(11) NOT NULL DEFAULT '0',
  `DateCreated` datetime NOT NULL,
  `PublishDate` datetime DEFAULT NULL,
  `MUserID` int(11) DEFAULT NULL,
  `MRole` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`BatchID`),
  KEY `fk_MessageBatch_1` (`UserID`),
  KEY `fk_MessageBatch_2` (`ReviewedBy`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

--
-- Triggers `MessageBatch`
--
DROP TRIGGER IF EXISTS `push`.`MessageBatch_Insert`;
DELIMITER //
CREATE TRIGGER `push`.`MessageBatch_Insert` BEFORE INSERT ON `push`.`MessageBatch`
 FOR EACH ROW BEGIN
SET NEW.DateCreated = UTC_TIMESTAMP();
END
//
DELIMITER ;
--
-- Table structure for table `MessageQueue`
--

DROP TABLE IF EXISTS `MessageQueue`;
CREATE TABLE IF NOT EXISTS `MessageQueue` (
  `MessageID` int(32) NOT NULL AUTO_INCREMENT,
  `BatchID` int(32) NOT NULL,
  `DeviceToken` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RegistrationID` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MessageID`),
  KEY `fk_MessageQueue_1` (`BatchID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=107 ;

--
-- Table structure for table `Profile`
--

DROP TABLE IF EXISTS `Profile`;
CREATE TABLE IF NOT EXISTS `Profile` (
  `ProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `ProfileName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `CertificateName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Mode` bit(1) NOT NULL,
  `APIKey` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ProfileID`),
  UNIQUE KEY `ProfileName_UNIQUE` (`ProfileName`),
  UNIQUE KEY `CertificateName_UNIQUE` (`CertificateName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Profile`
--


-- --------------------------------------------------------

--
-- Table structure for table `Servers`
--

DROP TABLE IF EXISTS `Servers`;
CREATE TABLE IF NOT EXISTS `Servers` (
  `ServerId` int(11) NOT NULL AUTO_INCREMENT,
  `Server Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ServerUrl` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ServerTypeId` int(11) NOT NULL,
  PRIMARY KEY (`ServerId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Servers`
--

INSERT INTO `Servers` (`ServerId`, `Server Name`, `ServerUrl`, `ServerTypeId`) VALUES
(1, 'Development Push Notitification Server', 'ssl://gateway.sandbox.push.apple.com:2195', 1),
(2, 'Production - Push Notification Server', 'ssl://gateway.push.apple.com:2195', 1),
(3, 'Development - Feedback Server', 'ssl://feedback.sandbox.push.apple.com:2196', 2),
(4, 'Production - Feedback Server', 'ssl://feedback.push.apple.com:2196', 2);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
CREATE TABLE IF NOT EXISTS `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `DisplayName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Type` smallint(6) NOT NULL DEFAULT '2' COMMENT '0: super admin (can manage users)\n1: admin\n2: user \n3: child (can create message batch but cannot send, an admin has to review them)',
  `Devices` smallint(6) NOT NULL DEFAULT '3' COMMENT '1: iOS\n2: Android\n3: All',
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`UserID`, `Name`, `DisplayName`, `Password`, `Type`, `Devices`, `IsActive`) VALUES
(1, 'superadmin', 'super admin', '202cb962ac59075b964b07152d234b70', 0, 3, ''),
(2, 'admin', 'an admin', '202cb962ac59075b964b07152d234b70', 1, 3, ''),
(3, 'dasun', 'Thanuka Piyasena', '202cb962ac59075b964b07152d234b70', 1, 3, ''),
(4, 'testuser', 'test user', 'e10adc3949ba59abbe56e057f20f883e', 2, 3, '');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `MessageBatch`
--
ALTER TABLE `MessageBatch`
  ADD CONSTRAINT `fk_MessageBatch_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_MessageBatch_2` FOREIGN KEY (`ReviewedBy`) REFERENCES `Users` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `MessageQueue`
--
ALTER TABLE `MessageQueue`
  ADD CONSTRAINT `fk_MessageQueue_1` FOREIGN KEY (`BatchID`) REFERENCES `MessageBatch` (`BatchID`) ON DELETE NO ACTION ON UPDATE NO ACTION;
