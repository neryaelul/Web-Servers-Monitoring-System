-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: ינואר 09, 2024 בזמן 02:55 AM
-- גרסת שרת: 8.0.35-0ubuntu0.22.04.1
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bylith-websites`
--
CREATE DATABASE IF NOT EXISTS `bylith-websites` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `bylith-websites`;

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `api_access_tokens`
--

CREATE TABLE `api_access_tokens` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `token_hash` text COLLATE utf8mb4_general_ci NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expired_time` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `history`
--

CREATE TABLE `history` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL,
  `list_id` int NOT NULL,
  `protocol_check_type` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `http_response_codes` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- מבנה טבלה עבור טבלה `hosts`
--

CREATE TABLE `hosts` (
  `id` int NOT NULL,
  `time` timestamp NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `protocols` text COLLATE utf8mb4_general_ci NOT NULL,
  `disabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- אינדקסים לטבלה `api_access_tokens`
--
ALTER TABLE `api_access_tokens`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- אינדקסים לטבלה `hosts`
--
ALTER TABLE `hosts`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `api_access_tokens`
--
ALTER TABLE `api_access_tokens`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hosts`
--
ALTER TABLE `hosts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
