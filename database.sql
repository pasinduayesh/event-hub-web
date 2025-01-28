-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 11, 2023 at 10:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminmanageevent`
--

CREATE TABLE `adminmanageevent` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adminmanageuser`
--

CREATE TABLE `adminmanageuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(2, 'Sport', 'Witness thrilling sports events'),
(3, 'Conferences', 'Attend informative conferences'),
(4, 'Workshops', 'Participate in interactive workshops'),
(5, 'Art', 'Experience artistic exhibitions'),
(6, 'Food and Drink', 'Indulge in culinary delights'),
(7, 'Theater', 'Watch captivating theater performances'),
(8, 'Dance', 'Immerse yourself in mesmerizing dance shows'),
(9, 'Comedy', 'Laugh out loud with hilarious comedy acts'),
(10, 'Film', 'Enjoy screenings of movies and documentaries'),
(11, 'Fashion', 'Discover the latest fashion trends'),
(12, 'Health and Wellness', 'Join wellness and fitness events'),
(13, 'Technology', 'Explore innovations in technology'),
(14, 'Business', 'Network and learn from industry leaders'),
(15, 'Charity', 'Support charitable causes'),
(16, 'Family', 'Spend quality time with your loved ones'),
(17, 'Literature', 'Engage with literature and authors'),
(18, 'Science', 'Explore the wonders of science'),
(19, 'Travel', 'Discover new travel destinations'),
(20, 'Outdoor', 'Embrace outdoor adventures');

-- --------------------------------------------------------

--
-- Table structure for table `eventcategories`
--

CREATE TABLE `eventcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventcategories`
--

INSERT INTO `eventcategories` (`id`, `event_id`, `category_id`) VALUES
(36, 9, 3),
(37, 9, 4),
(38, 9, 13),
(39, 9, 15),
(40, 9, 18),
(41, 10, 3),
(42, 10, 4),
(43, 10, 13),
(44, 10, 16),
(45, 10, 18),
(46, 11, 6),
(47, 11, 7),
(48, 11, 10),
(49, 11, 15),
(50, 11, 16),
(51, 12, 6),
(52, 12, 7),
(53, 12, 10),
(54, 12, 15),
(55, 12, 16),
(56, 13, 3),
(57, 13, 6),
(58, 13, 7),
(59, 13, 9),
(60, 13, 16),
(66, 15, 5),
(67, 15, 6),
(68, 15, 8),
(69, 15, 11),
(71, 16, 2),
(72, 16, 3),
(73, 16, 4),
(74, 16, 5),
(75, 16, 6),
(76, 16, 7),
(77, 16, 8),
(78, 16, 9),
(79, 16, 10),
(80, 16, 11),
(81, 16, 12),
(82, 16, 13),
(83, 16, 14),
(84, 16, 15),
(85, 16, 16),
(86, 16, 17),
(87, 16, 18),
(88, 16, 19),
(89, 16, 20),
(96, 17, 18),
(97, 17, 19),
(119, 8, 3),
(120, 8, 12),
(121, 8, 13),
(122, 8, 16),
(123, 6, 2),
(124, 6, 4),
(125, 6, 5),
(126, 6, 6),
(127, 6, 8),
(128, 6, 9),
(129, 6, 16),
(130, 6, 19),
(131, 6, 20),
(132, 19, 12),
(133, 19, 13),
(134, 20, 2),
(135, 20, 18),
(136, 20, 20);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `tickets_count` int(11) NOT NULL,
  `price` double NOT NULL,
  `age_restricted` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `venue` varchar(255) NOT NULL,
  `approved_by` int(10) UNSIGNED DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `location` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `created_at`, `tickets_count`, `price`, `age_restricted`, `user_id`, `venue`, `approved_by`, `description`, `date`, `time`, `location`, `image`, `status`) VALUES
(6, 'Summer Fiesta', '2023-07-18 00:31:05', 500, 100, 0, 1, '77/28 tourist depo road katubedda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-03', '03:03:00', 'Colombo', 'images (2).jpeg', 1),
(8, 'Playtopia', '2023-07-18 00:34:46', 2000, 0, 0, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-05', '20:04:00', 'Moratuwa', 'images (6).jpeg', 0),
(9, 'Techno ', '2023-07-18 00:35:34', 2000, 500, 0, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-05', '00:00:00', 'Colombo', 'download (9).jpeg', 0),
(10, 'MindLabs', '2023-07-18 00:37:23', 2500, 0, 0, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-12', '00:00:00', 'Colombo', 'download (8).jpeg', 1),
(11, 'Movie Fiesta', '2023-07-18 00:38:51', 100, 200, 0, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-05', '00:00:00', 'Colombo', 'download (10).jpeg', 1),
(12, 'Mvizilla', '2023-07-18 00:39:40', 1000, 300, 0, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-09-03', '00:00:00', 'Moratuwa', 'images (7).jpeg', 0),
(13, 'Lowo', '2023-07-18 00:42:08', 5000, 1200, 0, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-07-22', '00:00:00', 'Colombo', 'images (5).jpeg', 1),
(15, 'Night Life', '2023-07-18 00:53:12', 5000, 5000, 1, 1, '110/20 panadura, nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-05', '00:00:00', 'Colombo', 'cf3c193245b057c6aa54af769f12067e.jpg', 1),
(16, 'Summer Camp', '2023-07-18 00:54:03', 1200, 5000, 1, 1, 'Saegis university nugegoda', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-07-21', '00:00:00', 'Kandy', 'images (9).jpeg', 0),
(17, 'testEVENT', '2023-08-10 10:39:41', 200, 1200, 1, 1, '110/20 panadura, nugegoda', NULL, 'dbdsbdsb', '2023-08-28', '00:00:00', 'Moratuwa', 'images (8).jpeg', 1),
(19, 'test', '2023-08-11 21:04:48', 200, 154, 1, 15, 'Colombo', NULL, 'dbdsbdsb', '2023-07-31', '14:09:00', 'Moratuwa', '6566545.jpg', 0),
(20, 'Event 1', '2023-08-11 23:59:29', 500, 1200, 1, 16, 'Colombo', NULL, 'Test ', '2023-08-01', '17:04:00', 'Kilinochchi', '000000.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userbookevent`
--

