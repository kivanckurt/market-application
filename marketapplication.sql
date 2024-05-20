-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 20, 2024 at 07:59 PM
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
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `remember` varchar(200) DEFAULT NULL,
  `profile` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `address` varchar(100) NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10004 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `email`, `password`, `name`, `remember`, `profile`, `city`, `district`, `address`) VALUES
(10000, 'ali@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Ali Güll', NULL, NULL, 'Ankara', 'Eryaman', 'Eryaman Ankara 2'),
(10001, 'john@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'John Lock', NULL, 'fbd506f715c932c6233489d64221fcafbd67a4cf.jpg', 'Ankara', 'Çankaya', ''),
(10002, 'kate@gmail.com', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'Kate Austen', NULL, '3ea9b3c975c188e23761cd3a7ff925543fe71256.jpg', 'Adana', 'Çukurova', ''),
(10003, 'kvangoku@yandex.com', '4c605e00c7d95fc626629c2b1abddbb0c782971c', 'Kivanc', NULL, NULL, 'Adana', 'Çukurova', 'Huzurevleri Mah');

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
('eryaman@migros.com.tr', 'Migros Eryaman 3', '8cb2237d0679ca88db6464eac60da96345513964', 'Ankara', 'Eryaman', 'Altay, 06822 Etimesgut/Ankaraa', NULL),
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
  `product_title` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `product_price` decimal(8,2) NOT NULL,
  `product_disc_price` decimal(8,2) NOT NULL,
  `product_exp_date` date NOT NULL DEFAULT '2024-05-14',
  `product_image` varchar(255) COLLATE utf8mb4_turkish_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1065 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `market_email`, `product_title`, `product_price`, `product_disc_price`, `product_exp_date`, `product_image`, `stock`) VALUES
