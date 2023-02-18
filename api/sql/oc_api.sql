-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: oc_api
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_permissions`
--

DROP TABLE IF EXISTS `api_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_permissions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_permissions`
--

LOCK TABLES `api_permissions` WRITE;
/*!40000 ALTER TABLE `api_permissions` DISABLE KEYS */;
INSERT INTO `api_permissions` VALUES (1,'read'),(2,'write'),(3,'delete'),(4,'create'),(5,'view'),(6,'update');
/*!40000 ALTER TABLE `api_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_role_permissions`
--

DROP TABLE IF EXISTS `api_role_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  PRIMARY KEY (`role_id`,`permission_id`),
  KEY `permission_id` (`permission_id`),
  CONSTRAINT `api_role_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `api_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `api_role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `api_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_role_permissions`
--

LOCK TABLES `api_role_permissions` WRITE;
/*!40000 ALTER TABLE `api_role_permissions` DISABLE KEYS */;
INSERT INTO `api_role_permissions` VALUES (2,1),(3,1),(2,2),(1,3),(1,4),(2,5),(2,6);
/*!40000 ALTER TABLE `api_role_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_roles`
--

DROP TABLE IF EXISTS `api_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `api_roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_roles`
--

LOCK TABLES `api_roles` WRITE;
/*!40000 ALTER TABLE `api_roles` DISABLE KEYS */;
INSERT INTO `api_roles` VALUES (1,'admin'),(2,'user'),(3,'guest');
/*!40000 ALTER TABLE `api_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `departments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `short_name` varchar(50) NOT NULL,
  `active` tinyint(1) DEFAULT '1',
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'Sales','SAL',1,'2022-12-01 00:00:00'),(2,'Marketing','MKT',1,'2022-12-02 00:00:00'),(3,'Operations','OPS',1,'2022-12-03 00:00:00'),(4,'Finance','FIN',1,'2022-12-04 00:00:00'),(5,'IT','IT',1,'2022-12-05 00:00:00'),(6,'HR','HR',1,'2022-12-06 00:00:00'),(7,'Support','SUP',1,'2022-12-07 00:00:00'),(8,'Engineering','ENG',1,'2022-12-08 00:00:00'),(9,'Research and Development','R&D',1,'2022-12-09 00:00:00'),(10,'Product','PRD',1,'2022-12-10 00:00:00');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ncic_attributes`
--

DROP TABLE IF EXISTS `ncic_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ncic_attributes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ncic_attributes`
--

LOCK TABLES `ncic_attributes` WRITE;
/*!40000 ALTER TABLE `ncic_attributes` DISABLE KEYS */;
INSERT INTO `ncic_attributes` VALUES (1,'Height'),(2,'Weight'),(3,'Eye Color'),(4,'Skin Tone');
/*!40000 ALTER TABLE `ncic_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ncic_user_attributes`
--

DROP TABLE IF EXISTS `ncic_user_attributes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ncic_user_attributes` (
  `user_id` int NOT NULL,
  `attribute_id` int NOT NULL,
  `attribute_value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`,`attribute_id`),
  KEY `attribute_id` (`attribute_id`),
  CONSTRAINT `ncic_user_attributes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ncic_users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ncic_user_attributes_ibfk_2` FOREIGN KEY (`attribute_id`) REFERENCES `ncic_attributes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ncic_user_attributes`
--

LOCK TABLES `ncic_user_attributes` WRITE;
/*!40000 ALTER TABLE `ncic_user_attributes` DISABLE KEYS */;
INSERT INTO `ncic_user_attributes` VALUES (4,1,'185 cm'),(4,2,'90 kg'),(4,3,'Blue'),(5,2,'60 kg'),(5,4,'Light');
/*!40000 ALTER TABLE `ncic_user_attributes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ncic_users`
--

DROP TABLE IF EXISTS `ncic_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ncic_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `users_id` int NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `users_id` (`users_id`),
  CONSTRAINT `ncic_users_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ncic_users`
--

LOCK TABLES `ncic_users` WRITE;
/*!40000 ALTER TABLE `ncic_users` DISABLE KEYS */;
INSERT INTO `ncic_users` VALUES (4,3,'Bob','Smith','2023-02-18 17:49:48'),(5,3,'Bill','Smith','2023-02-18 17:49:48');
/*!40000 ALTER TABLE `ncic_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `streets`
--

DROP TABLE IF EXISTS `streets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `streets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `county` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1956 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `streets`
--

LOCK TABLES `streets` WRITE;
/*!40000 ALTER TABLE `streets` DISABLE KEYS */;
INSERT INTO `streets` VALUES (1,'Abattoir Avenue','Los Santos County'),(2,'Abe Milton Parkway','Los Santos County'),(3,'Ace Jones Drive','Los Santos County'),(4,'Adam\'s Apple Boulevard','Los Santos County'),(5,'Aguja Street','Los Santos County'),(6,'Alta Place','Los Santos County'),(7,'Alta Street','Los Santos County'),(8,'Amarillo Vista','Los Santos County'),(9,'Amarillo Way','Los Santos County'),(10,'Americano Way','Los Santos County'),(11,'Atlee Street','Los Santos County'),(12,'Autopia Parkway','Los Santos County'),(13,'Banham Canyon Drive','Los Santos County'),(14,'Barbareno Road','Los Santos County'),(15,'Bay City Avenue','Los Santos County'),(16,'Bay City Incline','Los Santos County'),(17,'Baytree Canyon Road (City)','Los Santos County'),(18,'Boulevard Del Perro','Los Santos County'),(19,'Bridge Street','Los Santos County'),(20,'Brouge Avenue','Los Santos County'),(21,'Buccaneer Way','Los Santos County'),(22,'Buen Vino Road','Los Santos County'),(23,'Caesars Place','Los Santos County'),(24,'Calais Avenue','Los Santos County'),(25,'Capital Boulevard','Los Santos County'),(26,'Carcer Way','Los Santos County'),(27,'Carson Avenue','Los Santos County'),(28,'Chum Street','Los Santos County'),(29,'Chupacabra Street','Los Santos County'),(30,'Clinton Avenue','Los Santos County'),(31,'Cockingend Drive','Los Santos County'),(32,'Conquistador Street','Los Santos County'),(33,'Cortes Street','Los Santos County'),(34,'Cougar Avenue','Los Santos County'),(35,'Covenant Avenue','Los Santos County'),(36,'Cox Way','Los Santos County'),(37,'Crusade Road','Los Santos County'),(38,'Davis Avenue','Los Santos County'),(39,'Decker Street','Los Santos County'),(40,'Didion Drive','Los Santos County'),(41,'Dorset Drive','Los Santos County'),(42,'Dorset Place','Los Santos County'),(43,'Dry Dock Street','Los Santos County'),(44,'Dunstable Drive','Los Santos County'),(45,'Dunstable Lane','Los Santos County'),(46,'Dutch London Street','Los Santos County'),(47,'Eastbourne Way','Los Santos County'),(48,'East Galileo Avenue','Los Santos County'),(49,'East Mirror Drive','Los Santos County'),(50,'Eclipse Boulevard','Los Santos County'),(51,'Edwood Way','Los Santos County'),(52,'Elgin Avenue','Los Santos County'),(53,'El Burro Boulevard','Los Santos County'),(54,'El Rancho Boulevard','Los Santos County'),(55,'Equality Way','Los Santos County'),(56,'Exceptionalists Way','Los Santos County'),(57,'Fantastic Place','Los Santos County'),(58,'Fenwell Place','Los Santos County'),(59,'Forum Drive','Los Santos County'),(60,'Fudge Lane','Los Santos County'),(61,'Galileo Road','Los Santos County'),(62,'Gentry Lane','Los Santos County'),(63,'Ginger Street','Los Santos County'),(64,'Glory Way','Los Santos County'),(65,'Goma Street','Los Santos County'),(66,'Greenwich Parkway','Los Santos County'),(67,'Greenwich Place','Los Santos County'),(68,'Greenwich Way','Los Santos County'),(69,'Grove Street','Los Santos County'),(70,'Hanger Way','Los Santos County'),(71,'Hangman Avenue','Los Santos County'),(72,'Hardy Way','Los Santos County'),(73,'Hawick Avenue','Los Santos County'),(74,'Heritage Way','Los Santos County'),(75,'Hillcrest Avenue','Los Santos County'),(76,'Hillcrest Ridge Access Road','Los Santos County'),(77,'Imagination Court','Los Santos County'),(78,'Industry Passage','Los Santos County'),(79,'Ineseno Road','Los Santos County'),(80,'Integrity Way','Los Santos County'),(81,'Invention Court','Los Santos County'),(82,'Innocence Boulevard','Los Santos County'),(83,'Jamestown Street','Los Santos County'),(84,'Kimble Hill Drive','Los Santos County'),(85,'Kortz Drive','Los Santos County'),(86,'Labor Place','Los Santos County'),(87,'Laguna Place','Los Santos County'),(88,'Lake Vinewood Drive','Los Santos County'),(89,'Las Lagunas Boulevard','Los Santos County'),(90,'Liberty Street','Los Santos County'),(91,'Lindsay Circus','Los Santos County'),(92,'Little Bighorn Avenue','Los Santos County'),(93,'Low Power Street','Los Santos County'),(94,'Macdonald Street','Los Santos County'),(95,'Mad Wayne Thunder Drive','Los Santos County'),(96,'Magellan Avenue','Los Santos County'),(97,'Marathon Avenue','Los Santos County'),(98,'Marlowe Drive','Los Santos County'),(99,'Melanoma Street','Los Santos County'),(100,'Meteor Street','Los Santos County'),(101,'Milton Road','Los Santos County'),(102,'Mirror Park Boulevard','Los Santos County'),(103,'Mirror Place','Los Santos County'),(104,'Morningwood Boulevard','Los Santos County'),(105,'Mount Haan Drive','Los Santos County'),(106,'Mount Haan Road','Los Santos County'),(107,'Mount Vinewood Drive','Los Santos County'),(108,'Movie Star Way','Los Santos County'),(109,'Mutiny Road','Los Santos County'),(110,'New Empire Way','Los Santos County'),(111,'Nikola Avenue','Los Santos County'),(112,'Nikola Place','Los Santos County'),(113,'Normandy Drive','Los Santos County'),(114,'North Archer Avenue','Los Santos County'),(115,'North Conker Avenue','Los Santos County'),(116,'North Sheldon Avenue','Los Santos County'),(117,'North Rockford Drive','Los Santos County'),(118,'Occupation Avenue','Los Santos County'),(119,'Orchardville Avenue','Los Santos County'),(120,'Palomino Avenue','Los Santos County'),(121,'Peaceful Street','Los Santos County'),(122,'Perth Street','Los Santos County'),(123,'Picture Perfect Drive','Los Santos County'),(124,'Plaice Place','Los Santos County'),(125,'Playa Vista','Los Santos County'),(126,'Popular Street','Los Santos County'),(127,'Portola Drive','Los Santos County'),(128,'Power Street','Los Santos County'),(129,'Prosperity Street','Los Santos County'),(130,'Prosperity Street Promenade','Los Santos County'),(131,'Red Desert Avenue','Los Santos County'),(132,'Richman Street','Los Santos County'),(133,'Rockford Drive','Los Santos County'),(134,'Roy Lowenstein Boulevard','Los Santos County'),(135,'Rub Street','Los Santos County'),(136,'Sam Austin Drive','Los Santos County'),(137,'San Andreas Avenue','Los Santos County'),(138,'Sandcastle Way','Los Santos County'),(139,'San Vitus Boulevard','Los Santos County'),(140,'Senora Road','Los Santos County'),(141,'Shank Street','Los Santos County'),(142,'Signal Street','Los Santos County'),(143,'Sinner Street','Los Santos County'),(144,'Sinners Passage','Los Santos County'),(145,'South Arsenal Street','Los Santos County'),(146,'South Boulevard Del Perro','Los Santos County'),(147,'South Mo Milton Drive','Los Santos County'),(148,'South Rockford Drive','Los Santos County'),(149,'South Shambles Street','Los Santos County'),(150,'Spanish Avenue','Los Santos County'),(151,'Steele Way','Los Santos County'),(152,'Strangeways Drive','Los Santos County'),(153,'Strawberry Avenue','Los Santos County'),(154,'Supply Street','Los Santos County'),(155,'Sustancia Road','Los Santos County'),(156,'Swiss Street','Los Santos County'),(157,'Tackle Street','Los Santos County'),(158,'Tangerine Street','Los Santos County'),(159,'Tongva Drive','Los Santos County'),(160,'Tower Way','Los Santos County'),(161,'Tug Street','Los Santos County'),(162,'Utopia Gardens','Los Santos County'),(163,'Vespucci Boulevard','Los Santos County'),(164,'Vinewood Boulevard','Los Santos County'),(165,'Vinewood Park Drive','Los Santos County'),(166,'Vitus Street','Los Santos County'),(167,'Voodoo Place','Los Santos County'),(168,'West Eclipse Boulevard','Los Santos County'),(169,'West Galileo Avenue','Los Santos County'),(170,'West Mirror Drive','Los Santos County'),(171,'Whispymound Drive','Los Santos County'),(172,'Wild Oats Drive','Los Santos County'),(173,'York Street','Los Santos County'),(174,'Zancudo Barranca','LOS Santos'),(175,'Algonquin Boulevard','Blaine County'),(176,'Alhambra Drive','Blaine County'),(177,'Armadillo Avenue','Blaine County'),(178,'Baytree Canyon Road (County)','Blaine County'),(179,'Calafia Road','Blaine County'),(180,'Cascabel Avenue','Blaine County'),(181,'Cassidy Trail','Blaine County'),(182,'Cat-Claw Avenue','Blaine County'),(183,'Chianski Passage','Blaine County'),(184,'Cholla Road','Blaine County'),(185,'Cholla Springs Avenue','Blaine County'),(186,'Duluoz Avenue','Blaine County'),(187,'East Joshua Road','Blaine County'),(188,'Fort Zancudo Approach Road','Blaine County'),(189,'Galileo Road','Blaine County'),(190,'Grapeseed Avenue','Blaine County'),(191,'Grapeseed Main Street','Blaine County'),(192,'Joad Lane','Blaine County'),(193,'Joshua Road','Blaine County'),(194,'Lesbos Lane','Blaine County'),(195,'Lolita Avenue','Blaine County'),(196,'Marina Drive','Blaine County'),(197,'Meringue Lane','Blaine County'),(198,'Mount Haan Road','Blaine County'),(199,'Mountain View Drive','Blaine County'),(200,'Niland Avenue','Blaine County'),(201,'North Calafia Way','Blaine County'),(202,'Nowhere Road','Blaine County'),(203,'O\'Neil Way','Blaine County'),(204,'Paleto Boulevard','Blaine County'),(205,'Panorama Drive','Blaine County'),(206,'Procopio Drive','Blaine County'),(207,'Procopio Promenade','Blaine County'),(208,'Pyrite Avenue','Blaine County'),(209,'Raton Pass','Blaine County'),(210,'Route 68 Approach','Blaine County'),(211,'Seaview Road','Blaine County'),(212,'Senora Way','Blaine County'),(213,'Smoke Tree Road','Blaine County'),(214,'Union Road','Blaine County'),(215,'Zancudo Avenue','Blaine County'),(216,'Zancudo Road','Blaine County'),(217,'Zancudo Trail','Blaine County'),(218,'Interstate 1','State'),(219,'Interstate 2','State'),(220,'Interstate 4','State'),(221,'Interstate 5','State'),(222,'Route 1','State'),(223,'Route 11','State'),(224,'Route 13','State'),(225,'Route 14','State'),(226,'Route 15','State'),(227,'Route 16','State'),(228,'Route 17','State'),(229,'Route 18','State'),(230,'Route 19','State'),(231,'Route 20','State'),(232,'Route 22','State'),(233,'Route 23','State'),(234,'Route 68','State'),(235,'Route 13 A','State'),(236,'Route 13 B','State'),(237,'Route 13 C','State'),(238,'Route 13 D','State'),(239,'Route 13 E','State'),(240,'Route 13 F','State'),(241,'Route 13 G','State'),(242,'Route 13 H','State'),(243,'Route 13 I','State'),(244,'Route 1 J','State'),(245,'Route 1 K','State'),(246,'Route 1 L','State'),(247,'Route 1 M','State'),(248,'Route 1 N','State'),(249,'Route 1 O','State'),(250,'Route 1 P','State'),(251,'Route 1 Q','State'),(252,'Route 1 R','State'),(253,'Route 1 S','State'),(254,'Route 1 T','State'),(255,'Route 1 U','State'),(256,'Route 1 V','State'),(257,'Route 1 W','State'),(258,'Route 1 X','State'),(259,'Route 1 Y','State'),(260,'Route 1 Z','State'),(261,'Route 15 Red','State'),(262,'Route 15 Pink','State'),(263,'Route 15 Blue','State'),(264,'Route 15 Yellow','State'),(265,'Route 15 Green','State');
/*!40000 ALTER TABLE `streets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tokens`
--

DROP TABLE IF EXISTS `tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `expires_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tokens_token_uindex` (`token`),
  KEY `fk_token_user` (`user_id`),
  CONSTRAINT `fk_token_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tokens`
--

LOCK TABLES `tokens` WRITE;
/*!40000 ALTER TABLE `tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_department`
--

DROP TABLE IF EXISTS `user_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_department` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `department_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `user_department_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_department_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_department`
--

LOCK TABLES `user_department` WRITE;
/*!40000 ALTER TABLE `user_department` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_on` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'','johndoe@example.com','johndoe','password1','2023-02-18 17:49:48'),(3,'','bobsmith@example.com','bobsmith','password3','2023-02-18 17:49:48'),(4,'','janedoe@example.com','janedoe','password4','2023-02-18 17:53:19'),(5,'','joesmith@example.com','joesmith','password5','2023-02-18 17:53:19');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-02-18 21:03:54