CREATE TABLE `userbookevent` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `cost` double NOT NULL,
  `purchased_at` datetime NOT NULL,
  `bookingID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userbookevent`
--

INSERT INTO `userbookevent` (`id`, `user_id`, `event_id`, `quantity`, `cost`, `purchased_at`, `bookingID`) VALUES
(3, 1, 15, 5, 25000, '0000-00-00 00:00:00', ''),
(4, 1, 15, 1000, 5000000, '0000-00-00 00:00:00', ''),
(5, 1, 6, 15, 0, '0000-00-00 00:00:00', ''),
(6, 1, 6, 10, 0, '0000-00-00 00:00:00', ''),
(7, 1, 6, 500, 0, '0000-00-00 00:00:00', ''),
(8, 1, 15, 3995, 19975000, '0000-00-00 00:00:00', ''),
(9, 14, 17, 10, 12000, '0000-00-00 00:00:00', ''),
(10, 14, 17, 20, 24000, '0000-00-00 00:00:00', ''),
(11, 1, 17, 30, 36000, '0000-00-00 00:00:00', ''),
(15, 14, 13, 12, 14400, '0000-00-00 00:00:00', '08b765bd7f9f26632e4f2c87ce54b546'),
(16, 16, 17, 2, 2400, '0000-00-00 00:00:00', 'e7389b629af3148d90f55fd8a4b0fdd6'),
(17, 17, 17, 5, 6000, '0000-00-00 00:00:00', 'cff97cac8fc53a62793bb7c67e30c72c');

-- --------------------------------------------------------

--
-- Table structure for table `userinterests`
--

CREATE TABLE `userinterests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userinterests`
--

INSERT INTO `userinterests` (`id`, `user_id`, `category_id`) VALUES
(9, 2, 7),
(10, 2, 12),
(11, 2, 13),
(12, 2, 20),
(15, 3, 7),
(16, 3, 8),
(17, 3, 9),
(18, 3, 11),
(19, 3, 12),
(20, 3, 14),
(21, 3, 20),
(22, 4, 3),
(23, 4, 8),
(24, 4, 9),
(28, 5, 5),
(29, 5, 7),
(30, 5, 10),
(31, 5, 13),
(33, 1, 6),
(34, 1, 8),
(41, 8, 2),
(42, 8, 14),
(43, 8, 19),
(44, 8, 20),
(50, 11, 9),
(51, 11, 10),
(52, 11, 13),
(53, 11, 18),
(54, 11, 20),
(55, 14, 2),
(56, 14, 19),
(57, 15, 2),
(58, 15, 19),
(59, 15, 20),
(63, 16, 2),
(64, 16, 12),
(65, 16, 19),
(66, 16, 20),
(67, 17, 2),
(68, 17, 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` int(11) NOT NULL,
  `DOB` date NOT NULL,
  `created_at` datetime NOT NULL,
  `NIC` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `stage` int(11) NOT NULL,
  `img` text NOT NULL,
  `verificationCode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `email`, `address`, `gender`, `DOB`, `created_at`, `NIC`, `status`, `role`, `password`, `phone`, `stage`, `img`, `verificationCode`) VALUES
