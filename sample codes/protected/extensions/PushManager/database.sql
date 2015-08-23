-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: push
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `AndroidDevices`
--

DROP TABLE IF EXISTS `AndroidDevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AndroidDevices` (
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `AppleDevices`
--

DROP TABLE IF EXISTS `AppleDevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AppleDevices` (
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `FeedDevices`
--

DROP TABLE IF EXISTS `FeedDevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `FeedDevices` (
  `FeedDeviceId` int(11) NOT NULL AUTO_INCREMENT,
  `FeedId` int(11) NOT NULL,
  `AppDeviceId` int(11) NOT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateUpdated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`FeedDeviceId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Feeds`
--

DROP TABLE IF EXISTS `Feeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Feeds` (
  `FeedId` int(11) NOT NULL AUTO_INCREMENT,
  `FeedName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `FeedUrl` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `DateLastChecked` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DateLastUpdated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`FeedId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MessageBatch`
--

DROP TABLE IF EXISTS `MessageBatch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MessageBatch` (
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
  `DateCreated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DatePublished` datetime DEFAULT NULL,
  PRIMARY KEY (`BatchID`),
  KEY `fk_MessageBatch_1` (`UserID`),
  KEY `fk_MessageBatch_2` (`ReviewedBy`),
  CONSTRAINT `fk_MessageBatch_1` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_MessageBatch_2` FOREIGN KEY (`ReviewedBy`) REFERENCES `Users` (`UserID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MessageQueue`
--

DROP TABLE IF EXISTS `MessageQueue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MessageQueue` (
  `MessageID` int(32) NOT NULL AUTO_INCREMENT,
  `BatchID` int(32) NOT NULL,
  `DeviceToken` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RegistrationID` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`MessageID`),
  KEY `fk_MessageQueue_1` (`BatchID`),
  CONSTRAINT `fk_MessageQueue_1` FOREIGN KEY (`BatchID`) REFERENCES `MessageBatch` (`BatchID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Profile`
--

DROP TABLE IF EXISTS `Profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Profile` (
  `ProfileID` int(11) NOT NULL AUTO_INCREMENT,
  `ProfileName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `CertificateName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Mode` bit(1) NOT NULL,
  `APIKey` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ProfileID`),
  UNIQUE KEY `ProfileName_UNIQUE` (`ProfileName`),
  UNIQUE KEY `CertificateName_UNIQUE` (`CertificateName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Servers`
--

DROP TABLE IF EXISTS `Servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Servers` (
  `ServerId` int(11) NOT NULL AUTO_INCREMENT,
  `Server Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `ServerUrl` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `ServerTypeId` int(11) NOT NULL,
  PRIMARY KEY (`ServerId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `DisplayName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Type` smallint(6) NOT NULL DEFAULT '2' COMMENT '0: super admin (can manage users)\n1: admin\n2: user \n3: child (can create message batch but cannot send, an admin has to review them)',
  `Devices` smallint(6) NOT NULL DEFAULT '3' COMMENT '1: iOS\n2: Android\n3: All',
  `IsActive` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-25 12:11:55
-- MySQL dump 10.13  Distrib 5.5.28, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: push
-- ------------------------------------------------------
-- Server version	5.5.28-0ubuntu0.12.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'superadmin','super admin','202cb962ac59075b964b07152d234b70',0,3,''),(2,'admin','an admin','202cb962ac59075b964b07152d234b70',1,3,''),(6,'dasun','dasun sameera','202cb962ac59075b964b07152d234b70',1,3,''),(7,'testuser','test user','e10adc3949ba59abbe56e057f20f883e',2,3,'');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-11-25 12:13:34
