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
INSERT INTO `order_detail` VALUES ('OD001','O001','S001',1,100),('OD002','O001','S002',5,1000),('OD003','O001','S003',3,900),('OD004','O002','S004',7,2800),('OD005','O002','S005',9,4500),('OD006','O002','S006',5,3000),('OD007','O002','S007',4,2800),('OD008','O002','S008',4,3200),('OD009','O003','S004',7,2800),('OD010','O003','S005',9,4500),('OD011','O003','S006',5,3000),('OD012','O003','S007',4,2800),('OD013','O003','S008',4,3200),('OD014','O004','S002',6,1200),('OD015','O004','S003',4,1200);
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
INSERT INTO `order_management` VALUES ('O001','2024-04-27 16:09:05','C001',2000),('O002','2024-04-27 16:10:29','C001',16300),('O003','2024-04-27 16:27:54','C001',16300),('O004','2024-05-01 04:15:26','C001',2400);
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
INSERT INTO `poke_graphics` VALUES ('G001','./images/pokemon/pokemon_001_nuckrar.jpg'),('G002','./images/pokemon/pokemon_002_eleson.jpg'),('G003','./images/pokemon/pokemon_003_groudon.jpg'),('G004','./images/pokemon/pokemon_004_wanaider.jpg'),('G005','./images/pokemon/pokemon_005_yukihami.jpg'),('G006','./images/pokemon/pokemon_006_kuwagannon.jpg'),('G007','./images/pokemon/pokemon_007_tairetsu.jpg'),('G008','./images/pokemon/pokemon_008_koraidon.jpg'),('G009','./images/pokemon/pokemon_009_wanriky.jpg'),('G010','./images/pokemon/pokemon_010_konoyozaru.jpg'),('G011','./images/pokemon/pokemon_011_mimikkyu.jpg'),('G012','./images/pokemon/pokemon_012_gangar.jpg'),('G013','./images/pokemon/pokemon_013_irukaman.jpg'),('G014','./images/pokemon/pokemon_014_nuoh.jpg'),('G015','./images/pokemon/pokemon_015_hagigishiri.jpg'),('G016','./images/pokemon/pokemon_016_absol.jpg'),('G017','./images/pokemon/pokemon_017_armorga.jpg'),('G018','./images/pokemon/pokemon_018_bangiras.jpg'),('G019','./images/pokemon/pokemon_019_batafurii.jpg'),('G020','./images/pokemon/pokemon_020_buoysel.jpg'),('G021','./images/pokemon/pokemon_021_chandela.jpg'),('G022','./images/pokemon/pokemon_022_chirutarisu.jpg'),('G023','./images/pokemon/pokemon_023_darumakka.jpg'),('G024','./images/pokemon/pokemon_024_dekanuchan.jpg'),('G025','./images/pokemon/pokemon_025_dodogezan.jpg'),('G026','./images/pokemon/pokemon_026_dorapult.jpg'),('G027','./images/pokemon/pokemon_027_eievui.jpg'),('G028','./images/pokemon/pokemon_028_eipamu.jpg'),('G029','./images/pokemon/pokemon_029_fushigidane.jpg'),('G030','./images/pokemon/pokemon_030_gaburias.jpg'),('G031','./images/pokemon/pokemon_031_gekkouga.jpg'),('G032','./images/pokemon/pokemon_032_glion.jpg'),('G033','./images/pokemon/pokemon_033_gorirander.jpg'),('G034','./images/pokemon/pokemon_034_hanecco.jpg'),('G035','./images/pokemon/pokemon_035_harimaron.jpg'),('G036','./images/pokemon/pokemon_036_heyrusher.jpg'),('G037','./images/pokemon/pokemon_037_hihidaruma.jpg'),('G038','./images/pokemon/pokemon_038_himeguma.jpg'),('G039','./images/pokemon/pokemon_039_hinoarashi.jpg'),('G040','./images/pokemon/pokemon_040_hitotsuki.jpg'),('G041','./images/pokemon/pokemon_041_jibacoil.jpg'),('G042','./images/pokemon/pokemon_042_kabigon.jpg'),('G043','./images/pokemon/pokemon_043_kaenjishi.jpg'),('G044','./images/pokemon/pokemon_044_kailios.jpg'),('G045','./images/pokemon/pokemon_045_karakara.jpg'),('G046','./images/pokemon/pokemon_046_karamingo.jpg'),('G047','./images/pokemon/pokemon_047_karikiri.jpg'),('G048','./images/pokemon/pokemon_048_kemusso.jpg'),('G049','./images/pokemon/pokemon_049_kiteruguma.jpg'),('G050','./images/pokemon/pokemon_050_koduck.jpg'),('G051','./images/pokemon/pokemon_051_kokogara.jpg'),('G052','./images/pokemon/pokemon_052_korippo.jpg'),('G053','./images/pokemon/pokemon_053_kumashun.jpg'),('G054','./images/pokemon/pokemon_054_kyojiohn.jpg'),('G055','./images/pokemon/pokemon_055_leafia.jpg'),('G056','./images/pokemon/pokemon_056_maggyo.jpg'),('G057','./images/pokemon/pokemon_057_masquernya.jpg'),('G058','./images/pokemon/pokemon_058_metamon.jpg'),('G059','./images/pokemon/pokemon_059_hogator.jpg'),('G060','./images/pokemon/pokemon_060_morpeko.jpg'),('G061','./images/pokemon/pokemon_061_mugendina.jpg'),('G062','./images/pokemon/pokemon_062_nassy.jpg'),('G063','./images/pokemon/pokemon_063_numelgon.jpg'),('G064','./images/pokemon/pokemon_064_nutrey.jpg'),('G065','./images/pokemon/pokemon_065_nyarth.jpg'),('G066','./images/pokemon/pokemon_066_odoshishi.jpg'),('G067','./images/pokemon/pokemon_067_ogerpon.jpg'),('G068','./images/pokemon/pokemon_068_ohlonge.jpg'),('G069','./images/pokemon/pokemon_069_parmot.jpg'),('G070','./images/pokemon/pokemon_070_parshen.jpg'),('G071','./images/pokemon/pokemon_071_poppo.jpg'),('G072','./images/pokemon/pokemon_072_regigigas.jpg'),('G073','./images/pokemon/pokemon_073_rokon.jpg'),('G074','./images/pokemon/pokemon_074_rotom.jpg'),('G075','./images/pokemon/pokemon_075_roubushin.jpg'),('G076','./images/pokemon/pokemon_076_sazandora.jpg'),('G077','./images/pokemon/pokemon_077_seglaive.jpg'),('G078','./images/pokemon/pokemon_078_serebii.jpg'),('G079','./images/pokemon/pokemon_079_showers.jpg'),('G080','./images/pokemon/pokemon_080_sonans.jpg'),('G081','./images/pokemon/pokemon_081_sunnygo.jpg'),('G082','./images/pokemon/pokemon_082_surfugo.jpg'),('G083','./images/pokemon/pokemon_083_tanebo.jpg'),('G084','./images/pokemon/pokemon_084_tunbear.jpg'),('G085','./images/pokemon/pokemon_085_ulgamoth.jpg'),('G086','./images/pokemon/pokemon_086_wanpachi.jpg'),('G087','./images/pokemon/pokemon_087_yadon.jpg'),('G088','./images/pokemon/pokemon_088_yamirami.jpg'),('G089','./images/pokemon/pokemon_089_yokubarisu.jpg'),('G090','./images/pokemon/pokemon_090_yomawaru.jpg'),('G091','./images/pokemon/pokemon_091_zacian.jpg'),('G092','./images/pokemon/pokemon_092_zoroark.jpg'),('G093','./images/pokemon/pokemon_093_sando.jpg'),('G094','./images/pokemon/pokemon_094_monster-ball.png'),('G095','./images/pokemon/pokemon_095_super-ball.png'),('G096','./images/pokemon/pokemon_096_hyper-ball.png'),('G097','./images/pokemon/pokemon_097_heal-ball.png'),('G098','./images/pokemon/pokemon_098_net-ball.png'),('G099','./images/pokemon/pokemon_099_nest-ball.png'),('G100','./images/pokemon/pokemon_100_repeat-ball.png'),('G101','./images/pokemon/pokemon_101_gorgeous-ball.png'),('G102','./images/pokemon/pokemon_102_dive-ball.png'),('G103','./images/pokemon/pokemon_103_quick-ball.png'),('G104','./images/pokemon/pokemon_104_dark-ball.png'),('G105','./images/pokemon/pokemon_105_timer-ball.png'),('G106','./images/pokemon/pokemon_106_02egg.png'),('G107','./images/pokemon/pokemon_107_05egg.png'),('G108','./images/pokemon/pokemon_108_07egg.png'),('G109','./images/pokemon/pokemon_109_10egg.png'),('G110','./images/pokemon/pokemon_110_12egg.png'),('G111','./images/pokemon/pokemon_111_ikasama-dice.png'),('G112','./images/pokemon/pokemon_112_sensei-no-tsume.png'),('G113','./images/pokemon/pokemon_113_bibiri-dama.png'),('G114','./images/pokemon/pokemon_114_tabenokoshi.png'),('G115','./images/pokemon/pokemon_115_yami-no-ishi.png');
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
  `Type1` varchar(10) DEFAULT NULL,
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
INSERT INTO `poke_info` VALUES ('P001','ナックラー','T09ZMN',NULL,'G001'),('P002','エレズン','T04DNK','T08DOK','G002'),('P003','グラードン','T09ZMN','T02HNO','G003'),('P004','ワナイダー','T12MUS',NULL,'G004'),('P005','ユキハミ','T06KOR','T12MUS','G005'),('P006','クワガノン','T12MUS','T04DNK','G006'),('P007','タイレーツ','T07KKT',NULL,'G007'),('P008','コライドン','T07KKT','T15DGN','G008'),('P009','ワンリキー','T07KKT',NULL,'G009'),('P010','コノヨザル','T07KKT','T14GST','G010'),('P011','ミミッキュ','T14GST','T18FRY','G011'),('P012','ゲンガー','T14GST','T08DOK','G012'),('P013','イルカマン','T03MIZ',NULL,'G013'),('P014','ヌオー','T03MIZ','T09ZMN','G014'),('P015','ハギギシリ','T03MIZ','T11ESP','G015'),('P016','アブソル','T16AKU',NULL,'G016'),('P017','アーマーガア','T10HKU','T17HGN','G017'),('P018','バンギラス','T13IWA','T16AKU','G018'),('P019','バタフリー','T01NML',NULL,'G019'),('P020','ブイゼル','T03MIZ',NULL,'G020'),('P021','シャンデラ','T14GST','T02HNO','G021'),('P022','チルタリス','T15DGN','T10HKU','G022'),('P023','ダルマッカ','T02HNO',NULL,'G023'),('P024','デカヌチャン','T18FRY','T17HGN','G024'),('P025','ドドゲザン','T16AKU','T17HGN','G025'),('P026','ドラパルト','T15DGN','T14GST','G026'),('P027','イーブイ','T01NML',NULL,'G027'),('P028','エイパム','T01NML',NULL,'G028'),('P029','フシギダネ','T05KUS','T08DOK','G029'),('P030','ガブリアス','T15DGN','T09ZMN','G030'),('P031','ゲッコウガ','T03MIZ','T16AKU','G031'),('P032','グライオン','T09ZMN','T10HKU','G032'),('P033','ゴリランダー','T05KUS',NULL,'G033'),('P034','ハネッコ','T05KUS','T10HKU','G034'),('P035','ハリマロン','T05KUS',NULL,'G035'),('P036','ヘイラッシャ','T03MIZ',NULL,'G036'),('P037','ヒヒダルマ','T02HNO',NULL,'G037'),('P038','ヒメグマ','T01NML',NULL,'G038'),('P039','ヒノアラシ','T02HNO',NULL,'G039'),('P040','ヒトツキ','T17HGN','T14GST','G040'),('P041','ジバコイル','T04DNK','T17HGN','G041'),('P042','カビゴン','T01NML',NULL,'G042'),('P043','カエンジシ','T02HNO','T01NML','G043'),('P044','ケンタロス','T01NML',NULL,'G044'),('P045','カラカラ','T09ZMN',NULL,'G045'),('P046','カラミンゴ','T10HKU','T07KKT','G046'),('P047','カリキリ','T05KUS',NULL,'G047'),('P048','ケムッソ','T12MUS',NULL,'G048'),('P049','キテルグマ','T01NML','T07KKT','G049'),('P050','コダック','T03MIZ',NULL,'G050'),('P051','ココガラ','T10HKU',NULL,'G051'),('P052','コオリッポ','T06KOR',NULL,'G052'),('P053','クマシュン','T06KOR',NULL,'G053'),('P054','キョジオーン','T13IWA',NULL,'G054'),('P055','リーフィア','T05KUS',NULL,'G055'),('P056','マッギョ','T09ZMN','T17HGN','G056'),('P057','マスカーニャ','T05KUS','T16AKU','G057'),('P058','メタモン','T01NML',NULL,'G058'),('P059','ホゲータ','T02HNO',NULL,'G059'),('P060','モル','T04DNK','T16AKU','G060'),('P061','ムゲンダイナ','T08DOK','T15DGN','G061'),('P062','ナッシー','T05KUS','T11ESP','G062'),('P063','ヌメルゴン','T15DGN',NULL,'G063'),('P064','ナットレイ','T05KUS','T17HGN','G064'),('P065','ニャース','T01NML',NULL,'G065'),('P066','オドシシ','T01NML',NULL,'G066'),('P067','オーガポン','T05KUS',NULL,'G067'),('P068','オーロンゲ','T16AKU','T18FRY','G068'),('P069','パーモット','T04DNK','T07KKT','G069'),('P070','パルシェン','T03MIZ','T06KOR','G070'),('P071','ポッポ','T01NML','T10HKU','G071'),('P072','レジギガス','T01NML',NULL,'G072'),('P073','ロコン','T02HNO',NULL,'G073'),('P074','ロトム','T04DNK','T14GST','G074'),('P075','ローブシン','T07KKT',NULL,'G075'),('P076','サザンドラ','T16AKU','T15DGN','G076'),('P077','セグレイブ','T15DGN','T06KOR','G077'),('P078','セレビィ','T11ESP','T05KUS','G078'),('P079','シャワーズ','T03MIZ',NULL,'G079'),('P080','ソーナンス','T11ESP',NULL,'G080'),('P081','サニーゴ','T04DNK','T13IWA','G081'),('P082','サーフゴー','T17HGN','T14GST','G082'),('P083','タネボー','T05KUS',NULL,'G083'),('P084','ツンベアー','T06KOR',NULL,'G084'),('P085','ウルガモス','T12MUS','T02HNO','G085'),('P086','ワンパチ','T04DNK',NULL,'G086'),('P087','ヤドン','T03MIZ','T11ESP','G087'),('P088','ヤミラミ','T16AKU','T14GST','G088'),('P089','ヨクバリス','T01NML',NULL,'G089'),('P090','ヨマワル','T14GST',NULL,'G090'),('P091','ザシアン','T18FRY','T17HGN','G091'),('P092','ゾロアーク','T16AKU',NULL,'G092'),('P093','サンド','T09ZMN',NULL,'G093'),('P094','モンスターボール',NULL,NULL,'G094'),('P095','スーパーボール',NULL,NULL,'G095'),('P096','ハイパーボール',NULL,NULL,'G096'),('P097','ヒールボール',NULL,NULL,'G097'),('P098','ネットボール',NULL,NULL,'G098'),('P099','ネストボール',NULL,NULL,'G099'),('P100','リピートボール',NULL,NULL,'G100'),('P101','ゴージャスボール',NULL,NULL,'G101'),('P102','ダイブボール',NULL,NULL,'G102'),('P103','クイックボール',NULL,NULL,'G103'),('P104','ダークボール',NULL,NULL,'G104'),('P105','タイマーボール',NULL,NULL,'G105'),('P106','2kmタマゴ',NULL,NULL,'G106'),('P107','5kmタマゴ',NULL,NULL,'G107'),('P108','7kmタマゴ',NULL,NULL,'G108'),('P109','10kmタマゴ',NULL,NULL,'G109'),('P110','12kmタマゴ',NULL,NULL,'G110'),('P111','いかさまダイス',NULL,NULL,'G111'),('P112','せんせいのツメ',NULL,NULL,'G112'),('P113','ビビリだま',NULL,NULL,'G113'),('P114','たべのこし',NULL,NULL,'G114'),('P115','やみのいし',NULL,NULL,'G115');
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
  `Gender` varchar(10) NOT NULL,
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
INSERT INTO `product_stock` VALUES ('S001','P001','male',100,0),('S002','P002','male',200,4),('S003','P003','unknown',30000,2),('S004','P004','male',400,88),('S005','P005','male',500,46),('S006','P006','male',600,65),('S007','P007','male',700,52),('S008','P008','male',800,66),('S009','P009','male',900,33),('S010','P010','male',1000,0),('S011','P011','male',1100,25),('S012','P012','male',1200,52),('S013','P013','male',1300,7),('S014','P014','male',1400,0),('S015','P015','male',1500,20),('S016','P016','male',1600,16),('S017','P017','male',1700,17),('S018','P018','male',1800,18),('S019','P019','male',1900,19),('S020','P020','male',2000,20),('S021','P021','male',2100,21),('S022','P022','male',2200,22),('S023','P023','male',2300,23),('S024','P024','female',2400,24),('S025','P025','male',2500,25),('S026','P026','male',2600,26),('S027','P027','male',2700,27),('S028','P028','male',2800,28),('S029','P029','male',2900,29),('S030','P030','male',3000,30),('S031','P031','male',3100,31),('S032','P032','male',3200,32),('S033','P033','male',3300,33),('S034','P034','male',3400,34),('S035','P035','male',3500,35),('S036','P036','male',3600,36),('S037','P037','male',3700,37),('S038','P038','male',3800,38),('S039','P039','male',3900,39),('S040','P040','male',4000,40),('S041','P041','unknown',4100,41),('S042','P042','male',4200,42),('S043','P043','male',4300,43),('S044','P044','male',4400,44),('S045','P045','male',4500,45),('S046','P046','male',4600,46),('S047','P047','male',4700,47),('S048','P048','male',4800,48),('S049','P049','male',4900,49),('S050','P050','male',5000,50),('S051','P051','male',5100,51),('S052','P052','male',5200,52),('S053','P053','male',5300,53),('S054','P054','unknown',5400,54),('S055','P055','female',5500,55),('S056','P056','male',5600,56),('S057','P057','male',5700,57),('S058','P058','unknown',5800,58),('S059','P059','male',5900,59),('S060','P060','female',6000,60),('S061','P061','unknown',6100,61),('S062','P062','male',6200,62),('S063','P063','female',6300,63),('S064','P064','male',6400,64),('S065','P065','male',6500,65),('S066','P066','male',6600,66),('S067','P067','male',6700,67),('S068','P068','male',6800,68),('S069','P069','male',6900,69),('S070','P070','male',7000,70),('S071','P071','male',7100,71),('S072','P072','unknown',90000,5),('S073','P073','male',7300,73),('S074','P074','unknown',7400,74),('S075','P075','male',7500,75),('S076','P076','male',7600,76),('S077','P077','male',7700,77),('S078','P078','unknown',78000,7),('S079','P079','female',7900,79),('S080','P080','male',8000,80),('S081','P081','male',8100,81),('S082','P082','unknown',820000,82),('S083','P083','male',8300,83),('S084','P084','male',8400,84),('S085','P085','male',8500,85),('S086','P086','male',8600,86),('S087','P087','male',8700,87),('S088','P088','male',8800,88),('S089','P089','male',8900,89),('S090','P090','male',9000,90),('S091','P091','unknown',91000,91),('S092','P092','male',9200,92),('S093','P093','male',9300,93),('S094','P094','ball',200,100),('S095','P095','ball',600,100),('S096','P096','ball',800,100),('S097','P097','ball',300,100),('S098','P098','ball',1000,50),('S099','P099','ball',1000,50),('S100','P100','ball',1000,50),('S101','P101','ball',3000,10),('S102','P102','ball',1000,50),('S103','P103','ball',1000,50),('S104','P104','ball',1000,50),('S105','P105','ball',1000,50),('S106','P106','egg',200,10),('S107','P107','egg',500,10),('S108','P108','egg',700,10),('S109','P109','egg',1000,10),('S110','P110','egg',1200,10),('S111','P111','item',20000,10),('S112','P112','item',8000,10),('S113','P113','item',5000,10),('S114','P114','item',20000,10),('S115','P115','item',30000,5);
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

-- Dump completed on 2024-05-10 14:30:54
