-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS = @@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION = @@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE = @@TIME_ZONE */;
/*!40103 SET TIME_ZONE = '+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS = @@UNIQUE_CHECKS, UNIQUE_CHECKS = 0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;

--
-- Table structure for table `pizzas`
--

DROP TABLE IF EXISTS `pizzas`;
/*!40101 SET @saved_cs_client = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pizzas`
(
    `pizza_id`    int(11)     NOT NULL AUTO_INCREMENT,
    `name`        varchar(50) NOT NULL,
    `description` varchar(255) DEFAULT NULL,
    `price`       double      NOT NULL,
    `discount`    double       DEFAULT NULL,
    `image`       varchar(50)  DEFAULT NULL,
    `active`      tinyint(1)  NOT NULL,
    PRIMARY KEY (`pizza_id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 12
  DEFAULT CHARSET = utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pizzas`
--

LOCK TABLES `pizzas` WRITE;
/*!40000 ALTER TABLE `pizzas`
    DISABLE KEYS */;
INSERT INTO `pizzas`
VALUES (1, 'Margherita', 'The standard', 12, NULL, 'margherita.jpg', 1),
       (2, 'Prosciutto', 'With happy pigs', 17, NULL, 'prosciutto.jpg', 1),
       (3, 'Salami', 'With unhappy pigs', 17, NULL, 'salami.jpg', 1),
       (4, 'Funghi', 'With mario\'s mushrooms', 16, NULL, 'funghi.jpg', 1),
       (5, 'Hawaii', 'No..', 99, NULL, 'hawaii.jpg', 1),
       (6, 'Piccante', 'You are hot', 17, NULL, 'piccante.jpg', 1),
       (7, 'Tonno', 'Greta loves u', 17, NULL, 'tonno.jpg', 1),
       (8, 'Quattro formaggi', '1kg of pleasure', 18, NULL, '4formaggi.jpg', 1),
       (9, 'Napoli', 'Delicious', 15, NULL, 'napoli.jpg', 1),
       (10, 'Speciale', 'What is wrong with u?', 20, NULL, 'speciale.jpg', 1),
       (11, 'Swiss', 'we don\'t eat it ourselves, we just sell it to tourists', 22, NULL, 'swiss.jpg', 1);
/*!40000 ALTER TABLE `pizzas`
    ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE = @OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE = @OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS = @OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS = @OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS = @OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION = @OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES = @OLD_SQL_NOTES */;

-- Dump completed on 2022-09-20 14:24:07
