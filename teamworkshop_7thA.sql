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
INSERT INTO `order_detail` VALUES ('OD001','O001','S001',1,100),('OD002','O001','S002',5,1000),('OD003','O001','S003',3,900),('OD004','O002','S004',7,2800),('OD005','O002','S005',9,4500),('OD006','O002','S006',5,3000),('OD007','O002','S007',4,2800),('OD008','O002','S008',4,3200),('OD009','O003','S004',7,2800),('OD010','O003','S005',9,4500),('OD011','O003','S006',5,3000),('OD012','O003','S007',4,2800),('OD013','O003','S008',4,3200),('OD014','O004','S001',1,100),('OD015','O005','S001',1,100),('OD016','O006','S015',10,15000),('OD017','O007','S001',8,800),('OD018','O007','S002',10,2000),('OD019','O007','S003',10,3000),('OD020','O007','S004',3,1200),('OD021','O007','S005',1,500),('OD022','O007','S006',5,3000),('OD023','O007','S007',6,4200),('OD024','O007','S008',6,4800),('OD025','O007','S009',10,9000),('OD026','O007','S010',10,10000),('OD027','O007','S011',10,11000),('OD028','O007','S012',10,12000),('OD029','O007','S013',10,13000),('OD030','O007','S014',10,14000),('OD031','O008','S001',4,400),('OD032','O009','S001',12,1200),('OD033','O010','S001',10,1000),('OD034','O011','S001',1,100),('OD035','O012','S001',12,1200),('OD036','O013','S001',32,3200),('OD037','O014','S002',3,600),('OD038','O015','S002',3,600),('OD039','O016','S002',3,600),('OD040','O017','S002',3,600),('OD041','O018','S002',3,600),('OD042','O019','S001',1,100),('OD043','O020','S002',4,3200),('OD044','O021','S003',11,3300),('OD045','O022','S002',3,600),('OD046','O023','S003',13,3900),('OD047','O024','S003',13,3900),('OD048','O025','S002',13,2600),('OD049','O026','S002',13,2600),('OD050','O027','S002',13,2600),('OD051','O028','S002',13,2600),('OD052','O029','S002',11,2200),('OD053','O029','S003',15,4500);
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
INSERT INTO `order_management` VALUES ('O001','2024-04-27 16:09:05','C001',2000),('O002','2024-04-27 16:10:29','C001',16300),('O003','2024-04-27 16:27:54','C001',16300),('O004','2024-04-27 16:33:59','C001',100),('O005','2024-04-27 16:34:46','C001',100),('O006','2024-04-27 17:23:04','C001',15000),('O007','2024-04-27 17:26:43','C001',88500),('O008','2024-04-28 03:07:29','C001',400),('O009','2024-04-28 12:01:46','C001',1200),('O010','2024-04-28 12:12:15','C001',1000),('O011','2024-04-28 12:28:22','C001',100),('O012','2024-04-28 12:44:22','C001',1200),('O013','2024-04-28 12:46:54','C001',3200),('O014','2024-04-28 13:26:26','C001',600),('O015','2024-04-28 13:27:07','C001',600),('O016','2024-04-28 13:28:46','C001',600),('O017','2024-04-28 13:29:55','C001',600),('O018','2024-04-28 13:30:52','C001',600),('O019','2024-04-28 13:34:43','C001',100),('O020','2024-04-28 13:36:35','C001',3200),('O021','2024-04-28 13:39:02','C001',3300),('O022','2024-04-28 13:40:12','C001',600),('O023','2024-04-28 14:33:42','C001',3900),('O024','2024-04-28 14:37:12','C001',3900),('O025','2024-04-28 14:37:36','C001',2600),('O026','2024-04-28 14:39:23','C001',2600),('O027','2024-04-28 14:42:49','C001',2600),('O028','2024-04-28 14:42:52','C001',2600),('O029','2024-04-28 14:43:36','C001',6700);
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
INSERT INTO `poke_graphics` VALUES ('G001','./images/pokemon/pokemon_001_nuckrar.jpg'),('G002','./images/pokemon/pokemon_002_eleson.jpg'),('G003','./images/pokemon/pokemon_003_groudon.jpg'),('G004','./images/pokemon/pokemon_004_wanaider.jpg'),('G005','./images/pokemon/pokemon_005_yukihami.jpg'),('G006','./images/pokemon/pokemon_006_kuwagannon.jpg'),('G007','./images/pokemon/pokemon_007_tairetsu.jpg'),('G008','./images/pokemon/pokemon_008_koraidon.jpg'),('G009','./images/pokemon/pokemon_009_wanriky.jpg'),('G010','./images/pokemon/pokemon_010_konoyozaru.jpg'),('G011','./images/pokemon/pokemon_011_mimikkyu.jpg'),('G012','./images/pokemon/pokemon_012_gangar.jpg'),('G013','./images/pokemon/pokemon_013_irukaman.jpg'),('G014','./images/pokemon/pokemon_014_nuoh.jpg'),('G015','./images/pokemon/pokemon_015_hagigishiri.jpg');
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
INSERT INTO `product_stock` VALUES ('S001','P001','M',100,0),('S002','P002','M',200,15),('S003','P003','M',300,48),('S004','P004','M',400,0),('S005','P005','M',500,0),('S006','P006','M',600,0),('S007','P007','M',700,0),('S008','P008','M',800,0),('S009','P009','M',900,0),('S010','P010','M',1000,0),('S011','P011','M',1100,0),('S012','P012','M',1200,0),('S013','P013','M',1300,0),('S014','P014','M',1400,0),('S015','P015','M',1500,0);
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

-- Dump completed on 2024-04-30 11:07:48
