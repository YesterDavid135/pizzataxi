-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 30, 2022 at 10:18 AM
-- Server version: 5.7.34
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzataxi`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
                          `order_id` int(11) NOT NULL,
                          `fk_user` int(11) DEFAULT NULL,
                          `status` int(11) NOT NULL DEFAULT '0',
                          `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
                               `id_order_items` int(11) NOT NULL,
                               `quantity` int(11) DEFAULT NULL,
                               `fk_order` int(11) NOT NULL,
                               `discount` double DEFAULT NULL,
                               `fk_pizza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `pizzas`
--

DROP TABLE IF EXISTS `pizzas`;
CREATE TABLE `pizzas`(
                          `pizza_id` int(11) NOT NULL,
                          `name` varchar(50) NOT NULL,
                          `description` varchar(255) DEFAULT NULL,
                          `price` double NOT NULL,
                          `discount` double DEFAULT NULL,
                          `image` varchar(50) DEFAULT NULL,
                          `active` tinyint(1) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`pizza_id`, `name`, `description`, `price`, `discount`, `image`, `active`)
VALUES (1, 'Margherita', 'The standard', 12, NULL, 'margherita.jpg', 1),
       (2, 'Prosciutto', 'With happy pigs', 17, NULL, 'prosciutto.jpg', 1),
       (3, 'Salami', 'With unhappy pigs', 17, NULL, 'salami.jpg', 1),
       (4, 'Brokkoli', 'Only for Vivi', 15.5, NULL, 'brokkoli.jpg', 1),
       (5, 'Funghi', 'With mario\'s mushrooms', 16, NULL, 'funghi.jpg', 1),
       (6, 'Hawaii', 'No..', 99, NULL, 'hawaii.jpg', 1),
       (7, 'Piccante', 'You are hot', 17, NULL, 'piccante.jpg', 1),
       (8, 'Tonno', 'Greta loves u', 17, NULL, 'tonno.jpg', 1),
       (9, 'Quattro formaggi', '1kg of pleasure', 18, NULL, '4formaggi.jpg', 1),
       (10, 'Napoli', 'Delicious', 15, 11, 'napoli.jpg', 1),
       (11, 'Speciale', 'What is wrong with u?', 20, NULL, 'speciale.jpg', 1),
       (12, 'Swiss', 'we don\'t eat it ourselves, we just sell it to tourists', 22, NULL, 'swiss.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`
(
    `user_id`   int(11)     NOT NULL,
    `username`  varchar(30) NOT NULL UNIQUE,
    `firstname` varchar(30)  DEFAULT NULL,
    `lastname`  varchar(30)  DEFAULT NULL,
    `mail`      varchar(100) DEFAULT NULL,
    `password`  varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
    ADD PRIMARY KEY (`order_id`),
    ADD KEY `fk_user` (`fk_user`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
    ADD PRIMARY KEY (`id_order_items`),
    ADD UNIQUE KEY `id_order_items` (`id_order_items`),
    ADD KEY `fk_pizza` (`fk_pizza`),
    ADD KEY `fk_order` (`fk_order`);

--
-- Indexes for table `pizzas`
--
ALTER TABLE `pizzas`
    ADD PRIMARY KEY (`pizza_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`),
    ADD UNIQUE KEY `id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
    MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
    MODIFY `id_order_items` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizzas`
--
ALTER TABLE `pizzas`
    MODIFY `pizza_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
    ADD CONSTRAINT `fk_user` FOREIGN KEY (`fk_user`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
    ADD CONSTRAINT `fk_order` FOREIGN KEY (`fk_order`) REFERENCES `orders` (`order_id`),
    ADD CONSTRAINT `fk_pizza` FOREIGN KEY (`fk_pizza`) REFERENCES `pizzas` (`pizza_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
