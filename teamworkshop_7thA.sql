-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: teamworkshop_7tha
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `customer_management`
--

DROP TABLE IF EXISTS `customer_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer_management` (
  `CID` varchar(5) NOT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Phone` int(12) DEFAULT NULL,
  `Card_info` int(16) DEFAULT NULL,
  `Password` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`CID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_management`
--

LOCK TABLES `customer_management` WRITE;
/*!40000 ALTER TABLE `customer_management` DISABLE KEYS */;
INSERT INTO `customer_management` VALUES ('C001','kari','karidesu',2147483647,2147483647,'abc123');
/*!40000 ALTER TABLE `customer_management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_detail` (
  `ODID` varchar(6) NOT NULL,
  `OID` varchar(5) DEFAULT NULL,
  `SID` varchar(5) DEFAULT NULL,
  `Order_quantity` int(11) DEFAULT NULL,
  `Total_price` int(11) DEFAULT NULL,
  PRIMARY KEY (`ODID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_detail`
--

LOCK TABLES `order_detail` WRITE;
/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
INSERT INTO `order_detail` VALUES ('OD001','O001','S001',3,300),('OD002','O001','S002',5,1000),('OD003','O001','S006',2,1200),('OD004','O002','S002',5,1000),('OD005','O002','S004',5,2000),('OD006','O002','S009',7,3600),('OD007','O002','S010',4,4000),('OD008','O002','S015',1,1500);
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_management`
--

DROP TABLE IF EXISTS `order_management`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_management` (
  `OID` varchar(5) NOT NULL,
  `Date_time` datetime NOT NULL,
  `CID` varchar(5) NOT NULL,
  `Grand_total_price` int(11) NOT NULL,
  PRIMARY KEY (`OID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_management`
--

LOCK TABLES `order_management` WRITE;
/*!40000 ALTER TABLE `order_management` DISABLE KEYS */;
INSERT INTO `order_management` VALUES ('O001','2024-04-11 08:49:25','C001',2500),('O002','2024-04-11 08:49:49','C001',12100);
/*!40000 ALTER TABLE `order_management` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poke_graphics`
--

DROP TABLE IF EXISTS `poke_graphics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poke_graphics` (
  `GID` varchar(5) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`GID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poke_graphics`
--

LOCK TABLES `poke_graphics` WRITE;
/*!40000 ALTER TABLE `poke_graphics` DISABLE KEYS */;
INSERT INTO `poke_graphics` VALUES ('G001',NULL),('G002',NULL),('G003',NULL),('G004',NULL),('G005',NULL),('G006',NULL),('G007',NULL),('G008',NULL),('G009',NULL),('G010',NULL),('G011',NULL),('G012',NULL),('G013',NULL),('G014',NULL),('G015',NULL);
/*!40000 ALTER TABLE `poke_graphics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poke_info`
--

DROP TABLE IF EXISTS `poke_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poke_info` (
  `PID` varchar(5) NOT NULL,
  `Name` varchar(10) NOT NULL,
  `Type1` varchar(10) NOT NULL,
  `Type2` varchar(10) DEFAULT NULL,
  `GID` varchar(5) NOT NULL,
  PRIMARY KEY (`PID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poke_info`
--

LOCK TABLES `poke_info` WRITE;
/*!40000 ALTER TABLE `poke_info` DISABLE KEYS */;
INSERT INTO `poke_info` VALUES ('P001','ナックラー','T09ZMN',NULL,'G001'),('P002','エレズン','T04DNK','T08DOK','G002'),('P003','グラードン','T09ZMN','T02HNO','G003'),('P004','ワナイダー','T12MUS',NULL,'G004'),('P005','ユキハミ','T06KOR','T12MUS','G005'),('P006','クワガノン','T12MUS','T04DNK','G006'),('P007','タイレーツ','T07KKT',NULL,'G007'),('P008','コライドン','T07KKT','T15DGN','G008'),('P009','ワンリキー','T07KKT',NULL,'G009'),('P010','コノヨザル','T07KKT','T14GST','G010'),('P011','ミミッキュ','T14GST','T18FRY','G011'),('P012','ゲンガー','T14GST','T08DOK','G012'),('P013','イルカマン','T03MIZ',NULL,'G013'),('P014','ヌオー','T03MIZ','T09ZMN','G014'),('P015','ハギギシリ','T03MIZ','T11ESP','G015');
/*!40000 ALTER TABLE `poke_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poke_type`
--

DROP TABLE IF EXISTS `poke_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `poke_type` (
  `TID` varchar(10) NOT NULL,
  `type_name` varchar(10) NOT NULL,
  PRIMARY KEY (`TID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poke_type`
--

LOCK TABLES `poke_type` WRITE;
/*!40000 ALTER TABLE `poke_type` DISABLE KEYS */;
INSERT INTO `poke_type` VALUES ('T01NML','ノーマル'),('T02HNO','ほのお'),('T03MIZ','みず'),('T04DNK','でんき'),('T05KUS','くさ'),('T06KOR','こおり'),('T07KKT','かくとう'),('T08DOK','どく'),('T09ZMN','じめん'),('T10HKU','ひこう'),('T11ESP','エスパー'),('T12MUS','むし'),('T13IWA','いわ'),('T14GST','ゴースト'),('T15DGN','ドラゴン'),('T16AKU','あく'),('T17HGN','はがね'),('T18FRY','フェアリー');
/*!40000 ALTER TABLE `poke_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_stock`
--

DROP TABLE IF EXISTS `product_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_stock` (
  `SID` varchar(5) NOT NULL,
  `PID` varchar(5) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `Price` int(10) NOT NULL,
  `Inventory` int(11) NOT NULL,
  PRIMARY KEY (`SID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_stock`
--

LOCK TABLES `product_stock` WRITE;
/*!40000 ALTER TABLE `product_stock` DISABLE KEYS */;
INSERT INTO `product_stock` VALUES ('S001','P001','M',100,10),('S002','P002','M',200,10),('S003','P003','M',300,10),('S004','P004','M',400,10),('S005','P005','M',500,10),('S006','P006','M',600,10),('S007','P007','M',700,10),('S008','P008','M',800,10),('S009','P009','M',900,10),('S010','P010','M',1000,10),('S011','P011','M',1100,10),('S012','P012','M',1200,10),('S013','P013','M',1300,10),('S014','P014','M',1400,10),('S015','P015','M',1500,10);
/*!40000 ALTER TABLE `product_stock` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-04-25 15:11:03
