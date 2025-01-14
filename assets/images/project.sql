-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 12:27 AM
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
-- Table structure for table `advantages`
--

CREATE TABLE `advantages` (
  `advantage_id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `advantages`
--

INSERT INTO `advantages` (`advantage_id`, `partner_id`, `membership_type_id`, `description`, `start_date`, `end_date`) VALUES
(1, 1, 1, 'Free health checkup for Classic members', '2024-12-01', '2025-12-31'),
(2, 2, 2, 'Exclusive access to member-only events for Premium members', '2025-01-01', '2025-12-31'),
(3, 3, 3, 'Free gym membership for a month for Youth members', '2025-02-01', '2025-03-01'),
(4, 4, 4, 'Complimentary meal for Senior members at partner restaurants', '2025-03-01', '2025-03-31'),
(5, 5, 1, 'Discount on travel packages for Classic members', '2025-04-01', '2025-04-30'),
(6, 6, 2, 'Priority booking for Premium members at partner hotels', '2025-05-01', '2025-05-31'),
(7, 7, 3, 'Free online courses for Youth members', '2025-06-01', '2025-06-30'),
(8, 8, 4, 'Discounted spa services for Senior members', '2025-07-01', '2025-07-31'),
(9, 9, 1, 'Free consultation for Classic members at partner clinics', '2025-08-01', '2025-08-31'),
(10, 10, 2, 'Exclusive discounts on educational materials for Premium members', '2025-09-01', '2025-09-30'),
(11, 11, 3, 'Free movie tickets for Youth members', '2025-10-01', '2025-10-31'),
(12, 12, 4, 'Discounted home delivery services for Senior members', '2025-11-01', '2025-11-30'),
(13, 13, 1, 'Free parking for Classic members at partner locations', '2025-12-01', '2025-12-31'),
(14, 14, 2, 'Complimentary upgrade to Premium services for Premium members', '2026-01-01', '2026-01-31'),
(15, 15, 3, 'Free fitness classes for Youth members', '2026-02-01', '2026-02-28'),
(16, 16, 4, 'Discounted medical supplies for Senior members', '2026-03-01', '2026-03-31'),
(17, 17, 1, 'Free Wi-Fi access for Classic members at partner locations', '2026-04-01', '2026-04-30'),
(18, 18, 2, 'Exclusive discounts on travel insurance for Premium members', '2026-05-01', '2026-05-31'),
(19, 19, 3, 'Free career counseling for Youth members', '2026-06-01', '2026-06-30'),
(20, 20, 4, 'Discounted home maintenance services for Senior members', '2026-07-01', '2026-07-31');

-- --------------------------------------------------------

--
-- Table structure for table `aid_requests`
--

CREATE TABLE `aid_requests` (
  `aid_request_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `requester_name` varchar(255) DEFAULT NULL,
  `requester_email` varchar(255) DEFAULT NULL,
  `aid_type_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `submission_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aid_requests`
--

INSERT INTO `aid_requests` (`aid_request_id`, `member_id`, `requester_name`, `requester_email`, `aid_type_id`, `description`, `status`, `submission_date`) VALUES
(1, 2, 'First2 Last2', 'member2@example.com', 1, 'Need assistance with medical expenses', 'Pending', '2025-01-03'),
(2, 3, 'First3 Last3', 'member3@example.com', 2, 'Requesting educational support for children', 'Approved', '2024-12-29'),
(3, 4, 'First4 Last4', 'member4@example.com', 3, 'Seeking housing assistance', 'Under Review', '2024-12-24'),
(4, 5, 'First5 Last5', 'member5@example.com', 4, 'Need assistance with medical expenses', 'Pending', '2024-12-19'),
(5, 6, 'First6 Last6', 'member6@example.com', 5, 'Requesting educational support for children', 'Approved', '2024-12-14'),
(6, 7, 'First7 Last7', 'member7@example.com', 1, 'Seeking housing assistance', 'Under Review', '2024-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `aid_types`
--

CREATE TABLE `aid_types` (
  `aid_type_id` int(11) NOT NULL,
  `aid_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aid_types`
--

INSERT INTO `aid_types` (`aid_type_id`, `aid_type_name`) VALUES
(1, 'Medical Assistance'),
(2, 'Educational Support'),
(3, 'Financial Aid'),
(4, 'Housing Assistance'),
(5, 'Food Support');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Hotels'),
(2, 'Clinics'),
(3, 'Schools'),
(4, 'Travel Agencies'),
(5, 'Restaurants'),
(6, 'Pharmacies');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(255) NOT NULL,
  `order_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city_name`, `order_num`) VALUES
(1, 'Adrar', 1),
(2, 'Chlef', 2),
(3, 'Laghouat', 3),
(4, 'Oum El Bouaghi', 4),
(5, 'Batna', 5),
(6, 'Béjaïa', 6),
(7, 'Biskra', 7),
(8, 'Béchar', 8),
(9, 'Blida', 9),
(10, 'Bouïra', 10),
(11, 'Tamanrasset', 11),
(12, 'Tébessa', 12),
(13, 'Tlemcen', 13),
(14, 'Tiaret', 14),
(15, 'Tizi Ouzou', 15),
(16, 'Algiers', 16),
(17, 'Djelfa', 17),
(18, 'Jijel', 18),
(19, 'Sétif', 19),
(20, 'Saïda', 20),
(21, 'Skikda', 21),
(22, 'Sidi Bel Abbès', 22),
(23, 'Annaba', 23),
(24, 'Guelma', 24),
(25, 'Constantine', 25),
(26, 'Médéa', 26),
(27, 'Mostaganem', 27),
(28, 'M\'Sila', 28),
(29, 'Mascara', 29),
(30, 'Ouargla', 30),
(31, 'Oran', 31),
(32, 'El Bayadh', 32),
(33, 'Illizi', 33),
(34, 'Bordj Bou Arréridj', 34),
(35, 'Boumerdès', 35),
(36, 'El Tarf', 36),
(37, 'Tindouf', 37),
(38, 'Tissemsilt', 38),
(39, 'El Oued', 39),
(40, 'Khenchela', 40),
(41, 'Souk Ahras', 41),
(42, 'Tipaza', 42),
(43, 'Mila', 43),
(44, 'Aïn Defla', 44),
(45, 'Naâma', 45),
(46, 'Aïn Témouchent', 46),
(47, 'Ghardaïa', 47),
(48, 'Relizane', 48),
(49, 'In Guezzam', 49),
(50, 'In Salah', 50),
(51, 'Béni Abbès', 51),
(52, 'Djanet', 52),
(53, 'El M\'Ghair', 53),
(54, 'Touggourt', 54),
(55, 'Timimoun', 55),
(56, 'Bordj Baji Mokhtar', 56),
(57, 'Ouled Djellal', 57),
(58, 'Meniaa', 58);

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` int(11) NOT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `membership_type_id` int(11) DEFAULT NULL,
  `discount_percentage` decimal(5,2) NOT NULL,
  `description` text NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_id`, `partner_id`, `membership_type_id`, `discount_percentage`, `description`, `start_date`, `end_date`) VALUES
(1, 1, 1, 32.31, '32.31% off on medical services for Classic members', '2024-12-30', '2025-06-15'),
(2, 1, 2, 27.17, '27.17% discount on educational materials for Premium members', '2024-12-29', '2025-12-23'),
(3, 1, 4, 38.46, '38.46% off on financial aid for Senior members', '2024-12-23', '2025-12-16'),
(4, 2, 1, 19.14, '19.14% off on medical services for Classic members', '2024-12-26', '2025-05-11'),
(5, 2, 2, 30.72, '30.72% discount on educational materials for Premium members', '2024-12-27', '2025-02-04'),
(6, 2, 3, 16.57, '16.57% off on financial aid for Youth members', '2024-12-15', '2025-07-03'),
(7, 3, 1, 15.19, '15.19% off on medical services for Classic members', '2024-12-31', '2025-12-16'),
(8, 3, 3, 39.86, '39.86% discount on financial aid for Youth members', '2025-01-06', '2025-07-13'),
(9, 3, 4, 33.03, '33.03% off on housing assistance for Senior members', '2025-01-07', '2025-12-31'),
(10, 4, 3, 15.65, '15.65% discount on financial aid for Youth members', '2025-01-03', '2025-06-11'),
(11, 5, 1, 12.81, '12.81% off on medical services for Classic members', '2024-12-25', '2025-02-14'),
(12, 5, 2, 13.87, '13.87% discount on educational materials for Premium members', '2024-12-28', '2025-07-14'),
(13, 5, 3, 28.66, '28.66% off on financial aid for Youth members', '2024-12-15', '2025-03-16'),
(14, 5, 4, 37.64, '37.64% off on housing assistance for Senior members', '2025-01-05', '2025-11-10'),
(15, 6, 4, 12.33, '12.33% off on food support for Senior members', '2025-01-07', '2025-02-06'),
(16, 7, 1, 34.97, '34.97% off on medical services for Classic members', '2024-12-24', '2025-02-08'),
(17, 7, 3, 12.71, '12.71% discount on financial aid for Youth members', '2025-01-08', '2025-10-22'),
(18, 8, 1, 11.51, '11.51% off on medical services for Classic members', '2024-12-16', '2025-11-07'),
(19, 8, 3, 24.04, '24.04% discount on financial aid for Youth members', '2024-12-31', '2025-12-23'),
(20, 11, 2, 39.05, '39.05% off on educational materials for Premium members', '2024-12-31', '2025-07-02'),
(21, 11, 4, 20.11, '20.11% off on housing assistance for Senior members', '2024-12-26', '2025-04-16'),
(22, 12, 2, 28.22, '28.22% discount on educational materials for Premium members', '2024-12-19', '2025-09-12'),
(23, 12, 3, 22.09, '22.09% off on financial aid for Youth members', '2025-01-04', '2025-07-31'),
(24, 12, 4, 10.03, '10.03% off on food support for Senior members', '2024-12-10', '2026-01-02'),
(25, 13, 4, 21.78, '21.78% off on housing assistance for Senior members', '2025-01-05', '2025-06-09'),
(26, 14, 2, 35.23, '35.23% discount on educational materials for Premium members', '2024-12-10', '2025-05-28'),
(27, 15, 2, 30.69, '30.69% discount on educational materials for Premium members', '2025-01-01', '2025-04-13'),
(28, 16, 1, 20.55, '20.55% off on medical services for Classic members', '2024-12-17', '2025-09-26'),
(29, 16, 2, 23.23, '23.23% discount on educational materials for Premium members', '2025-01-01', '2025-12-15'),
(30, 17, 1, 34.95, '34.95% off on medical services for Classic members', '2024-12-27', '2025-08-06'),
(31, 17, 3, 21.59, '21.59% discount on financial aid for Youth members', '2024-12-23', '2025-08-14'),
(32, 17, 4, 37.62, '37.62% off on housing assistance for Senior members', '2024-12-22', '2025-02-10'),
(33, 18, 2, 14.58, '14.58% discount on educational materials for Premium members', '2024-12-30', '2025-02-24'),
(34, 18, 4, 24.34, '24.34% off on food support for Senior members', '2025-01-07', '2025-10-13'),
(35, 19, 2, 36.71, '36.71% discount on educational materials for Premium members', '2024-12-14', '2025-08-29'),
(36, 19, 4, 38.65, '38.65% off on housing assistance for Senior members', '2024-12-31', '2025-08-13'),
(37, 20, 1, 31.74, '31.74% off on medical services for Classic members', '2024-12-30', '2025-06-04'),
(38, 20, 2, 14.47, '14.47% discount on educational materials for Premium members', '2024-12-24', '2025-03-21'),
(39, 20, 3, 23.53, '23.53% off on financial aid for Youth members', '2025-01-08', '2025-10-16'),
(40, 21, 3, 21.67, '21.67% discount on financial aid for Youth members', '2025-01-02', '2026-01-03'),
(41, 21, 4, 18.32, '18.32% off on housing assistance for Senior members', '2024-12-20', '2025-05-25'),
(42, 22, 3, 14.56, '14.56% discount on financial aid for Youth members', '2024-12-25', '2025-12-19'),
(43, 22, 4, 29.02, '29.02% off on housing assistance for Senior members', '2024-12-31', '2025-07-16'),
(44, 23, 2, 24.10, '24.10% discount on educational materials for Premium members', '2024-12-11', '2025-04-21'),
(45, 23, 4, 39.44, '39.44% off on housing assistance for Senior members', '2024-12-26', '2025-04-02'),
(46, 24, 3, 38.13, '38.13% discount on financial aid for Youth members', '2024-12-19', '2025-08-12'),
(47, 25, 2, 12.70, '12.70% discount on educational materials for Premium members', '2024-12-23', '2025-06-04'),
(48, 25, 3, 36.37, '36.37% off on financial aid for Youth members', '2025-01-04', '2025-01-29'),
(49, 26, 1, 19.29, '19.29% off on medical services for Classic members', '2024-12-10', '2025-01-22'),
(50, 26, 2, 39.05, '39.05% discount on educational materials for Premium members', '2025-01-03', '2025-01-21'),
(51, 26, 4, 14.35, '14.35% off on housing assistance for Senior members', '2024-12-18', '2025-03-03'),
(52, 27, 4, 36.32, '36.32% off on food support for Senior members', '2025-01-08', '2025-06-27'),
(53, 28, 1, 39.54, '39.54% off on medical services for Classic members', '2025-01-06', '2025-07-10'),
(54, 28, 2, 31.42, '31.42% discount on educational materials for Premium members', '2024-12-14', '2025-01-19'),
(55, 28, 4, 34.87, '34.87% off on housing assistance for Senior members', '2024-12-19', '2025-12-04'),
(56, 29, 1, 31.72, '31.72% off on medical services for Classic members', '2025-01-04', '2025-08-20'),
(57, 29, 3, 13.92, '13.92% discount on financial aid for Youth members', '2025-01-06', '2025-01-12'),
(58, 30, 1, 35.89, '35.89% off on medical services for Classic members', '2025-01-05', '2025-01-11'),
(59, 30, 3, 10.76, '10.76% discount on financial aid for Youth members', '2024-12-13', '2025-04-18');

-- --------------------------------------------------------

--
-- Table structure for table `donations`
--

CREATE TABLE `donations` (
  `donation_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `donation_date` date DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donations`
--

INSERT INTO `donations` (`donation_id`, `member_id`, `amount`, `donation_date`, `payment_method_id`) VALUES
(1, 1, 4913.26, '2024-06-12', 2),
(2, 2, 9183.83, '2024-10-22', 2),
(3, 3, 5979.25, '2024-06-23', 4),
(4, 4, 893.47, '2024-03-19', 4),
(5, 5, 6040.90, '2024-11-10', 1),
(6, 6, 3559.03, '2024-05-14', 1),
(7, 7, 5335.79, '2024-02-28', 4),
(8, 8, 5793.67, '2024-09-02', 1),
(9, 9, 8929.81, '2024-03-26', 2);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_date` date DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_date`, `description`) VALUES
(1, 'Charity Gala', '2025-03-15', 'Annual charity gala for fundraising'),
(2, 'Blood Drive', '2025-02-01', 'Community blood donation event'),
(3, 'Education Fair', '2025-04-20', 'Educational support for underprivileged children'),
(4, 'Health Awareness Day', '2025-05-10', 'Free health checkups and consultations');

-- --------------------------------------------------------

--
-- Table structure for table `favorite_partners`
--

CREATE TABLE `favorite_partners` (
  `favorite_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorite_partners`
--

INSERT INTO `favorite_partners` (`favorite_id`, `member_id`, `partner_id`) VALUES
(1, 1, 1),
(2, 5, 1),
(3, 4, 2),
(4, 6, 2),
(5, 4, 3),
(6, 4, 6),
(7, 6, 6),
(8, 1, 7),
(9, 2, 7),
(10, 6, 7),
(11, 9, 7),
(12, 5, 8),
(13, 6, 8),
(14, 3, 9),
(15, 8, 9),
(16, 2, 11),
(17, 7, 11),
(18, 2, 12),
(19, 6, 12),
(20, 7, 12),
(21, 7, 13),
(22, 1, 14),
(23, 6, 14),
(24, 9, 16),
(25, 7, 17),
(26, 4, 18),
(27, 7, 18),
(28, 8, 18),
(29, 5, 19),
(30, 1, 20),
(31, 7, 20),
(32, 8, 21),
(33, 7, 22),
(34, 4, 23),
(35, 3, 24),
(36, 4, 25),
(37, 6, 25),
(38, 4, 26),
(39, 7, 26),
(40, 1, 29);

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
  `is_blocked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `user_id`, `first_name`, `last_name`, `address`, `city`, `membership_type_id`, `registration_date`, `expiration_date`, `photo`, `id_document`, `recu_paiement`, `date_of_birth`, `is_validated`, `is_blocked`) VALUES