(1, 'Diraj', 'Gihon', 'gihondiraj2018@gmail.com', 'Moratuwa', 1, '2002-07-01', '0000-00-00 00:00:00', '', 1, 1, '$2y$10$uYmcBaZckiiiK4JP3PHfn.Afr2WYfCxqoaB1AFsy1I2H0FxnsqQee', '0702221756', 3, '', ''),
(2, 'Doe', 'John', 'Johndoe@gmail.com', 'Colombo', 1, '1977-07-27', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$MwffII1PiMK.riK/PURsfud016cUlQP5DR8lpmkKPU5W1WDl.wJea', '0702226578', 3, '', ''),
(3, 'Eranga', 'Udara', 'Udaraeranga302@gmail.com', 'Colombo', 1, '0000-00-00', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$Am5qKKpVP04Hhg63ZleWZOvN25eymBcu/BZ0zaYFnwVHlndmfnb7a', '0719700145', 3, '', ''),
(4, 'doe', 'john', 'johndoe2@gmail.com', 'Moratuwa', 1, '2003-01-18', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$U9pL864ouTY8UTGHH8007eWEJzJuvSMu0kuCIRxS242Z88fHpt5Ka', '0702221756', 3, '', ''),
(5, 'Ayesh', 'Pasindu', 'BSSE0122011318@saegis.ac.lk', 'Moratuwa', 1, '1999-07-18', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$.q0z5eYqHj1wdqLlzCJBguHW.RpAw34sXZV3aYFE4MYXahAqTuDkG', '0779236679', 3, '', ''),
(8, '12', 'Test ', 'test@123321.com', 'Kandy', 1, '2023-08-29', '0000-00-00 00:00:00', '', 0, 0, '$2y$10$Xgi3.TF576cMy8CRtwcSNOSiDmFjEaxoz.yp/K4aLDDdJmhKZtEme', '07539664231', 3, '', ''),
(11, 'thakshana', 'mishen', 'mishenthakshana@gmail.com', 'Colombo', 1, '2023-08-30', '0000-00-00 00:00:00', '', 0, 0, '$2y$10$cu4TJEoIP7l0NflyNgL/wOykoARIuNksvkKatOEfJRLE5fr8Y0ru6', '07539664231', 3, '', ''),
(14, 'perera', 'samira', 'xadel98005@vreaa.com', 'Colombo', 1, '2023-08-31', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$Qsa3oBVTEVEHJFHRrYvADOPxSnBCC0eK3iaeduuuW4OXSHTS3yQdm', '07539664231', 3, '', 'edad27d972678741684f1aff6686b9d3'),
(15, 'Kelub', 'John', 'lodevi6168@royalka.com', 'Moratuwa', 1, '2023-07-19', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$g2fCSefyPVf5CCtBeKPOeO4tkTmt0tcWG3.piE4fmagwhFr2gCTfy', '07539664231', 3, '000000.jpg', '46dcbd082be32192dceb6e05d3b401d7'),
(16, 'Perera', 'Josh', 'roxiba8878@v1zw.com', 'Matara', 1, '2000-01-11', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$8QXEElDZ9HUb.hAFnukZd.lwE3qOk3x2.AoEyyKWfGmOTEcWvY1Iu', '0702221756', 3, '000000.jpg', '6eb08d366564d481409895199a855751'),
(17, 'Prasanga', 'Diraj', 'gageye3320@vreaa.com', 'Colombo', 1, '2000-08-01', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$H6hydSIWqH4Im6DT.gfSzuiUJpUnVBU1q.sgdLCdF1gu7VNKf2pY6', '0702221756', 3, 'imagesdddd.jpeg', '173e85ebb72179550030bf1775a2aca7');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminmanageevent`
--
ALTER TABLE `adminmanageevent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `adminmanageuser`
--
ALTER TABLE `adminmanageuser`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eventcategories`
--
ALTER TABLE `eventcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `userbookevent`
--
ALTER TABLE `userbookevent`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `userinterests`
--
ALTER TABLE `userinterests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminmanageevent`
--
ALTER TABLE `adminmanageevent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adminmanageuser`
--
ALTER TABLE `adminmanageuser`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `eventcategories`
--
ALTER TABLE `eventcategories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `userbookevent`
--
ALTER TABLE `userbookevent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `userinterests`
--
ALTER TABLE `userinterests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adminmanageevent`
--
ALTER TABLE `adminmanageevent`
  ADD CONSTRAINT `adminmanageevent_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adminmanageevent_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `adminmanageuser`
--
ALTER TABLE `adminmanageuser`
  ADD CONSTRAINT `adminmanageuser_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `adminmanageuser_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `eventcategories`
--
ALTER TABLE `eventcategories`
  ADD CONSTRAINT `eventcategories_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `eventcategories_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `userbookevent`
--
ALTER TABLE `userbookevent`
  ADD CONSTRAINT `userbookevent_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `userbookevent_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `userinterests`
--
ALTER TABLE `userinterests`
  ADD CONSTRAINT `userinterests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `userinterests_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
