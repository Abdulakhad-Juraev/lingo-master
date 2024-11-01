-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 05, 2024 at 12:52 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` int(11) NOT NULL,
  `name_uz` varchar(60) DEFAULT NULL,
  `name_oz` varchar(60) DEFAULT NULL,
  `name_ru` varchar(60) DEFAULT NULL,
  `name_en` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `regions`
--

INSERT INTO `regions` (`id`, `name_uz`, `name_oz`, `name_ru`, `name_en`) VALUES
(1, 'Qoraqalpog‘iston Respublikasi', 'Қорақалпоғистон Республикаси', 'Республика Каракалпакстан', 'Republic of Karakalpakstan'),
(2, 'Andijon viloyati', 'Андижон вилояти', 'Андижанская область', 'Andijan region'),
(3, 'Buxoro viloyati', 'Бухоро вилояти', 'Бухарская область', 'Bukhara region'),
(4, 'Jizzax viloyati', 'Жиззах вилояти', 'Джизакская область', 'Jizzakh region'),
(5, 'Qashqadaryo viloyati', 'Қашқадарё вилояти', 'Кашкадарьинская область', 'Kashkadarya region'),
(6, 'Navoiy viloyati', 'Навоий вилояти', 'Навоийская область', 'Navoiy region'),
(7, 'Namangan viloyati', 'Наманган вилояти', 'Наманганская область', 'Namangan region'),
(8, 'Samarqand viloyati', 'Самарқанд вилояти', 'Самаркандская область', 'Samarkand region'),
(9, 'Surxandaryo viloyati', 'Сурхандарё вилояти', 'Сурхандарьинская область', 'Surkhandarya region'),
(10, 'Sirdaryo viloyati', 'Сирдарё вилояти', 'Сырдарьинская область', 'Syrdarya region'),
(11, 'Toshkent viloyati', 'Тошкент вилояти', 'Ташкентская область', 'Tashkent region'),
(12, 'Farg‘ona viloyati', 'Фарғона вилояти', 'Ферганская область', 'Fergana region'),
(13, 'Xorazm viloyati', 'Хоразм вилояти', 'Хорезмская область', 'Khorezm region'),
(14, 'Toshkent shahri', 'Тошкент шаҳри', 'Город Ташкент', 'Tashkent city');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
