-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 21, 2023 at 09:22 PM
-- Server version: 5.7.41-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `riblumac_eventhub`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `adminmanageuser`
--

CREATE TABLE `adminmanageuser` (
  `id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(20, 'Outdoor', 'Embrace outdoor adventures'),
(21, 'Musical', ''),
(22, 'E-sports', '');

-- --------------------------------------------------------

--
-- Table structure for table `eventcategories`
--

CREATE TABLE `eventcategories` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_id` int(10) UNSIGNED DEFAULT NULL,
  `category_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `created_at`, `tickets_count`, `price`, `age_restricted`, `user_id`, `venue`, `approved_by`, `description`, `date`, `time`, `location`, `image`, `status`) VALUES
(1, 'Music Festival', '2023-08-21 14:49:41', 50, 2000, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-22', '22:25:00', 'Moratuwa', '44f79dca17f65b77128cd2aee3dbe4e7.jpg', 1),
(2, 'Musico', '2023-08-21 14:50:31', 300, 5000, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-24', '16:25:00', 'Colombo', 'd496519c956af769e1b3d0843d73a1f3.jpg', 1),
(3, 'Grand Fiesta ', '2023-08-21 15:27:03', 50, 5000, 1, 1, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', NULL, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', '2023-08-25', '20:59:00', 'Colombo', '44df718286e929f8b855b1a62fc10a99.jpg', 1),
(4, 'Book Festival', '2023-08-21 15:29:58', 200, 1500, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-31', '16:01:00', 'Galle', 'fdbb34eb8aeadd8b864131edc72273cc.jpg', 1),
(5, 'Star Night', '2023-08-21 15:31:42', 100, 2500, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-09-06', '17:07:00', 'Moratuwa', '1b032918d64e2799418fb742c5ecd249.webp', 1),
(6, 'Halloween', '2023-08-21 15:33:22', 100, 3000, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-31', '22:08:00', 'Colombo', '6a0f404450efc54a7c3f5b0725304c1f.jpg', 1),
(7, 'Pert Night', '2023-08-21 15:35:01', 200, 1500, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-23', '23:10:00', 'Moratuwa', 'f178c3d64eb03d67224380544e4b8230.webp', 1),
(8, 'Someting Nice', '2023-08-21 15:37:15', 500, 400, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-30', '23:12:00', 'Colombo', '20f681ccd74b0f16783afa4f9f49b4a9.jpg', 1),
(9, 'Big Booms', '2023-08-21 15:40:03', 2500, 2500, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-31', '23:14:00', 'Moratuwa', 'b288166548a989aaee9fe21460c6ff8f.jpg', 1),
(10, 'Dj Party', '2023-08-21 15:41:31', 250, 7500, 1, 3, '1A, Port City, Colombo', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-22', '09:00:00', 'Colombo', '61fac5bb3b10ca3cf045a856723286a2.jpeg', 1),
(12, 'Drop The Lime', '2023-08-21 15:42:56', 400, 2500, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-09-05', '21:16:00', 'Colombo', 'c0be1092926e85979bdfafcb625bc1fb.jpg', 1),
(13, 'Mona Lisa Blood Moon', '2023-08-21 15:44:02', 1200, 600, 1, 1, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-09-02', '17:19:00', 'Colombo', '84b485d09b87f6e2cd79a7eea7dae180.jpg', 1),
(14, 'Comicon', '2023-08-21 16:38:33', 1000, 6000, 0, 5, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-24', '12:14:00', 'Colombo', 'c40a468e113def378c98b1ebac9b826e.jpg', 1),
(15, 'Otaku Den', '2023-08-21 16:41:42', 1500, 500, 1, 5, 'Watford Gap Motorway Services Area, Southbound, Watford, South M1 NN6 7UZ', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-23', '23:16:00', 'Colombo', '1efd1faa5a9c47f293fd4d5056e9c196.jpg', 1),
(16, 'Gaming Fiesta', '2023-08-21 18:19:42', 200, 0, 1, 6, 'Saegis Campus Nugegoda', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-23', '12:55:00', 'Kandy', 'd3bf9296163499a9c8302cdbf6077ed9.jpg', 1),
(17, 'Gamers Night', '2023-08-21 18:20:25', 200, 250, 1, 6, 'Saegis Campus Nugegoda', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-22', '13:56:00', 'Colombo', '036e25504a778d465c54581c59daaeda.jpg', 1),
(18, 'Clash Of The Titan', '2023-08-21 18:29:29', 200, 0, 1, 6, 'Saegis Campus Nugegoda', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-28', '12:02:00', 'Colombo', 'dee7dddad2ff236648dd10360816917b.webp', 1),
(19, 'Clash Of The Kings', '2023-08-21 18:33:35', 500, 2500, 1, 6, 'Saegis Campus Nugegoda', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-09-01', '12:08:00', 'Colombo', 'c72e3d68533673aaca7af89ad1e7c502.jpg', 1),
(20, 'Pizza mania', '2023-08-21 18:53:31', 150, 100, 0, 3, 'Pizza Hut Rawathawaththa', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-22', '10:00:00', 'Moratuwa', '424d8eec80308ea6c4adbe345124e96c.jpg', 1),
(21, 'Mc Donals In Town', '2023-08-21 18:55:13', 100, 250, 0, 3, 'Mc Donalds Colombo', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-24', '18:00:00', 'Colombo', 'acb166ea0b32bdf40306db84407deed8.jpg', 1),
(22, 'Star Bucks Fiesta', '2023-08-21 18:56:12', 100, 500, 0, 3, 'Star Bucks Colombo', NULL, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, co', '2023-08-31', '16:00:00', 'Colombo', '78aabd67e2c68d4af97d1c47236611e3.jpeg', 1),
(23, 'horrer game', '2023-08-21 19:18:13', 1000, 1500, 1, 9, 'kcc', NULL, 'horrer best game show ', '2023-08-22', '09:50:00', 'Kandy', 'a45a0d3439325c718abbb75911087e18.jpg', 1),
(24, 'Horror Fiesta', '2023-08-21 19:35:29', 50, 1200, 1, 8, 'Saegis Campus Nugegoda', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-22', '21:08:00', 'Colombo', '347baa40eee0eddc201a7f816eb0401d.jpg', 1),
(25, 'Unholy', '2023-08-21 19:37:12', 200, 500, 1, 8, '110/20 panadura, nugegoda', NULL, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has su', '2023-08-23', '14:12:00', 'Colombo', '4135d401d113fa55ee9d80079c927794.jpg', 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userbookevent`
--

INSERT INTO `userbookevent` (`id`, `user_id`, `event_id`, `quantity`, `cost`, `purchased_at`, `bookingID`) VALUES
(1, 1, 10, 1, 7500, '0000-00-00 00:00:00', 'f8a6017fad8cb0130cb0c3d4d7fa79b9'),
(2, 8, 19, 1, 2500, '0000-00-00 00:00:00', 'de9a89fc5ca77a3cfc4eb32b04bef5c4'),
(3, 8, 18, 1, 0, '0000-00-00 00:00:00', '65a3e432b43db9d08366ae40d43e0c57'),
(4, 8, 12, 1, 2500, '0000-00-00 00:00:00', '3245d8669a9ade7787c376433b1483ca'),
(5, 8, 7, 1, 1500, '0000-00-00 00:00:00', '88e9512147418f5e4d7b769c5e845320'),
(6, 8, 4, 1, 1500, '0000-00-00 00:00:00', '3290928fe9fb5bd8ecfdfc57484c21a4');

-- --------------------------------------------------------

--
-- Table structure for table `userinterests`
--

CREATE TABLE `userinterests` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinterests`
--

INSERT INTO `userinterests` (`id`, `user_id`, `category_id`) VALUES
(4, 2, 4),
(5, 2, 5),
(6, 2, 6),
(7, 2, 8),
(8, 2, 10),
(9, 2, 13),
(18, 3, 2),
(19, 3, 4),
(20, 3, 12),
(21, 3, 14),
(22, 3, 17),
(23, 3, 18),
(24, 3, 19),
(25, 3, 20),
(28, 5, 4),
(29, 5, 9),
(30, 5, 14),
(31, 7, 12),
(32, 7, 13),
(36, 1, 3),
(37, 1, 13),
(38, 1, 18),
(39, 4, 2),
(40, 4, 8),
(41, 6, 15),
(42, 6, 20),
(43, 6, 21),
(44, 8, 2),
(45, 8, 5),
(46, 8, 8),
(47, 8, 20),
(48, 8, 22),
(49, 9, 2),
(50, 9, 3),
(51, 9, 4),
(52, 9, 5),
(53, 9, 6),
(54, 9, 7),
(55, 9, 8),
(56, 9, 9),
(57, 9, 10),
(58, 9, 11),
(59, 9, 12),
(60, 9, 13),
(61, 9, 14),
(62, 9, 15),
(63, 9, 16),
(64, 9, 19),
(65, 9, 20),
(66, 9, 21),
(67, 9, 22);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `email`, `address`, `gender`, `DOB`, `created_at`, `NIC`, `status`, `role`, `password`, `phone`, `stage`, `img`, `verificationCode`) VALUES
(1, 'Diraj', 'Gihon', 'gihondiraj2018@gmail.com', 'Kandy', 1, '2023-08-09', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$sitRs/J3gvK/tADelyPxYOlMZgq1wRC88OcqlsyjxQ/hTVSHCY0je', '0702221756', 3, '873928e61a6797dec206e084cd8f6750.jpg', 'bf3be3b707ffe98671a41ee286ef5b8d'),
(2, 'Perera', 'Udara', 'BSSE0122011301@saegis.ac.lk', 'Colombo', 1, '1999-04-19', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$bxc8SpXFxxRS8uoC6kwgsuwfsu1aFiT/GyuEUyNWaQIAedmKszo9a', '0770205388', 3, 'image1.jpg', '39fef838afcb5c704a49c2d73c865e8d'),
(3, 'Trancendi', 'Sara', 'jegapoy273@avidapro.com', 'Moratuwa', 0, '2002-07-05', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$TG5YM7UqafPmU.pEWlXGuuTbYjuKu6xlzQfSJzsz5pelCdqu4tf5y', '+94761333488', 3, 'Sara_Tancredi.webp', 'b123bb6457ee70b2079f037051c7565a'),
(4, 'EventHub', 'Admin', 'admin@eventhub.com', 'Colombo', 1, '2002-01-01', '0000-00-00 00:00:00', '', 1, 1, '$2y$10$J75CS8Mqzf9K7FyH99SKc.fBepL3f7UQeupX6/XjsakCyykdZwKdK', '07539664231', 3, '546d0a5df612443c50c8f507e104ea0b.jpg', ''),
(5, 'Tyler', 'Mike', 'wiyey59959@jontra.com', 'Colombo', 1, '2000-01-21', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$pCeJlTH.hAyhFXvf7JjELeIpZ8TrXZTWjzWYjB8gzlLlG/l6Nay1a', '07539664231', 3, 'images.jpg', '19d1e107faabd6be15a1520b029b8b83'),
(6, 'Clinton', 'Mark', 'febohek473@gienig.com', 'Colombo', 1, '2000-02-08', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$8rNvRVndtEZtoI/n6c04n.Ph4m7U4J0L4.8.GOAPQFXDMBF2HosJC', '07539664231', 3, '9b1294692b1f7b0356b6e5b97b0b6d96.png', '7eb64ab806415e660cfb5bf21c2fccc1'),
(7, 'Damsara', 'Sidath', 'sidathdamsara75@gmail.com', 'Colombo', 1, '2001-05-16', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$Qvk1Ge0cVNSgnQlHzQWTqO5THNvasviQKqTKEYJ/g5IrYAUn5fSTa', '0717325169', 3, 'IMG_20230721_164112_529.jpg', '3d4e069106947ce5997ac05ddd6b7dac'),
(8, 'Maclair', 'Jennie', 'yapas16664@bagonew.com', 'Colombo', 0, '2023-09-02', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$O3TxhbiCte40awp2X9mBGO8XD0r1yYeHDFx8kP1oELboxHRD15A7a', '0702221756', 3, '14b1a60724e9f4ecfd9b52309c3baf8c.jpg', '47e859f7f0eb7fbfb75d0962c4b75d9e'),
(9, 'ayesh', 'pasindu', 'pasindu144ayesh@gmail.com', 'Kandy', 1, '1999-07-07', '0000-00-00 00:00:00', '', 1, 0, '$2y$10$zoCLr0C4c.lleJXhLFQVRuy53uQ591d2c0VRwcdSaEVtrFIpQHsqO', '0779236679', 3, 'abce796790332f6702b64e13ed4fb35d.jpg', 'e60bcbefc8c546958729c14ec9412790'),
(10, 'Max', 'Savindu', 'www.somixaviers@gmail.com', '', 0, '0000-00-00', '0000-00-00 00:00:00', '', 0, 0, '$2y$10$xUKNcwrWQkK.7B8TIB5Wt.jugKQBoKXB5ywwCciTwYkWywnYDO/ty', '0705079185', 1, '', '');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `userbookevent`
--
ALTER TABLE `userbookevent`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `userinterests`
--
ALTER TABLE `userinterests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