(1006, 'cankaya@migros.com.tr', 'Yogurt', 4.00, 1.00, '2024-05-14', 'yogurt.jpeg', 15),
(1007, 'cankaya@migros.com.tr', 'Appless', 7.00, 3.00, '2024-05-14', 'apples.jpeg', 15),
(1008, 'cankaya@migros.com.tr', 'Rice', 12.00, 3.00, '2024-05-14', 'rice.jpeg', 20),
(1009, 'cukurova@migros.com.tr', 'Pasta', 5.00, 1.00, '2024-05-14', 'pasta.jpeg', 20),
(1012, 'cukurova@migros.com.tr', 'Battery', 11.00, 5.00, '2024-05-14', 'battery.jpeg', 20),
(1013, 'cukurova@migros.com.tr', 'Levrek', 150.00, 100.00, '2024-05-14', 'levrek.png', 20),
(1017, 'cankaya@migros.com.tr', 'Banana', 3.00, 2.00, '2024-05-30', 'Banana-PNG-Picture.png', 44),
(1018, 'cukurova@migros.com.tr', 'Almonds', 2.99, 1.99, '2024-05-24', 'Almond-Free-Download-PNG.png', 67),
(1019, 'eryaman@migros.com.tr', 'Avocado', 4.99, 3.49, '2024-05-22', 'pngtree-avocado-png-avocado-fruit-ai-generated-png-image_10153887.png', 77),
(1020, 'golbasi@migros.com.tr', 'Carrot', 3.99, 3.99, '2024-07-25', 'red-carrot-red-carrot-transparent-background-ai-generated-free-png.webp', 32),
(1021, 'kecioren@migros.com.tr', 'Strawberries', 2.99, 2.69, '2024-05-30', 'ebd4deb64c74e2f1246626d5a290274d.png', 83),
(1022, 'yenimahalle@migros.com.tr', 'Blueberries', 7.99, 4.00, '2024-05-03', '83e7cb22c15636563f5e0a3d53eeb3db.png', 59),
(1023, 'cankaya@migros.com.tr', 'Eggs', 5.00, 4.50, '2024-05-30', 'pngimg.com - egg_PNG40811.png', 23),
(1024, 'cukurova@migros.com.tr', 'Orange', 4.99, 4.49, '2024-05-18', 'orange-poster.png', 68),
(1025, 'eryaman@migros.com.tr', 'Pineapple', 9.99, 8.99, '2024-05-30', 'pineapple-pineapple-pineapple-transparent-background-ai-generated-free-png.webp', 77),
(1026, 'golbasi@migros.com.tr', 'Bread', 2.00, 2.00, '2024-05-12', 'bread.png', 50),
(1027, 'kecioren@migros.com.tr', 'Corn', 7.00, 5.60, '2024-05-19', 'yellow-corn-isolated-png.webp', 64),
(1028, 'yenimahalle@migros.com.tr', 'Broccoli', 4.00, 3.60, '2024-05-31', 'broccoli-broccoli-broccoli-transparent-background-ai-generated-free-png.webp', 21),
(1029, 'cankaya@migros.com.tr', 'Egg', 3.00, 2.70, '2024-05-30', 'pngimg.com - egg_PNG40811.png', 91),
(1030, 'cukurova@migros.com.tr', 'Bananaaa', 4.00, 3.20, '2024-05-22', 'Banana-PNG-Picture.png', 46),
(1031, 'eryaman@migros.com.tr', 'Tomato', 4.00, 3.60, '2024-05-30', 'tomatopng.parspng.com-3.png', 87),
(1032, 'golbasi@migros.com.tr', 'Cheese', 2.49, 1.99, '2024-05-23', 'Cheese-Transparent.png', 57),
(1033, 'kecioren@migros.com.tr', 'Pie', 7.99, 7.19, '2024-05-29', 'apple-pie-transparent-png.webp', 39),
(1034, 'yenimahalle@migros.com.tr', 'Yogurt', 4.00, 3.20, '2024-05-24', 'bowl-of-strawberry-yogurt-on-transparent-background-free-png.webp', 72),
(1035, 'cankaya@migros.com.tr', 'Ayran', 0.99, 0.89, '2024-06-07', 'Ayran_200ml.png', 56),
(1036, 'cukurova@migros.com.tr', 'Grapes', 3.00, 2.70, '2024-06-04', 'Grape_PNG_Free_Clip_Art_Image.png', 44),
(1037, 'eryaman@migros.com.tr', 'Kiwi', 4.00, 4.00, '2024-07-04', 'Kiwi-PNG.png', 83),
(1038, 'golbasi@migros.com.tr', 'Cherry', 2.79, 2.51, '2024-05-30', 'pngimg.com - cherry_PNG609.png', 29),
(1039, 'kecioren@migros.com.tr', 'Lime', 3.00, 2.70, '2024-05-29', 'pngimg.com - lime_PNG21.png', 91),
(1040, 'yenimahalle@migros.com.tr', 'Lemon', 1.49, 1.34, '2024-06-09', 'pngtree-lemon-png-images-with-transparent-background-png-image_6095484.png', 40),
(1041, 'cankaya@migros.com.tr', 'Mango', 5.69, 5.12, '2024-05-30', 'pngtree-mango-realistic-fruit-photo-png-image_6658362.png', 73),
(1042, 'cukurova@migros.com.tr', 'Peach', 5.00, 5.00, '2024-07-25', 'purepng.com-peachfruitspeach-981524762023fxagv.png', 25),
(1043, 'eryaman@migros.com.tr', 'Watermelon', 9.89, 8.90, '2024-06-06', 'watermelon-transparent-background-free-png.webp', 67),
(1044, 'golbasi@migros.com.tr', 'Apple', 1.99, 1.49, '2024-06-30', 'apple.png', 53),
(1045, 'kecioren@migros.com.tr', 'Beef', 9.99, 8.49, '2024-05-25', 'beef.png', 46),
(1046, 'yenimahalle@migros.com.tr', 'Chicken Breast', 6.99, 5.99, '2024-06-01', 'chicken_breast.png', 52),
(1047, 'cankaya@migros.com.tr', 'Spinach', 2.49, 1.99, '2024-05-28', 'spinach.png', 27),
(1048, 'cukurova@migros.com.tr', 'Cauliflower', 3.49, 2.99, '2024-05-22', 'cauliflower.png', 65),
(1049, 'eryaman@migros.com.tr', 'Milk', 1.49, 1.29, '2024-05-18', 'milk.png', 31),
(1050, 'golbasi@migros.com.tr', 'Butter', 2.99, 2.49, '2024-06-10', 'butter.png', 81),
(1051, 'kecioren@migros.com.tr', 'Yogurt', 1.99, 1.69, '2024-06-15', 'yogurt.png', 28),
(1052, 'yenimahalle@migros.com.tr', 'Almond Milk', 3.99, 3.49, '2024-07-05', 'almond_milk.png', 54),
(1053, 'cankaya@migros.com.tr', 'Whole Wheat Bread', 2.49, 2.19, '2024-05-12', 'whole_wheat_bread.png', 61),
(1054, 'cukurova@migros.com.tr', 'Croissant', 1.99, 1.79, '2024-05-15', 'croissant.png', 49),
(1055, 'eryaman@migros.com.tr', 'Chocolate Chip Cookies', 3.49, 2.99, '2024-05-20', 'chocolate_chip_cookies.png', 19),
(1056, 'golbasi@migros.com.tr', 'Salmon', 12.99, 11.99, '2024-05-25', 'salmon.png', 79),
(1057, 'kecioren@migros.com.tr', 'Tuna', 10.99, 9.99, '2024-06-01', 'tuna.png', 68),
(1058, 'yenimahalle@migros.com.tr', 'Pork Chops', 8.99, 7.99, '2024-05-18', 'pork_chops.png', 87),
(1059, 'cankaya@migros.com.tr', 'Ground Beef', 6.49, 5.99, '2024-05-22', 'ground_beef.png', 32),
(1060, 'cukurova@migros.com.tr', 'Nectarine', 1.49, 1.29, '2024-07-01', 'peach.png', 41),
(1061, 'eryaman@migros.com.tr', 'Plum', 1.99, 1.69, '2024-06-20', 'plum.png', 70),
(1062, 'golbasi@migros.com.tr', 'Pear', 1.79, 1.49, '2024-06-15', 'pear.png', 38),
(1063, 'kecioren@migros.com.tr', 'Watermelon', 4.99, 4.49, '2024-07-10', 'watermelon.png', 50),
(1064, 'yenimahalle@migros.com.tr', 'Cantaloupe', 3.99, 3.49, '2024-06-25', 'cantaloupe.png', 66);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
