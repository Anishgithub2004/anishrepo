-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: main_e_learning
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
-- Table structure for table `colleges`
--

DROP TABLE IF EXISTS `colleges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `colleges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `rank` int DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `total_seats` int DEFAULT NULL,
  `established_year` year DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `colleges`
--

LOCK TABLES `colleges` WRITE;
/*!40000 ALTER TABLE `colleges` DISABLE KEYS */;
INSERT INTO `colleges` VALUES (21,'University of Science and Technology','Mumbai','Engineering',1,4.5,5000,1980,'Public','123-456-7890','A leading institute known for its excellence in engineering education.'),(22,'National Medical College','Delhi','Medical',3,4.2,200,1975,'Private','987-654-3210','Specializes in medical education and healthcare research.'),(23,'City Arts and Science College','Bangalore','Arts',5,4,3000,1960,'Public','456-789-0123','Offers a wide range of arts and humanities programs.'),(24,'Global Business School','Pune','Business',2,4.4,1000,1995,'Private','789-012-3456','Provides high-quality education in business management and administration.'),(25,'State Institute of Technology','Chennai','Engineering',4,4.1,1500,1985,'Public','234-567-8901','Focuses on technological education and research in various engineering fields.'),(26,'Holy Cross College','Kolkata','Science',7,3.9,800,1950,'Private','567-890-1234','Renowned for its excellence in science education and research.'),(27,'City Law College','Hyderabad','Law',6,4,400,1978,'Public','890-123-4567','Offers comprehensive legal education and training programs.'),(28,'National Institute of Design','Ahmedabad','Design',8,4.3,300,1982,'Public','321-654-0987','Known for its innovation in design education and creative arts.'),(29,'International Institute of Management','Jaipur','Business',10,4,600,2000,'Private','654-321-9870','Focuses on global management education and leadership development.'),(30,'City College of Pharmacy','Lucknow','Medical',9,4.2,150,1990,'Public','012-345-6789','Provides advanced education and research in pharmaceutical sciences.');
/*!40000 ALTER TABLE `colleges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `degree` enum('UG','PG') DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `description` text,
  `mentor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mentor_id` (`mentor_id`),
  CONSTRAINT `fk_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (15,'B.Tech IT','4 years','UG','Science&Technology','A Bachelor of Technology in Information Technology (B.Tech IT) is an undergraduate degree that focuses on the study of computer science, software development, networking, and information systems. The program equips students with practical skills and theoretical knowledge to solve complex technological problems and innovate in the IT industry. Graduates often pursue careers in software engineering, system administration, data analysis, and IT consulting.',18),(16,'B.Sc. Botany','3 years','UG','Medical Science','A Bachelor degree in Medical Science (B.Sc Botany) is an undergraduate degree focusing on the study of human health, disease mechanisms, and medical research. The program equips students with comprehensive knowledge of human anatomy, physiology, biochemistry, and pathology. Graduates often pursue careers in medical research, clinical laboratory science, healthcare administration, or further studies in medicine or allied health professions.',20);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mock_tests`
--

DROP TABLE IF EXISTS `mock_tests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mock_tests` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_id` int DEFAULT NULL,
  `mentor_id` int DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_mock_tests_course_id` (`course_id`),
  KEY `fk_mock_tests_mentor_id` (`mentor_id`),
  CONSTRAINT `fk_mock_tests_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_mock_tests_mentor_id` FOREIGN KEY (`mentor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mock_tests`
--

LOCK TABLES `mock_tests` WRITE;
/*!40000 ALTER TABLE `mock_tests` DISABLE KEYS */;
INSERT INTO `mock_tests` VALUES (5,15,18,'2024-07-22 07:15:00'),(6,16,20,'2024-07-20 08:50:00');
/*!40000 ALTER TABLE `mock_tests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `test_id` int DEFAULT NULL,
  `question` text NOT NULL,
  `option_a` varchar(255) DEFAULT NULL,
  `option_b` varchar(255) DEFAULT NULL,
  `option_c` varchar(255) DEFAULT NULL,
  `option_d` varchar(255) DEFAULT NULL,
  `correct_option` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_questions_test_id` (`test_id`),
  CONSTRAINT `fk_questions_test_id` FOREIGN KEY (`test_id`) REFERENCES `mock_tests` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (12,5,'In object-oriented programming, what is encapsulation?','The ability to inherit properties from another class','The process of defining multiple methods with the same name','The bundling of data and methods within a single unit','The ability to perform different actions based on different conditions','C'),(13,5,'What is the main function of an operating system?','To compile programs','To manage hardware and software resources','To provide internet connectivity','To design user interfaces','B'),(14,5,'Which of the following is a primary key in a database?','A unique identifier for a record','A field that stores the same value for all records','A non-unique field used for searching','A field used to store large amounts of data','A'),(15,6,'What is the primary function of red blood cells in the human body?','To fight infections','To carry oxygen','To clot blood','To produce antibodies','B'),(16,6,'Which organ is responsible for filtering blood and producing urine?','Liver','Heart','Kidney','Lungs','C'),(17,6,'What is the basic structural and functional unit of the nervous system?','Neuron','Glial cell','Axon','Synapse','A'),(18,6,'Which of the following is a common symptom of diabetes mellitus?','Frequent urination','Low blood pressure','Hair loss','Joint pain','A');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_results`
--

DROP TABLE IF EXISTS `test_results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `test_results` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `test_id` int DEFAULT NULL,
  `score` int DEFAULT NULL,
  `feedback` text,
  PRIMARY KEY (`id`),
  KEY `fk_test_results_user_id` (`user_id`),
  KEY `fk_test_results_test_id` (`test_id`),
  CONSTRAINT `fk_test_results_test_id` FOREIGN KEY (`test_id`) REFERENCES `mock_tests` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_test_results_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_results`
--

LOCK TABLES `test_results` WRITE;
/*!40000 ALTER TABLE `test_results` DISABLE KEYS */;
INSERT INTO `test_results` VALUES (9,19,5,3,NULL),(10,22,6,1,NULL),(15,22,5,3,'Your test score is 3.');
/*!40000 ALTER TABLE `test_results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_courses`
--

DROP TABLE IF EXISTS `user_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `course_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_courses_user_id` (`user_id`),
  KEY `fk_user_courses_course_id` (`course_id`),
  CONSTRAINT `fk_user_courses_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_user_courses_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_courses`
--

LOCK TABLES `user_courses` WRITE;
/*!40000 ALTER TABLE `user_courses` DISABLE KEYS */;
INSERT INTO `user_courses` VALUES (19,19,15),(20,19,16),(22,22,16),(23,22,15);
/*!40000 ALTER TABLE `user_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_responses`
--

DROP TABLE IF EXISTS `user_responses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_responses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `test_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `selected_option` char(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `test_id` (`test_id`),
  KEY `question_id` (`question_id`),
  CONSTRAINT `user_responses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `user_responses_ibfk_2` FOREIGN KEY (`test_id`) REFERENCES `mock_tests` (`id`),
  CONSTRAINT `user_responses_ibfk_3` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_responses`
--

LOCK TABLES `user_responses` WRITE;
/*!40000 ALTER TABLE `user_responses` DISABLE KEYS */;
INSERT INTO `user_responses` VALUES (1,22,5,12,'C'),(2,22,5,13,'B'),(3,22,5,14,'A');
/*!40000 ALTER TABLE `user_responses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(1) DEFAULT '0',
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `address` text,
  `highest_qualification` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user','mentor') NOT NULL DEFAULT 'user',
  `gender` enum('male','female') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'anishthangakiru444@gmail.com','$2y$10$YKfDXWPe9YnrjfZItEXEq.eqsVj31Na0CnBXAHniIZTopQh3josWC',1,'Anish','Thangamani','2004-04-04','No 23, vinayagar st., perumal nagar, v manaveli, puducherry-605 110','B.Tech IT','anishthangakiru444@gmail.com','9345690672','admin','male'),(18,'username1','$2y$10$i1T3pylP8zxjookXflcXz.vrPW2ySYY43FaSD5.LWpTupEOvE/fL6',1,'Charumadhi','Thourai','2024-07-11','Puducherry technological university, pillaichavady','B Tech IT','Charu05@gmail.com','09345690672','mentor','male'),(19,'Chozha','$2y$10$IGl3DVDyQgOcJKXYkoUKvuDiIQZRJCj6BxyfLRXLhEiE1V5QAwL3q',1,'Chozha','Valavan','2004-08-28','adgagsgasddga','B Tech IT','chozha@gmail.com','9345690672','user','male'),(20,'Abhinav','$2y$10$DF96sIjPalsXXtDwOKe4tunY6fuDncFNDQ5kppGZkY5sxNkEN/0xG',1,'Abhinav','Sankar','2004-04-04','afsddafsdfasdgasd','B Tech IT','abhinav01@gmail.com','8015700672','mentor','male'),(21,'john_doe','$2y$10$HhhNoy4V7U7vX3uj4dq3OeTfgpJ/fTpuZpie7TDp30HqqHsKAj4ZG',1,'John','Doe','2000-07-01','Thirunelveli, Tamil Nadu','12 th Grade','johndoe_04@gmail.com','9345690672','user','male'),(22,'abhi','$2y$10$XhVqwLEc/PvbJ6kCV63sfe.QXda4K5x.1Vn6bITvBiVI515EOpfUW',1,'Abhinav','S','2024-07-16','123','b tech IT','abhinav01@gmail.com','93456','user','male');
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

-- Dump completed on 2024-07-24 20:35:00