(1, 2, 'First2', 'Last2', 'Address 2', 'Constantine', 3, '2024-08-26', '2025-09-09', 'assets/images/Chamil.jpg', NULL, NULL, NULL, 1, 0),
(2, 3, 'First3', 'Last3', 'Address 3', 'Annaba', 4, '2024-10-14', '2025-03-10', 'assets/images/Chamil.jpg', NULL, NULL, NULL, 0, 0),
(3, 4, 'First4', 'Last4', 'Address 4', 'Blida', 1, '2024-11-19', '2025-03-17', NULL, NULL, NULL, NULL, 0, 0),
(4, 5, 'First5', 'Last5', 'Address 5', 'Algiers', 2, '2024-07-04', '2025-01-17', NULL, NULL, NULL, NULL, 0, 0),
(5, 6, 'First6', 'Last6', 'Address 6', 'Oran', 3, '2024-06-09', '2025-11-09', NULL, NULL, NULL, NULL, 0, 0),
(6, 7, 'First7', 'Last7', 'Address 7', 'Constantine', 4, '2024-08-03', '2025-09-03', NULL, NULL, NULL, NULL, 0, 0),
(7, 8, 'First8', 'Last8', 'Address 8', 'Annaba', 1, '2024-01-19', '2025-12-04', NULL, NULL, NULL, NULL, 0, 0),
(8, 9, 'First9', 'Last9', 'Address 9', 'Blida', 2, '2024-06-02', '2025-04-30', NULL, NULL, NULL, NULL, 0, 0),
(9, 10, 'First10', 'Last10', 'Address 10', 'Algiers', 3, '2024-04-19', '2025-09-19', NULL, NULL, NULL, NULL, 0, 0),
(19, 50, 'Chamel Nadir', 'Bouacha', 'cité 322 logements batiment F numéro 4 Imama , Mansourah', 'Algiers', 1, '2025-01-11', NULL, 'uploads/50_photo_Projet TDW 2024-2025 (1).pdf', 'uploads/50_id_Projet TDW 2024-2025 (1).pdf', 'uploads/50_recu_Projet TDW 2024-2025 (1).pdf', '2004-02-16', 0, 0),
(20, 51, 'abdessamad', 'Seddiki', 'hennaya tlemcen ', 'Tlemcen', 1, '2025-01-12', NULL, 'uploads/51_photo_Projet TDW 2024-2025 (1).pdf', 'uploads/51_id_Projet TDW 2024-2025 (1).pdf', 'uploads/51_recu_Projet TDW 2024-2025 (1).pdf', '2002-09-04', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `membership_types`
--

CREATE TABLE `membership_types` (
  `type_id` int(11) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `benefits_description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `membership_types`
--

INSERT INTO `membership_types` (`type_id`, `type_name`, `price`, `benefits_description`) VALUES
(1, 'Classic', 7000.00, 'Basic membership with standard benefits and discounts'),
(2, 'Premium', 10000.00, 'Enhanced benefits with higher discount rates and priority service'),
(3, 'Youth', 3000.00, 'Special membership for young people under 25 with targeted benefits'),
(4, 'Senior', 5000.00, 'Specialized benefits for seniors with additional health-related discounts');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `publication_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `title`, `content`, `publication_date`) VALUES
(1, 'New Partnership Announcement', 'We are excited to announce our partnership with several new healthcare providers.', '2025-01-01'),
(2, 'Successful Charity Gala', 'Our annual charity gala raised over 1 million dinars for local causes.', '2024-12-15'),
(3, 'Youth Program Launch', 'New program launched to support education for underprivileged youth.', '2024-12-01'),
(4, 'Holiday Giving Campaign', 'Join our end-of-year giving campaign to support local families.', '2024-11-25');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `notification_text` text NOT NULL,
  `notification_date` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `member_id`, `notification_text`, `notification_date`, `is_read`) VALUES
