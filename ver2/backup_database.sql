-- MySQL dump 10.13  Distrib 5.7.28, for Linux (x86_64)
--
-- Host: localhost    Database: datasikkerhet
-- ------------------------------------------------------
-- Server version	5.7.28-0ubuntu0.18.04.4

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `brukernavn` varchar(50) NOT NULL,
  `passord` varchar(50) NOT NULL,
  PRIMARY KEY (`brukernavn`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('admin','sirkelkongen');
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
INSERT INTO `emner` VALUES ('a','a','a',1231),('ITF123','Datasikkerhet','tomhnatt@hotmail.com',1234),('ITF999','Databaser','edgar@hotmail.com',9999),('sbs','sjsj','edgar@hotmail.com',4933);
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
  `passord` varchar(50) NOT NULL,
  `bilde` varchar(50) NOT NULL,
  `godkjent` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`epost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foreleser`
--

LOCK TABLES `foreleser` WRITE;
/*!40000 ALTER TABLE `foreleser` DISABLE KEYS */;
INSERT INTO `foreleser` VALUES ('Tom Heine','a','a','birb.png',0),('Edgar Database Bostrom','edgar@hotmail.com','qwerty','birb.png',0),('roger','roger@hotmail.com','hei','birb.png',0),('Tom Heine Natt','tomhnatt@hotmail.com','drossap','birb.png',1);
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
  `avsender` varchar(50) NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `henvendelse`
--

LOCK TABLES `henvendelse` WRITE;
/*!40000 ALTER TABLE `henvendelse` DISABLE KEYS */;
INSERT INTO `henvendelse` VALUES (4,'alex@mail.com','a','a','hei',NULL,1),(5,'123@mail.com','a','a','Databaser er morsomt :)',NULL,0),(6,'lars@aol.com','edgar@hotmail.com','ITF999','hei',NULL,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kommentar`
--

LOCK TABLES `kommentar` WRITE;
/*!40000 ALTER TABLE `kommentar` DISABLE KEYS */;
INSERT INTO `kommentar` VALUES (1,'123@mail.com',4,'Bruh',0),(2,'alex@mail.com',4,'my dudes',1);
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
  `passord` varchar(50) NOT NULL,
  PRIMARY KEY (`epost`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('Alex','123@mail.com','Informatikk',2018,'nytt'),('abc','abc','abc',1234,'abc'),('alex','alex@epost.com','Informatikk',2018,''),('Alex','alex@mail.com','informatikk',2018,'hallais'),('ALEX','ALEXFJOMPEN@hotmail.com','BarnehagelÃ¦rer',1945,'hei'),('bjarne','b.jarne@aol.com','Informatikk',2018,'bruh'),('C','c@c.c','C',1,'c'),('jan Ã¥ge','eplekake@aol.no','Informatikk',123456,'www'),('Fredrik','f@f.f','Ingen',2,'a'),('Fed','ff@ff.no','Ingen',31,'hei'),('jens','jens@jens.com','jens',-1,'jens'),('JÃ¸rn','jorn@gmail.com','Informatikk',2018,'drossap'),('Lars','lars@aol.com','Informatikk',2018,'qwerty');
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

-- Dump completed on 2020-01-28 19:35:57
