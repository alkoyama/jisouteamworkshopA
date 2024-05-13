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
INSERT INTO `order_detail` VALUES ('OD001','O001','S001',1,100),('OD002','O001','S002',5,1000),('OD003','O001','S003',3,900),('OD004','O002','S004',7,2800),('OD005','O002','S005',9,4500),('OD006','O002','S006',5,3000),('OD007','O002','S007',4,2800),('OD008','O002','S008',4,3200),('OD009','O003','S004',7,2800),('OD010','O003','S005',9,4500),('OD011','O003','S006',5,3000),('OD012','O003','S007',4,2800),('OD013','O003','S008',4,3200);
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
INSERT INTO `order_management` VALUES ('O001','2024-04-27 16:09:05','C001',2000),('O002','2024-04-27 16:10:29','C001',16300),('O003','2024-04-27 16:27:54','C001',16300);
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
INSERT INTO `poke_graphics` VALUES ('G001','./images/pokemon/pokemon_001_nuckrar.jpg'),('G002','./images/pokemon/pokemon_002_eleson.jpg'),('G003','./images/pokemon/pokemon_003_groudon.jpg'),('G004','./images/pokemon/pokemon_004_wanaider.jpg'),('G005','./images/pokemon/pokemon_005_yukihami.jpg'),('G006','./images/pokemon/pokemon_006_kuwagannon.jpg'),('G007','./images/pokemon/pokemon_007_tairetsu.jpg'),('G008','./images/pokemon/pokemon_008_koraidon.jpg'),('G009','./images/pokemon/pokemon_009_wanriky.jpg'),('G010','./images/pokemon/pokemon_010_konoyozaru.jpg'),('G011','./images/pokemon/pokemon_011_mimikkyu.jpg'),('G012','./images/pokemon/pokemon_012_gangar.jpg'),('G013','./images/pokemon/pokemon_013_irukaman.jpg'),('G014','./images/pokemon/pokemon_014_nuoh.jpg'),('G015','./images/pokemon/pokemon_015_hagigishiri.jpg'),('G016','./images/pokemon/pokemon_016_absol.jpg'),('G017','./images/pokemon/pokemon_017_armorga.jpg'),('G018','./images/pokemon/pokemon_018_bangiras.jpg'),('G019','./images/pokemon/pokemon_019_batafurii.jpg'),('G027','./images/pokemon/pokemon_027_eievui.jpg'),('G029','./images/pokemon/pokemon_029_fushigidane.jpg');
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
INSERT INTO `poke_info` VALUES ('P001','ナックラー','T09ZMN',NULL,'G001'),('P002','エレズン','T04DNK','T08DOK','G002'),('P003','グラードン','T09ZMN','T02HNO','G003'),('P004','ワナイダー','T12MUS',NULL,'G004'),('P005','ユキハミ','T06KOR','T12MUS','G005'),('P006','クワガノン','T12MUS','T04DNK','G006'),('P007','タイレーツ','T07KKT',NULL,'G007'),('P008','コライドン','T07KKT','T15DGN','G008'),('P009','ワンリキー','T07KKT',NULL,'G009'),('P010','コノヨザル','T07KKT','T14GST','G010'),('P011','ミミッキュ','T14GST','T18FRY','G011'),('P012','ゲンガー','T14GST','T08DOK','G012'),('P013','イルカマン','T03MIZ',NULL,'G013'),('P014','ヌオー','T03MIZ','T09ZMN','G014'),('P015','ハギギシリ','T03MIZ','T11ESP','G015'),('P016','アブソル','T16AKU',NULL,'G016'),('P017','アーマーガア','T10HKU','T17HGN','G017'),('P018','バンギラス','T13IWA','T16AKU','G018'),('P019','バタフリー','T12MUS','T10HKU','G019'),('P027','イーブイ','T01NML',NULL,'G027'),('P029','フシギダネ','T05KUS','T08DOK','G029');
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
INSERT INTO `product_stock` VALUES ('S001','P001','M',100,0),('S002','P002','M',200,15),('S003','P003','M',300,48),('S004','P004','M',400,88),('S005','P005','M',500,46),('S006','P006','M',600,65),('S007','P007','M',700,52),('S008','P008','M',800,66),('S009','P009','M',900,33),('S010','P010','M',1000,0),('S011','P011','M',1100,25),('S012','P012','M',1200,52),('S013','P013','M',1300,7),('S014','P014','M',1400,0),('S015','P015','M',1500,20),('S016','P016','M',1600,10),('S017','P017','M',1700,10),('S018','P018','M',1800,10),('S019','P019','M',1900,10),('S027','P027','M',2700,10),('S029','P029','M',2900,10);
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

-- Dump completed on 2024-04-30 15:27:39