(1, 2, 'Your membership is due for renewal soon', '2025-01-03 00:00:00', 0),
(2, 2, 'New discount available from our partners', '2024-12-29 00:00:00', 1),
(3, 3, 'Upcoming volunteer opportunity', '2025-01-06 00:00:00', 0),
(4, 4, 'Your membership is due for renewal soon', '2024-12-24 00:00:00', 1),
(5, 5, 'New discount available from our partners', '2025-01-01 00:00:00', 0),
(6, 6, 'Upcoming volunteer opportunity', '2025-01-07 00:00:00', 0),
(7, 7, 'Your membership is due for renewal soon', '2024-12-19 00:00:00', 1),
(8, 8, 'New discount available from our partners', '2025-01-05 00:00:00', 0),
(9, 9, 'Upcoming volunteer opportunity', '2024-12-27 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `partner_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `offer` decimal(5,2) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`partner_id`, `user_id`, `name`, `category_id`, `city`, `offer`, `logo`) VALUES
(1, 11, 'Pharmacy A', 6, 'Oran', 20.00, './assets/images/logo_partner.png'),
(2, 12, 'Hotel B', 1, 'Constantine', 25.00, './assets/images/logo_partner.png'),
(3, 13, 'Clinic C', 2, 'Annaba', 20.00, './assets/images/logo_partner.png'),
(4, 14, 'School D', 3, 'Blida', 25.00, './assets/images/logo_partner.png'),
(5, 15, 'Travel Agency E', 4, 'Algiers', 20.00, './assets/images/logo_partner.png'),
(6, 16, 'Restaurant F', 5, 'Oran', 15.00, './assets/images/logo_partner.png'),
(7, 17, 'Pharmacy G', 6, 'Constantine', 10.00, './assets/images/logo_partner.png'),
(8, 18, 'Hotel H', 1, 'Annaba', 10.00, './assets/images/logo_partner.png'),
(9, 19, 'Clinic I', 2, 'Blida', 20.00, './assets/images/logo_partner.png'),
(10, 20, 'School J', 3, 'Algiers', 20.00, './assets/images/logo_partner.png'),
(11, 21, 'Travel Agency K', 4, 'Oran', 35.00, './assets/images/logo_partner.png'),
(12, 22, 'Restaurant L', 5, 'Constantine', 10.00, './assets/images/logo_partner.png'),
(13, 23, 'Pharmacy M', 6, 'Annaba', 45.00, './assets/images/logo_partner.png'),
(14, 24, 'Hotel N', 1, 'Blida', 45.00, './assets/images/logo_partner.png'),
(15, 25, 'Clinic O', 2, 'Algiers', 40.00, './assets/images/logo_partner.png'),
(16, 26, 'School P', 3, 'Oran', 50.00, './assets/images/logo_partner.png'),
(17, 27, 'Travel Agency Q', 4, 'Constantine', 35.00, './assets/images/logo_partner.png'),
(18, 28, 'Restaurant R', 5, 'Annaba', 15.00, './assets/images/logo_partner.png'),
(19, 29, 'Pharmacy S', 6, 'Blida', 25.00, './assets/images/logo_partner.png'),
(20, 30, 'Hotel T', 1, 'Algiers', 15.00, './assets/images/logo_partner.png'),
(21, 31, 'Clinic U', 2, 'Oran', 10.00, './assets/images/logo_partner.png'),
(22, 32, 'School V', 3, 'Constantine', 45.00, './assets/images/logo_partner.png'),
(23, 33, 'Travel Agency W', 4, 'Annaba', 40.00, './assets/images/logo_partner.png'),
(24, 34, 'Restaurant X', 5, 'Blida', 5.00, './assets/images/logo_partner.png'),
(25, 35, 'Pharmacy Y', 6, 'Algiers', 20.00, './assets/images/logo_partner.png'),
(26, 36, 'Hotel Z', 1, 'Oran', 15.00, './assets/images/logo_partner.png'),
(27, 37, 'Clinic [', 2, 'Constantine', 25.00, './assets/images/logo_partner.png'),
(28, 38, 'School \\', 3, 'Annaba', 15.00, './assets/images/logo_partner.png'),
(29, 39, 'Travel Agency ]', 4, 'Blida', 45.00, './assets/images/logo_partner.png'),
(30, 40, 'Restaurant ^', 5, 'Algiers', 40.00, './assets/images/logo_partner.png');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `method_id` int(11) NOT NULL,
  `method_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`method_id`, `method_name`) VALUES
(1, 'Bank Transfer'),
(2, 'Credit Card'),
(3, 'Cash'),
(4, 'PayPal');

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
(2, 'member1', '123456', 'member', NULL),
(3, 'member2', '123456', 'member', NULL),
(4, 'member3', '123456', 'member', NULL),
(5, 'member4', '123456', 'member', NULL),
(6, 'member5', '123456', 'member', NULL),
(7, 'member6', '123456', 'member', NULL),
(8, 'member7', '123456', 'member', NULL),
(9, 'member8', '123456', 'member', NULL),
(10, 'member9', '123456', 'member', NULL),
(11, 'partner1', '123456', 'partner', NULL),
(12, 'partner2', '123456', 'partner', NULL),
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
(24, 'partner14', '123456', 'partner', NULL),
(25, 'partner15', '123456', 'partner', NULL),
(26, 'partner16', '123456', 'partner', NULL),
(27, 'partner17', '123456', 'partner', NULL),
(28, 'partner18', '123456', 'partner', NULL),
(29, 'partner19', '123456', 'partner', NULL),
(30, 'partner20', '123456', 'partner', NULL),
(31, 'partner21', '123456', 'partner', NULL),
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
(51, 'abdessamad', '123456', 'member', 'ka_seddiki@esi.dz');

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `volunteer_id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`volunteer_id`, `member_id`, `event_id`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 1),
(4, 4, 1),
(5, 4, 4),
(6, 6, 4),
(7, 7, 1),
(8, 7, 2),
(9, 8, 1),
(10, 8, 4),
(11, 9, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advantages`
--
ALTER TABLE `advantages`
  ADD PRIMARY KEY (`advantage_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `membership_type_id` (`membership_type_id`);

--
-- Indexes for table `aid_requests`
--
ALTER TABLE `aid_requests`
  ADD PRIMARY KEY (`aid_request_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `aid_type_id` (`aid_type_id`);

--
-- Indexes for table `aid_types`
--
ALTER TABLE `aid_types`
  ADD PRIMARY KEY (`aid_type_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`),
  ADD KEY `partner_id` (`partner_id`),
  ADD KEY `membership_type_id` (`membership_type_id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `payment_method_id` (`payment_method_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `favorite_partners`
--
ALTER TABLE `favorite_partners`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `membership_type_id` (`membership_type_id`);

--
-- Indexes for table `membership_types`
--
ALTER TABLE `membership_types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `member_id` (`member_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`partner_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`method_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `idx_email` (`email`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`volunteer_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `event_id` (`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advantages`
--
ALTER TABLE `advantages`
  MODIFY `advantage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `aid_requests`
--
ALTER TABLE `aid_requests`
  MODIFY `aid_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `aid_types`
--
ALTER TABLE `aid_types`
  MODIFY `aid_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favorite_partners`
--
ALTER TABLE `favorite_partners`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `membership_types`
--
ALTER TABLE `membership_types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `method_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `volunteer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `advantages`
--
ALTER TABLE `advantages`
  ADD CONSTRAINT `advantages_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`partner_id`),
  ADD CONSTRAINT `advantages_ibfk_2` FOREIGN KEY (`membership_type_id`) REFERENCES `membership_types` (`type_id`);

--
-- Constraints for table `aid_requests`
--
ALTER TABLE `aid_requests`
  ADD CONSTRAINT `aid_requests_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `aid_requests_ibfk_2` FOREIGN KEY (`aid_type_id`) REFERENCES `aid_types` (`aid_type_id`);

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`partner_id`),
  ADD CONSTRAINT `discounts_ibfk_2` FOREIGN KEY (`membership_type_id`) REFERENCES `membership_types` (`type_id`);

--
-- Constraints for table `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `donations_ibfk_2` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`method_id`);

--
-- Constraints for table `favorite_partners`
--
ALTER TABLE `favorite_partners`
  ADD CONSTRAINT `favorite_partners_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `favorite_partners_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`partner_id`);

--
-- Constraints for table `members`
--
ALTER TABLE `members`
  ADD CONSTRAINT `members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `members_ibfk_2` FOREIGN KEY (`membership_type_id`) REFERENCES `membership_types` (`type_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`);

--
-- Constraints for table `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `partners_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Constraints for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `volunteers_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`),
  ADD CONSTRAINT `volunteers_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
