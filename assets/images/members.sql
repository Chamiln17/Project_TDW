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
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `registration_date` date DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `id_document` varchar(255) DEFAULT NULL,
  `recu_paiement` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `is_validated` tinyint(1) NOT NULL,
  `is_blocked` tinyint(1) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `user_id`, `first_name`, `last_name`, `address`, `city`, `membership_type_id`, `registration_date`, `expiration_date`, `photo`, `id_document`, `recu_paiement`, `date_of_birth`, `is_validated`, `is_blocked`, `telephone`) VALUES
(1, 2, 'dsdqsd', 'sdsdsqdqs', 'Addsqdqsdqsress 2', 'Tébessa', 3, '2024-08-26', '2025-09-09', 'uploads/2_photo_1736818940.jpg', 'uploads/2_piece_identite_1736818940.jpg', NULL, '2004-10-16', 1, 0, '+213551234567'),
(2, 3, 'First3', 'Last3', 'Address 3', 'Annaba', 4, '2024-10-14', '2025-03-10', 'assets/images/Chamil.jpg', NULL, NULL, NULL, 0, 0, '+213662345678'),
(3, 4, 'First4', 'Last4', 'Address 4', 'Blida', 1, '2024-11-19', '2025-03-17', NULL, NULL, NULL, NULL, 0, 0, '+213773456789'),
(4, 5, 'First5', 'Last5', 'Address 5', 'Algiers', 2, '2024-07-04', '2025-01-17', NULL, NULL, NULL, NULL, 0, 0, '+213664567890'),
(5, 6, 'First6', 'Last6', 'Address 6', 'Oran', 3, '2024-06-09', '2025-11-09', NULL, NULL, NULL, NULL, 0, 0, '+213775678901'),
(6, 7, 'First7', 'Last7', 'Address 7', 'Constantine', 4, '2024-08-03', '2025-09-03', NULL, NULL, NULL, NULL, 0, 0, '+213556789012'),
(7, 8, 'First8', 'Last8', 'Address 8', 'Annaba', 1, '2024-01-19', '2025-12-04', NULL, NULL, NULL, NULL, 0, 0, '+213667890123'),
(8, 9, 'First9', 'Last9', 'Address 9', 'Blida', 2, '2024-06-02', '2025-04-30', NULL, NULL, NULL, NULL, 0, 0, '+213778901234'),
(9, 10, 'First10', 'Last10', 'Address 10', 'Algiers', 3, '2024-04-19', '2025-09-19', NULL, NULL, NULL, NULL, 0, 0, '+213559012345'),
(19, 50, 'Chamel Nadir', 'Bouacha', 'cité 322 logements batiment F numéro 4 Imama , Mansourah', 'Algiers', 1, '2025-01-11', NULL, 'uploads/50_photo_Projet TDW 2024-2025 (1).pdf', 'uploads/50_id_Projet TDW 2024-2025 (1).pdf', 'uploads/50_recu_Projet TDW 2024-2025 (1).pdf', '2004-02-16', 0, 0, '+213660123456'),
(20, 51, 'abdessamad', 'Seddiki', 'hennaya tlemcen ', 'Tlemcen', 1, '2025-01-12', NULL, 'uploads/51_photo_Projet TDW 2024-2025 (1).pdf', 'uploads/51_id_Projet TDW 2024-2025 (1).pdf', 'uploads/51_recu_Projet TDW 2024-2025 (1).pdf', '2002-09-04', 0, 0, '+213771234567'),
(21, 56, 'Chamel Nadir', 'Bouacha', 'cité 322 logements batiment F numéro 4 Imama , Mansourah', 'Tlemcen', 1, '2025-01-15', NULL, 'uploads/photos/56_photo_image.png', 'uploads/id_documents/56_id_image.png', 'uploads/recu_paiements/56_recu_Projet TDW 2024-2025 (1).pdf', '2004-10-16', 1, 0, '0793312124');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `membership_type_id` (`membership_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`membership_type_id`) REFERENCES `membership_types` (`type_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
