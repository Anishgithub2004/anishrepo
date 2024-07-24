-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: dbmsl
-- ------------------------------------------------------
-- Server version	8.0.35

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
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application` (
  `app_id` int NOT NULL AUTO_INCREMENT,
  `cur_qual` varchar(15) DEFAULT NULL,
  `desi_qual` varchar(15) DEFAULT NULL,
  `clg_type` varchar(10) DEFAULT NULL,
  `course_category` varchar(15) DEFAULT NULL,
  `college` varchar(25) DEFAULT NULL,
  `time_of_regn` timestamp NULL DEFAULT NULL,
  UNIQUE KEY `app_id` (`app_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (1,'SSLC','B.Tech','GOVT','technical','SMVEC','2024-01-23 18:17:50'),(2,'B.tech','M.tech','GOVT','technical','NIT','2024-01-28 15:16:32');
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `college`
--

DROP TABLE IF EXISTS `college`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `college` (
  `id_no` int NOT NULL,
  `name` varchar(35) NOT NULL,
  `place` varchar(35) NOT NULL,
  `rating` float NOT NULL,
  `rank` int NOT NULL,
  `totalseats` int NOT NULL,
  `established_year` int NOT NULL,
  `type` varchar(25) NOT NULL,
  `contact` bigint NOT NULL,
  `category` varchar(20) NOT NULL,
  PRIMARY KEY (`id_no`),
  UNIQUE KEY `id_no_UNIQUE` (`id_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `college`
--

LOCK TABLES `college` WRITE;
/*!40000 ALTER TABLE `college` DISABLE KEYS */;
INSERT INTO `college` VALUES (1,'PTU','PUDUCHERRY',9,150,13000,1984,'GOVT',2655281,'technical'),(2,'SMVEC','PUDUCHERRY',8.4,151,22500,1999,'PRIVATE',2641151,'technical'),(3,'AU','CHENNAI',8.4,14,27000,1978,'GOVT',9234543540,'technical'),(4,'JIPMER','PUDUCHERRY',7.2,2,458,1964,'GOVT',2298288,'science'),(5,'TAC','PUDUCHERRY',4.9,700,10000,1961,'GOVT',2291248,'arts'),(6,'SRM-Engineering College','CHENNAI',9.5,120,38500,2000,'PRIVATE',2652481,'technical');
/*!40000 ALTER TABLE `college` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `course` (
  `id` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `duration` int NOT NULL,
  `category` varchar(20) NOT NULL,
  `degree` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `course`
--

LOCK TABLES `course` WRITE;
/*!40000 ALTER TABLE `course` DISABLE KEYS */;
INSERT INTO `course` VALUES ('A01','B.Sc Nursing',3,'arts','UG'),('A02','B.A.Tamil',3,'arts','UG'),('A03','B.Sc.Botany',3,'arts','UG'),('A04','M.Sc Physics',5,'arts','PG'),('D01','PGBM',2,'diploma','DIPLOMA'),('D02','PGDBM',1,'diploma','DIPLOMA'),('S01','MBBS',5,'science','UG'),('S02','MDS',4,'science','UG'),('S03','B.pharm',3,'science','UG'),('T01','B.Tech CSE',4,'technical','UG'),('T02','B.TECH IT',4,'technical','UG'),('T03','B.Tech ME',4,'technical','UG'),('T04','M.Tech IT',2,'technical','PG');
/*!40000 ALTER TABLE `course` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fees`
--

DROP TABLE IF EXISTS `fees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `fees` (
  `academic+placement` int NOT NULL,
  `hostel+mess` int DEFAULT NULL,
  `category` varchar(20) DEFAULT NULL,
  `clg_type` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fees`
--

LOCK TABLES `fees` WRITE;
/*!40000 ALTER TABLE `fees` DISABLE KEYS */;
INSERT INTO `fees` VALUES (45000,70000,'technical','GOVT'),(89000,90000,'technical','PRIVATE'),(6100,22000,'science','GOVT'),(150000,90000,'science','PRIVATE'),(11000,80000,'arts','GOVT'),(18000,87000,'arts','PRIVATE');
/*!40000 ALTER TABLE `fees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qualification`
--

DROP TABLE IF EXISTS `qualification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qualification` (
  `Id_no` int NOT NULL,
  `sslc_year` int NOT NULL,
  `sslc_percent` float NOT NULL,
  `hse_year` int DEFAULT NULL,
  `hse_percent` float DEFAULT NULL,
  `NEET_percentile` float DEFAULT NULL,
  `JEE_percentile` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qualification`
--

LOCK TABLES `qualification` WRITE;
/*!40000 ALTER TABLE `qualification` DISABLE KEYS */;
INSERT INTO `qualification` VALUES (1,2019,86.72,2021,91.85,NULL,80.12),(2,2019,88.14,2021,86.05,75.241,75.88),(3,2019,91.47,2021,93.25,81.001,NULL),(4,2019,84.93,NULL,NULL,NULL,NULL),(5,2017,78.93,2019,80.14,52.178,NULL);
/*!40000 ALTER TABLE `qualification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reservation` (
  `id_no` int NOT NULL,
  `category` varchar(15) NOT NULL,
  `percentage` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
INSERT INTO `reservation` VALUES (1,'general',72.84),(2,'sports',63.54),(3,'pwd',50),(4,'freedom fighter',NULL),(5,'general',80.12),(3,'ex-servicemen',NULL),(6,'sports',58.58),(6,'ex-servicemen',NULL),(1,'general',72.84),(2,'sports',63.54),(3,'pwd',50),(4,'freedom fighter',NULL),(5,'general',80.12),(3,'ex-servicemen',NULL),(6,'sports',58.58),(6,'ex-servicemen',NULL),(1,'general',72.84),(2,'sports',63.54),(3,'pwd',50),(4,'freedom fighter',NULL),(5,'general',80.12),(3,'ex-servicemen',NULL),(6,'sports',58.58),(6,'ex-servicemen',NULL),(7,'sports',62.05),(7,'sports',62.05);
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `student` (
  `id_no` int NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `age` int NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(8) NOT NULL,
  `caste` varchar(5) NOT NULL,
  `district` varchar(20) NOT NULL,
  `phone` bigint NOT NULL,
  `email` varchar(25) NOT NULL,
  `hse_or_sslc` varchar(15) NOT NULL,
  `hse_field` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES (1,'Abhinav','Brutal',19,'2004-04-04','M','MBC','PUDUCHERRY',8838529664,'aaa@gmail.com','HSE','science'),(2,'Nandy','Joel',20,'2003-11-01','F','OBC','TAMILNADU',8463212345,'bbb@gamil.com','SSLC','diploma'),(3,'Anish','Immanuel',20,'2003-10-24','M','SC','TAMILNADU',8465823455,'ccc@gamil.com','HSE','technical'),(4,'Harshit','Holcha',20,'2003-12-11','M','OBC','MAHE',8465843255,'ddd@gamil.com','SSLC',NULL),(5,'Jovika','Sarathkumar',22,'2002-11-28','F','ST','PUDUCHERRY',8823554211,'eee@gamil.com','HSE','technical'),(6,'Prabhu','Deva',19,'2003-11-06','M','MBC','CUDDALORE',413986545,'fff@gmail.com','HSE','economics'),(7,'dhamo','mass',19,'2004-05-11','M','MBC','PUDUCHERRY',8836896954,'a12@gmail.com','HSE','science');
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

-- Dump completed on 2024-07-24 20:44:03
