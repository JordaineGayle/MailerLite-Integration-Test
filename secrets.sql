-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 28, 2021 at 03:50 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mailerlite`
--

-- --------------------------------------------------------

--
-- Table structure for table `secrets`
--

CREATE TABLE `secrets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `secrets`
--

INSERT INTO `secrets` (`id`, `user`, `token`) VALUES
(1, '1627378812252', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(3, '1627379284373', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(4, '1627379295916', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(5, '1627379400780', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(6, '1627379510852', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(7, '1627379655677', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(8, '1627379848916', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(9, '1627379909244', 'fc7b8c5b32067bcd47cafb5f475d2fe9'),
(10, '1627382797595', 'fc7b8c5b32067bcd47cafb5f475d2fe9');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `secrets`
--
ALTER TABLE `secrets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `secrets`
--
ALTER TABLE `secrets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
