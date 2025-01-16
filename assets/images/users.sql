-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2025 at 07:46 PM
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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('member','partner','admin') NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `email`) VALUES
(1, 'admin', '123456', 'admin', NULL),
(2, 'member1', '123456', 'member', 'c2004@gmail.com'),
(3, 'member2', '123456', 'member', NULL),
(4, 'member3', '123456', 'member', NULL),
(5, 'member4', '123456', 'member', NULL),
(6, 'member5', '123456', 'member', NULL),
(7, 'member6', '123456', 'member', NULL),
(8, 'member7', '123456', 'member', NULL),
(9, 'member8', '123456', 'member', NULL),
(10, 'member9', '123456', 'member', NULL),
(11, 'partner1', '123456', 'partner', NULL),
(12, 'partner2', '$2y$10$jAAm76ovSk27dZ3tleBI/uOHQOabPVrocnqe4bACnOtztmwtJwBSS', 'partner', 'chichgamer84@gmail.com'),
(13, 'partner3', '123456', 'partner', NULL),
(14, 'partner4', '123456', 'partner', NULL),
(15, 'partner5', '123456', 'partner', NULL),
(16, 'partner6', '123456', 'partner', NULL),
(17, 'partner7', '123456', 'partner', NULL),
(18, 'partner8', '123456', 'partner', NULL),
(19, 'partner9', '123456', 'partner', NULL),
(20, 'partner10', '123456', 'partner', NULL),
(21, 'partner11', '123456', 'partner', NULL),
(22, 'partner12', '123456', 'partner', NULL),
(23, 'partner13', '123456', 'partner', NULL),
(25, 'partner15', '123456', 'partner', NULL),
(26, 'partner16', '123456', 'partner', NULL),
(27, 'partner17', '123456', 'partner', NULL),
(28, 'partner18', '123456', 'partner', NULL),
(29, 'partner19', '123456', 'partner', NULL),
(30, 'partner20', '123456', 'partner', NULL),
(31, 'partner21', '$2y$10$bP0DYFLgNT6G1nIgFlx6x.hdFS.lrYlQrZAMETBOCVIRhZC622ie6', 'partner', 'c2004oct@gmail.sqdcom'),
(32, 'partner22', '123456', 'partner', NULL),
(33, 'partner23', '123456', 'partner', NULL),
(34, 'partner24', '123456', 'partner', NULL),
(35, 'partner25', '123456', 'partner', NULL),
(36, 'partner26', '123456', 'partner', NULL),
(37, 'partner27', '123456', 'partner', NULL),
(38, 'partner28', '123456', 'partner', NULL),
(39, 'partner29', '123456', 'partner', NULL),
(40, 'partner30', '123456', 'partner', NULL),
(43, 'abc', '123456', 'member', 'abc@gmail.com'),
(50, 'chamil', '123456', 'member', 'lc_bouacha@esi.dz'),
(51, 'abdessamad', '123456', 'member', 'ka_seddiki@esi.dz'),
(56, 'chamil1', '123456', 'member', 'lc_bouachads@esi.dz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `idx_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
