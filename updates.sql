-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Nov 22, 2025 at 03:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spoonzy`
--

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `title` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `token_id` varchar(255) NOT NULL,
  `locked` enum('yes','no') NOT NULL DEFAULT 'no',
  `fixed_post` enum('0','1') NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL,
  `status` char(20) NOT NULL DEFAULT 'active',
  `video_views` bigint(20) UNSIGNED NOT NULL,
  `ip` varchar(200) DEFAULT NULL,
  `scheduled_date` timestamp NULL DEFAULT NULL,
  `schedule` tinyint(1) NOT NULL DEFAULT 0,
  `editing` tinyint(1) NOT NULL DEFAULT 0,
  `can_media_edit` tinyint(1) NOT NULL DEFAULT 0,
  `likes_extras` bigint(20) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`id`, `title`, `description`, `user_id`, `date`, `token_id`, `locked`, `fixed_post`, `price`, `status`, `video_views`, `ip`, `scheduled_date`, `schedule`, `editing`, `can_media_edit`, `likes_extras`) VALUES
(1, 'testing post', 'testing post', 2, '2025-10-24 18:19:08', '', 'no', '0', 29.00, 'active', 0, NULL, NULL, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token_id` (`token_id`),
  ADD KEY `video_views` (`video_views`),
  ADD KEY `status` (`status`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `can_media_edit` (`can_media_edit`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
