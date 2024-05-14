-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 14, 2024 at 11:24 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `marketapplication`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `remember` varchar(200) DEFAULT NULL,
  `profile` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`email`, `password`, `name`, `remember`, `profile`, `city`, `district`, `address`) VALUES
('ali@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ali Gül', 'be14e9a7b45e3b753bfeabb481e438a572b4410a', NULL, 'Ankara', 'Eryaman', ''),
('john@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'John Lock', NULL, 'fbd506f715c932c6233489d64221fcafbd67a4cf.jpg', 'Ankara', 'Çankaya', ''),
('kate@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Kate Austen', NULL, '3ea9b3c975c188e23761cd3a7ff925543fe71256.jpg', 'Adana', 'Çukurova', '');

-- --------------------------------------------------------

--
-- Table structure for table `market_user`
--

DROP TABLE IF EXISTS `market_user`;
CREATE TABLE IF NOT EXISTS `market_user` (
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `market_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `district` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `remember` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `market_user`
--

INSERT INTO `market_user` (`email`, `market_name`, `password`, `city`, `district`, `address`, `remember`) VALUES
('cankaya@migros.com.tr', 'Migros Çankaya 2', '8cb2237d0679ca88db6464eac60da96345513964', 'Ankara', 'Çankaya', 'Çankaya, Ankara', NULL),
('cukurova@migros.com.tr', 'Migros Çukurova', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Adana', 'Çukurova', 'Çukurova, Adana', NULL),
('eryaman@migros.com.tr', 'Migros Eryaman 2', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ankara', 'Eryaman', 'Altay, 06821 Etimesgut/Ankara', '47d5724a9abc3109d2928d9790a88071d62b4558'),
('golbasi@migros.com.tr', 'Migros Gölbaşı', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ankara', 'Gölbaşı', 'Gölbaşı, Ankara', NULL),
('kecioren@migros.com.tr', 'Migros Keçiören', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ankara', 'Keçiören', 'Keçiören, Ankara', NULL),
('yenimahalle@migros.com.tr', 'Migros Yenimahalle', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ankara', 'Yenimahalle', 'Yenimahalle, Ankara', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `market_email` varchar(100) COLLATE utf8mb4_turkish_ci NOT NULL,
  `product_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_disc_price` decimal(8,2) NOT NULL,
  `product_exp_date` date NOT NULL DEFAULT '2024-05-14',
  `product_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1014 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `market_email`, `product_title`, `product_price`, `product_disc_price`, `product_exp_date`, `product_image`, `stock`) VALUES
(1000, 'eryaman@migros.com.tr', 'Egg', 2.00, 1.00, '2024-05-14', 'eggs.jpg', 15),
(1001, 'eryaman@migros.com.tr', 'Milk', 5.00, 3.00, '2024-05-14', 'milk.jpg', 15),
(1002, 'eryaman@migros.com.tr', 'Vegetables', 10.00, 2.00, '2024-05-14', 'vegetables.jpg', 15),
(1003, 'eryaman@migros.com.tr', 'Chicken2', 15.00, 3.00, '2024-05-14', 'chicken.jpeg', 15),
(1004, 'eryaman@migros.com.tr', 'Bread', 3.00, 1.00, '2024-05-14', 'bread.jpeg', 15),
(1005, 'eryaman@migros.com.tr', 'Cheesee', 8.00, 2.00, '2024-05-14', 'cheese.jpeg', 15),
(1006, 'cankaya@migros.com.tr', 'Yogurt', 4.00, 1.00, '2024-05-14', 'yogurt.jpeg', 15),
(1007, 'cankaya@migros.com.tr', 'Appless', 7.00, 3.00, '2024-05-14', 'apples.jpeg', 15),
(1008, 'cankaya@migros.com.tr', 'Rice', 12.00, 3.00, '2024-05-14', 'rice.jpeg', 20),
(1009, 'cukurova@migros.com.tr', 'Pasta', 5.00, 1.00, '2024-05-14', 'pasta.jpeg', 20),
(1012, 'cukurova@migros.com.tr', 'Battery', 11.00, 5.00, '2024-05-14', 'battery.jpeg', 20),
(1013, 'cukurova@migros.com.tr', 'Levrek', 150.00, 100.00, '2024-05-14', 'levrek.png', 20);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
