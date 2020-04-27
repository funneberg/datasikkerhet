-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: datasikkerhet
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Current Database: `datasikkerhet`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `datasikkerhet` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `datasikkerhet`;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `brukernavn` varchar(50) NOT NULL,
  `passord` varchar(255) NOT NULL,
  PRIMARY KEY (`brukernavn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','$2y$10$aZRtfFyoVo8Lzq1/Ob28zegu0CxmAXKVBH8LCGyLlgDD0sRq2nJ.e');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emner`
--

DROP TABLE IF EXISTS `emner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emner` (
  `emnekode` varchar(8) NOT NULL,
  `emnenavn` varchar(50) NOT NULL,
  `foreleser` varchar(50) NOT NULL,
  `pin` int(4) DEFAULT NULL,
  PRIMARY KEY (`emnekode`),
  UNIQUE KEY `pin` (`pin`),
  KEY `foreleser` (`foreleser`),
  CONSTRAINT `emner_ibfk_1` FOREIGN KEY (`foreleser`) REFERENCES `foreleser` (`epost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emner`
--

LOCK TABLES `emner` WRITE;
/*!40000 ALTER TABLE `emner` DISABLE KEYS */;
INSERT INTO `emner` VALUES ('IT420','Datasikkerhet i utvikling og drift','bjarne@aol.com',1234);
/*!40000 ALTER TABLE `emner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foreleser`
--

DROP TABLE IF EXISTS `foreleser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foreleser` (
  `navn` varchar(50) NOT NULL,
  `epost` varchar(50) NOT NULL,
  `passord` varchar(255) NOT NULL,
  `bilde` varchar(255) NOT NULL,
  `godkjent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`epost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foreleser`
--

LOCK TABLES `foreleser` WRITE;
/*!40000 ALTER TABLE `foreleser` DISABLE KEYS */;
INSERT INTO `foreleser` VALUES ('Bjarne','bjarne@aol.com','$2y$10$IhXuJbSiFiILjtQU3t87HOlandYYX5lBnSMYOESvFAjAC1hn/qKBu','447f5313670f472dd1d99a5f7e6ab6348a8617d880a1613333f7c7aba1a45ee3.png',1);
/*!40000 ALTER TABLE `foreleser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `henvendelse`
--

DROP TABLE IF EXISTS `henvendelse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `henvendelse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avsender` varchar(255) DEFAULT NULL,
  `mottaker` varchar(50) NOT NULL,
  `emnekode` varchar(8) NOT NULL,
  `henvendelse` text NOT NULL,
  `svar` text,
  `rapportert` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `avsender` (`avsender`),
  KEY `mottaker` (`mottaker`),
  KEY `emnekode` (`emnekode`),
  CONSTRAINT `henvendelse_ibfk_1` FOREIGN KEY (`avsender`) REFERENCES `student` (`epost`),
  CONSTRAINT `henvendelse_ibfk_2` FOREIGN KEY (`mottaker`) REFERENCES `foreleser` (`epost`),
  CONSTRAINT `henvendelse_ibfk_3` FOREIGN KEY (`emnekode`) REFERENCES `emner` (`emnekode`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `henvendelse`
--

LOCK TABLES `henvendelse` WRITE;
/*!40000 ALTER TABLE `henvendelse` DISABLE KEYS */;
INSERT INTO `henvendelse` VALUES (3,'stein@aol.com','bjarne@aol.com','IT420','Hei','Test xD',0);
/*!40000 ALTER TABLE `henvendelse` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kommentar`
--

DROP TABLE IF EXISTS `kommentar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kommentar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `avsender` varchar(50) DEFAULT NULL,
  `kommentar_til` int(11) NOT NULL,
  `kommentar` text NOT NULL,
  `rapportert` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `avsender` (`avsender`),
  KEY `kommentar_til` (`kommentar_til`),
  CONSTRAINT `kommentar_ibfk_1` FOREIGN KEY (`avsender`) REFERENCES `student` (`epost`),
  CONSTRAINT `kommentar_ibfk_2` FOREIGN KEY (`kommentar_til`) REFERENCES `henvendelse` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kommentar`
--

LOCK TABLES `kommentar` WRITE;
/*!40000 ALTER TABLE `kommentar` DISABLE KEYS */;
/*!40000 ALTER TABLE `kommentar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `navn` varchar(50) NOT NULL,
  `epost` varchar(50) NOT NULL,
  `studieretning` varchar(50) NOT NULL,
  `kull` int(4) NOT NULL,
  `passord` varchar(255) NOT NULL,
  PRIMARY KEY (`epost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('Stein','stein@aol.com','Informatikk',2018,'$2y$10$UzmVc5ufe0xVGB331qqaiOHTLlEDuQkxTRBnTBtddxtRctra5oSlC');
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-04-26 13:00:38
