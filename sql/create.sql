-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: uqbarwik_payments
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.10.1

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
-- Table structure for table `google_user`
--

DROP TABLE IF EXISTS `google_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `google_user` (
  `idGoogleUser` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(250) NOT NULL,
  `displayName` varchar(250) NOT NULL,
  `userInfo` text NOT NULL,
  PRIMARY KEY (`idGoogleUser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `google_user`
--

LOCK TABLES `google_user` WRITE;
/*!40000 ALTER TABLE `google_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `google_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ipn_notifications`
--

DROP TABLE IF EXISTS `ipn_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ipn_notifications` (
  `idIPNNotification` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(20) NOT NULL,
  `idOperation` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `responseCode` int(11) NOT NULL,
  `responseJSON` text NOT NULL,
  PRIMARY KEY (`idIPNNotification`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ipn_notifications`
--

LOCK TABLES `ipn_notifications` WRITE;
/*!40000 ALTER TABLE `ipn_notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `ipn_notifications` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-21 15:18:30
