-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 10, 2020 at 08:50 AM
-- Server version: 5.7.32
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ixd1734_catabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `posted_at` datetime NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `posted_at`, `body`) VALUES
(15, 26, 60, '2020-12-08 20:41:13', 'This is original'),
(16, 26, 60, '2020-12-08 20:43:38', 'ASD'),
(17, 26, 60, '2020-12-08 20:45:34', 'qwer'),
(19, 26, 61, '2020-12-09 10:10:47', 'It really is.'),
(20, 26, 61, '2020-12-09 10:13:50', 'Seriously.'),
(21, 4, 61, '2020-12-09 11:05:31', 'Why so serious?'),
(22, 51, 63, '2020-12-09 11:35:07', 'wintery indeed'),
(23, 51, 61, '2020-12-09 11:37:12', 'Curious to know some more details....'),
(24, 26, 63, '2020-12-09 11:38:06', 'That\'s a lot of snow'),
(25, 26, 48, '2020-12-09 11:45:27', 'Boxes are the best'),
(26, 26, 63, '2020-12-09 12:35:42', 'Decembery'),
(27, 26, 55, '2020-12-09 21:48:01', 'it\'s sidewalk time');

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `user_one_id` int(11) NOT NULL,
  `user_two_id` int(11) NOT NULL,
  `requested_at` datetime NOT NULL,
  `approved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`user_one_id`, `user_two_id`, `requested_at`, `approved_at`) VALUES
(4, 5, '2019-11-27 08:57:29', '2019-12-04 08:37:47'),
(4, 6, '2019-11-27 08:27:10', '2020-11-26 13:49:56'),
(4, 11, '2019-12-04 08:36:51', NULL),
(4, 12, '2019-12-05 13:19:58', NULL),
(6, 32, '2020-11-27 08:35:49', '2020-11-27 08:38:39'),
(25, 4, '2019-12-05 02:59:32', '2019-12-05 03:00:04'),
(25, 5, '2019-12-05 03:17:43', '2020-12-08 16:44:41'),
(26, 4, '2020-11-26 00:06:39', '2020-12-09 11:05:21'),
(26, 5, '2020-12-08 16:43:29', '2020-12-08 16:44:33'),
(26, 6, '2020-11-26 12:49:23', '2020-11-26 13:49:32'),
(26, 11, '2020-12-08 19:09:44', NULL),
(26, 12, '2020-12-08 19:09:55', NULL),
(26, 35, '2020-11-27 12:38:47', '2020-11-27 12:42:37'),
(26, 36, '2020-12-08 16:43:23', NULL),
(26, 40, '2020-12-03 13:51:10', '2020-12-03 16:51:36'),
(32, 5, '2020-11-27 08:58:58', NULL),
(33, 6, '2020-11-26 14:25:10', '2020-11-26 14:27:09'),
(33, 36, '2020-12-03 12:38:01', NULL),
(35, 21, '2020-11-27 12:51:14', NULL),
(35, 32, '2020-11-27 13:29:22', NULL),
(40, 4, '2020-12-03 16:50:56', NULL),
(42, 6, '2020-12-03 15:51:20', NULL),
(51, 26, '2020-12-09 11:36:02', '2020-12-09 11:38:20'),
(56, 26, '2020-12-09 21:57:14', '2020-12-10 09:29:28'),
(56, 32, '2020-12-09 22:46:04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`user_id`, `post_id`) VALUES
(4, 35),
(5, 32),
(4, 34),
(4, 32),
(25, 33),
(25, 34),
(25, 35),
(25, 36),
(4, 36),
(4, 33),
(25, 37),
(26, 37),
(26, 40),
(26, 42),
(26, 33),
(6, 45),
(6, 47),
(6, 46),
(6, 34),
(26, 48),
(26, 45),
(6, 50),
(32, 53),
(32, 51),
(32, 52),
(32, 50),
(32, 43),
(34, 40),
(35, 34),
(33, 58),
(6, 58),
(26, 59),
(42, 59),
(26, 60),
(51, 63),
(51, 61),
(26, 63),
(26, 49),
(26, 47),
(26, 58),
(26, 56),
(56, 49),
(55, 68),
(55, 67),
(55, 59),
(55, 64),
(26, 64);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `body` text,
  `image` varchar(255) DEFAULT NULL,
  `sent_at` datetime NOT NULL,
  `recieved_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `from_id`, `to_id`, `body`, `image`, `sent_at`, `recieved_at`) VALUES
(1, 26, 6, 'asdffdsa', '', '2020-12-03 09:56:02', '2020-12-04 12:46:36'),
(2, 6, 26, 'asdfffdsaasdfdfasdfasdasdf', '', '2020-12-03 10:02:00', '2020-12-10 12:47:58'),
(3, 6, 26, 'ffdsaaas 234', '', '2020-12-03 10:04:57', '2020-12-10 12:47:58'),
(4, 26, 6, 'blue', '/catabase/assets/images/messages/5fc8b8fb7b470_blue.jpg', '2020-12-03 10:07:55', '2020-12-04 12:46:36'),
(5, 6, 4, 'Hey Brioche, it\'s been a while', '', '2020-12-03 10:47:38', '2020-12-09 11:03:55'),
(6, 33, 6, 'jack, it\'s been far too long. How are you?', '', '2020-12-03 12:19:32', '2020-12-04 12:46:36'),
(7, 33, 6, 'Where are you?', '', '2020-12-03 12:20:00', '2020-12-04 12:46:36'),
(8, 6, 33, 'THanks for getting in touch Felix. I\'m doing OK. ', '', '2020-12-03 12:22:41', '2020-12-03 12:40:56'),
(9, 33, 6, 'Also, did you hear about the snow that\'s coming?', '', '2020-12-03 12:23:52', '2020-12-04 12:46:36'),
(10, 6, 33, 'Sounds like a big storm is on the way', '', '2020-12-03 12:26:06', '2020-12-03 12:40:56'),
(11, 26, 35, 'How is your day going?', '', '2020-12-03 14:07:00', NULL),
(12, 26, 6, 'It\'s a slow afternoon but maybe with a cup of tea it will pan out nicely. ', '', '2020-12-03 14:08:10', '2020-12-04 12:46:36'),
(13, 6, 32, 'Will you join us for Tea later?', '', '2020-12-03 14:10:42', NULL),
(14, 6, 32, 'Tea time is happening one hour ish from now', '', '2020-12-03 14:11:22', NULL),
(15, 6, 26, 'Testing the Message Nav Bar', '', '2020-12-03 14:42:45', '2020-12-10 12:47:58'),
(16, 26, 6, 'It\'s Friday. Fridaaaaaaay', '', '2020-12-04 08:14:16', '2020-12-04 12:46:36'),
(17, 6, 4, 'Hi Brioche. You are on top of things today.', '', '2020-12-04 08:57:18', '2020-12-09 11:03:55'),
(18, 6, 26, 'Foggggggy', '', '2020-12-04 08:58:23', '2020-12-10 12:47:58'),
(19, 26, 6, 'It\'s been snowing.', '', '2020-12-04 12:23:38', '2020-12-04 12:46:36'),
(20, 6, 26, 'Hamilton, though.', '/catabase/assets/images/messages/5fca2acbc5d2f_hamilton-hero.jpg', '2020-12-04 12:25:47', '2020-12-10 12:47:58'),
(21, 6, 4, 'Tea time is at 3pm. Are you coming?', '', '2020-12-04 12:50:30', '2020-12-09 11:03:55'),
(22, 26, 6, 'asdff', '', '2020-12-08 19:19:02', NULL),
(23, 26, 5, 'asdfffdsa', '', '2020-12-08 19:26:18', NULL),
(24, 4, 25, 'Wintery today', '/catabase/assets/images/messages/5fd0af303e4dc_pxl_20201209_123419168.jpg', '2020-12-09 11:04:16', NULL),
(25, 26, 51, 'Welcome to catabase!', '', '2020-12-09 11:41:14', '2020-12-09 11:42:13'),
(26, 51, 26, 'THanks for welcoming me so warmly.', '', '2020-12-09 11:42:52', '2020-12-10 12:47:58'),
(27, 26, 4, 'Hello again', '', '2020-12-09 12:44:56', NULL),
(28, 26, 5, 'How are you today?', '', '2020-12-10 12:56:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `body`, `image`, `date_added`) VALUES
(31, 4, 'Sonic Art', '/catabase/assets/images/meows/5ddd896a7a999_05fmc_sonicartseries.jpg', '2019-11-26 15:22:02'),
(32, 4, 'exhibition', '/catabase/assets/images/meows/5ddd9a39a82bf_238a5c7b1a0bcbdd62516937500ef0fe.jpg', '2019-11-26 16:33:45'),
(33, 4, 'No image', '', '2019-11-26 16:38:29'),
(34, 6, 'Mac Pro', '/catabase/assets/images/meows/5dde8a84c5193_0macpro.jpg', '2019-11-27 09:39:00'),
(35, 25, 'Black and white image', '/catabase/assets/images/meows/5dde966c7b2c5_cat.jpeg', '2019-11-27 10:29:48'),
(36, 25, 'Here is an Oak tree', '/catabase/assets/images/meows/5ddf84a5a3ec7_1024px-keeler_oak_tree_-_distance_photo,_may_2013.jpg', '2019-11-28 03:26:13'),
(37, 4, 'Pisa', '/catabase/assets/images/meows/5de94c8874bec_giphy.gif', '2019-12-05 13:29:28'),
(39, 26, 'asdfffdsa', '/catabase/assets/images/meows/5fbeab41951c0_5de94d57d2dd1_sloth.jpg', '2020-11-25 14:06:41'),
(40, 26, 'Hamilton', '/catabase/assets/images/meows/5fbeab5e23617_hamilton-hero.jpg', '2020-11-25 14:07:10'),
(41, 26, 'asdfff', '/catabase/assets/images/meows/5fbef83a03b35_blue.jpg', '2020-11-26 00:35:06'),
(42, 26, 'Van', '/catabase/assets/images/meows/5fbfa52181d1f_adams_autolamp-close-1.jpeg', '2020-11-26 12:52:49'),
(43, 26, 'Van', '/catabase/assets/images/meows/5fbfafc396cbb_adams_autolamp-close-1.jpeg', '2020-11-26 13:38:11'),
(44, 26, 'Van', '/catabase/assets/images/meows/5fbfb01eca736_adams_autolamp-close-1.jpeg', '2020-11-26 13:39:42'),
(45, 33, 'Everything is just fine', '/catabase/assets/images/meows/5fbfb9fe8c4ae_fine.jpg', '2020-11-26 14:21:50'),
(46, 6, 'Adding a new post ', '', '2020-11-26 14:42:25'),
(47, 6, 'Adding another post', '', '2020-11-26 14:42:52'),
(48, 6, 'Cats and boxes are good friends', '/catabase/assets/images/meows/5fbfc42dc5243_publicbannerc.jpg', '2020-11-26 15:05:17'),
(49, 6, 'Tito and Cassy', '/catabase/assets/images/meows/5fbfc4c4e4c9f_screenshot 2020-11-03 092150.png', '2020-11-26 15:07:48'),
(50, 26, 'Fancy Feast is bad for the gut.', '', '2020-11-27 07:33:35'),
(51, 26, 'Cassy is my mom!', '', '2020-11-27 07:34:28'),
(52, 26, 'kitchen shenanigans', '/catabase/assets/images/meows/5fc0aceaa4945_userbannera.jpg', '2020-11-27 07:38:18'),
(53, 26, 'Not every couch is so comfortable. But this one is gold.', '/catabase/assets/images/meows/5fc0b92fb1cfc_pexels-ksenia-chernaya-3965513.jpg', '2020-11-27 08:30:39'),
(54, 26, 'Coding is more fun when we collaborate.', '/catabase/assets/images/meows/5fc0f304e12dd_joincode.jpg', '2020-11-27 12:37:24'),
(55, 35, 'Just Strollin\'', '/catabase/assets/images/meows/5fc0f41185f87_publicbannerb.jpg', '2020-11-27 12:41:53'),
(56, 36, '#goals', '', '2020-11-27 12:46:12'),
(57, 35, 'THis is a post without an image', '', '2020-11-27 12:50:00'),
(58, 39, 'hi\r\n', '', '2020-11-30 22:15:55'),
(59, 40, 'It the meow that drives your soul that matters.', '', '2020-12-03 12:45:51'),
(60, 39, 'Posting\r\n', '', '2020-12-03 17:01:44'),
(61, 26, 'Woah That\'s serious.', '', '2020-12-08 19:25:43'),
(63, 51, 'It\'s quite wintery outside.', '/catabase/assets/images/meows/5fd0b652788b6_pxl_20201209_123419168.jpg', '2020-12-09 11:34:42'),
(64, 26, 'This is new', '', '2020-12-09 12:22:51'),
(65, 56, '4564', '', '2020-12-09 22:46:14'),
(66, 56, 'can i ssss\r\n', '', '2020-12-09 22:46:44'),
(67, 55, 'hey', '', '2020-12-10 00:08:41'),
(68, 55, 'hey', '', '2020-12-10 00:08:54'),
(69, 55, 'hey', '', '2020-12-10 03:00:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `quote` varchar(255) NOT NULL,
  `signup_date` date NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullName`, `email`, `password`, `quote`, `signup_date`, `avatar`) VALUES
(4, 'Brioche', 'brioche@brioche.com', '$2y$10$q7tVrEB1Bpi6eQdki/2WmuP8tv8TgS1iNBlZGuzreOCgi95xEKLey', 'Rawrrr!', '2019-10-15', 'assets/avatars/5.png'),
(5, 'Mulberry', 'mulberry@mulberry.com', '$2y$10$q7tVrEB1Bpi6eQdki/2WmuP8tv8TgS1iNBlZGuzreOCgi95xEKLey', 'Prrrrrr purrrrr', '2019-10-29', 'assets/avatars/15.png'),
(6, 'Jack', 'jack@jack.com', '$2y$10$q7tVrEB1Bpi6eQdki/2WmuP8tv8TgS1iNBlZGuzreOCgi95xEKLey', 'Nom Nom Nom Nom', '2019-10-29', 'assets/avatars/3.png'),
(11, 'Gwendolyn', 'gwen@gmail.com', '$2y$10$zJbZVDiAMFbH83flqLYlAu/5QjNAspnzEGcRAiB.v/L3.V0N4wUrq', 'Mreoee?', '2019-10-29', 'assets/avatars/11.png'),
(12, 'Shamu', 'shamu@gmail.com', '$2y$10$JmjYUDNNFDjsW3kROYKkk.oqRXLFgI1SuCSGG7P2VcXBMkiGa2ySS', 'Meow Meow.', '2019-10-29', 'assets/avatars/15.png'),
(14, 'Ruby', 'ruby@gmail.com', '$2y$10$SLkA9PBW4IdbF53UzeStP.k3/k2A4U7oYOWjDUwhPjdLWYy7M3C8u', 'Meow', '2019-10-30', 'assets/avatars/13.png'),
(18, 'Tigger', 'tigger@gmail.com', '$2y$10$g5nW1h8pf30GIlBSvLqHAu8BdXmkqhyufCPIoFfR1BQnZWx0tPouy', 'Roar!', '2019-10-30', 'assets/avatars/13.png'),
(19, 'Papouska', 'papouska@gmail.com', '$2y$10$hV.FfdHF0uiX2AwqeOvVpOk7Ln5zVyPvjY.lV98xBrE14L6AwI3Oy', 'Meowwwwwwwww', '2019-10-30', 'assets/avatars/1.png'),
(20, 'Papouska', 'papouska1@gmail.com', '$2y$10$lWKCn2uo0sXX7Gbmo17T8e2WaqoBt/BdJTyXry9Aac1vK/XWX3AF6', 'asdf', '2019-10-30', 'assets/avatars/7.png'),
(21, 'Mito', 'mito@gmail.com', '$2y$10$pf4SFVizKWvVZ1xzWwG48...X39CoRAZ7PB5h96c/2u.NYTa1NHue', 'Life is Purrrrfect', '2019-10-31', 'assets/avatars/4.png'),
(22, 'Ember', 'ember@gmail.com', '$2y$10$JmoSuaRGTB6X6jFoa4wtw.uHbrie7X54yTViaJNCjYA28ya4RMYXK', 'Sneaky times!', '2019-11-01', 'assets/avatars/11.png'),
(23, 'Aname', 'aname@hotmail.com', '$2y$10$VS49xsk0/b0eBQqPdv81VeGjkJyoZsY3YVU3OiD5EdqnbBPyDq4eG', 'food', '2019-11-15', 'assets/avatars/5.png'),
(25, 'November', 'november@november.ca', '$2y$10$9cjv4H9RDsspAGycOK8BjuJnoSvTgqwuoTe9tGe35WGREhjrrul6.', 'November', '2019-11-27', 'assets/avatars/3.png'),
(26, 'Tito', 'tito@tito.com', '$2y$10$q7tVrEB1Bpi6eQdki/2WmuP8tv8TgS1iNBlZGuzreOCgi95xEKLey', 'Feathers on a stick!!!', '2020-11-25', 'assets/avatars/8.png'),
(32, 'Cassy', 'cassy@cassy.com', '$2y$10$/3G7p6oxsdo9oPXe/0yRPeIFJzQqV77Qv1rD.QjRmyvOFBVReqQjC', 'Feathers', '2020-11-26', 'assets/avatars/14.png'),
(33, 'Felix', 'felix@felix.com', '$2y$10$lYcenXBRoGGektSj5ZTpxeMHaf7LSyOb6cMqmbjGH5CMQ/YKUpNum', 'MEOW zen !', '2020-11-26', 'assets/avatars/8.png'),
(34, 'cat', 'adoptadog@gmail.com', '$2y$10$DQ3K2b5JHblohMa0jm75zuQ0pjk0kmiL7wdTojexH/pFyigE4nzWm', 'mew', '2020-11-27', 'assets/avatars/15.png'),
(35, 'Kiwi', 'kiwi@kiwi.com', '$2y$10$q7tVrEB1Bpi6eQdki/2WmuP8tv8TgS1iNBlZGuzreOCgi95xEKLey', 'I love food', '2020-11-27', 'assets/avatars/6.png'),
(36, 'Doom, Ender of Light', 'MeowMeowMeow@cutekitty.uwu', '$2y$10$cbJuMRQCHvquzG50LiJBO.fGFZnL2ArpSYlo.K4NMSlO41DRFKXGa', 'Entropy is the natural state of existence. All will fall, and at the end of days I will remain to eat your snacks and sit on the forbidden couch.', '2020-11-27', 'assets/avatars/13.png'),
(37, 'Mitch', 'Mitch.r.mckain@gmail.com', '$2y$10$uE8GEnoKmj6kYhbDHHGH.ORzztzNk8Gq5nDFurl3UEyIjuHr5rIxW', '!', '2020-11-29', 'assets/avatars/15.png'),
(38, 'Greg', 'gergox96@yahoo.ca', '$2y$10$4hQtu46slGM5mm5goCLx9uC9nGboSis4Zg.al61de1N.jxNXNZzPS', 'meow', '2020-11-30', 'assets/avatars/10.png'),
(39, 'Marlee Finch', 'mar@mail.com', '$2y$10$OvMczel3EhTkxxyoAITM/OIqzDdLgk8HO2U0YSdVC5kh6T4R09Ysu', 'hello', '2020-11-30', 'assets/avatars/2.png'),
(40, 'Mr. Snugglebutts', 'sirsnuggles@gmail.com', '$2y$10$IohK8yroNXrw7wY1/iFASe1QekAty4FTQS6JKeKr32Dt3Lce3QcTu', 'meow? meow.', '2020-12-03', 'assets/avatars/15.png'),
(41, 'Tee', 'tee@344.com', '$2y$10$PvlGR7XFSY5GFDabGsYqa.zLC93TvKbX7BvkQulkFnYS3rH4.xksC', 'Baka Mitai', '2020-12-03', 'assets/avatars/7.png'),
(42, 'Mee', 'mee@123.com', '$2y$10$PjoBKNhALmCExA76xoFPqOoLiQ/XPCDR7DTyY7U1J09oDbhO0P9ga', 'Dame dane', '2020-12-03', 'assets/avatars/4.png'),
(43, 'Menghan Xu', 'xumengh@sheridancollege.ca', '$2y$10$ZAPOhKIEjhW2c7ARc2btM.MJuQ/b9uEGGNJ5lYNGvN9aHcaVawwL.', '', '2020-12-04', 'assets/avatars/4.png'),
(44, 'test person', 'test@test.com', '$2y$10$lfhhe6e7hIQ4mK2uiIN7duTJNqEpXQxsaPC3UlXBOV1xnfCn4N7ZC', 'im tired', '2020-12-04', 'assets/avatars/4.png'),
(45, 'yeet', 'yeet@yeet.com', '$2y$10$BDaSSZYMtsjHHBPTixwf3OH5L8DtV.XwGX17Xq8SrdFLVCFTbwH62', 'yeet', '2020-12-04', 'assets/avatars/10.png'),
(46, 'qwer', '123@345.com', '$2y$10$X9.ijevGFIXcUnLS8Lgiu.e9tVZ/TxZjEe9BroxGBMyjUPS4t28Ny', '1234', '2020-12-06', 'assets/avatars/6.png'),
(47, 'qwer', '123@456.com', '$2y$10$SRq90xQk8237iKINazcf6OP5IcUWFWVwjdZIWBmZ5bQTXFoI09jB.', 'qwer', '2020-12-06', 'assets/avatars/12.png'),
(48, 'qwer', 'qwer@qwer.com', '$2y$10$QGBFv6KdKZeD85quIsOaJu.TM0sttTbwNqjpgJTg1EeRZuF8P5n7C', 'qwer', '2020-12-06', 'assets/avatars/1.png'),
(50, 'An', '4321@4321.com', '$2y$10$6r5ezwhHbH/drSXqKv2RcOmt07rrx3qcH2OdD/Q0fsUq3XYQ7pDFO', '1234', '2020-12-09', 'assets/avatars/3.png'),
(51, 'Sabbath', 'sabbath@sabbath.com', '$2y$10$N0wqyCdnKus2YA2PaflXReRtd3mHaOhWQtry1YQ4sNxoSFqb.S4Bq', 'Happy to be alive!!!', '2020-12-09', 'assets/avatars/11.png'),
(52, 'hello', 'hello@gmail.com', '$2y$10$3WP3UmCQcQSPSu8HaU.1R..tvkVLeghiupUQfNt9YthsjT8Ga2tDi', 'hello', '2020-12-09', 'assets/avatars/8.png'),
(53, 'sad', 'sad@sad.com', '$2y$10$RanV9sBOPNDLlTVA/e3RXuUBgfdJeIJkXRr9I.EyQI2eszJM7ttny', 'im depressed', '2020-12-09', 'assets/avatars/16.png'),
(54, 'deanna', 'test@testt.com', '$2y$10$59wgzNDVarfdgRofRinOJO2txov8iGWmE57BlDIjHn3WYxb0eFu3K', 'im tired', '2020-12-09', 'assets/avatars/4.png'),
(55, 'kalakriti padmashali', 'padmasha@sheridancollege.ca', '$2y$10$lQkE9hHP14HwP8aRgk71R.GUm/2w1.duiRJlktQaORMObUVJ3W3Ei', 'ff', '2020-12-09', 'assets/avatars/2.png'),
(56, '123', '123@qq.com', '$2y$10$8UsP5NkxC//MeZzMB/j6JeecgdlelKN4qhHTXrOSI81vAF78/dum2', '123', '2020-12-09', 'assets/avatars/14.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_is_liked` (`post_id`),
  ADD KEY `user_clicks_like` (`user_id`);

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD UNIQUE KEY `user_one_id` (`user_one_id`,`user_two_id`),
  ADD KEY `user_approves_friendship` (`user_two_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD KEY `post_is_liked` (`post_id`),
  ADD KEY `user_clicks_like` (`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_sends_message` (`from_id`),
  ADD KEY `user_recieves_message` (`to_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_authors_post` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_responds_to_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_posts_comment` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `friendships`
--
ALTER TABLE `friendships`
  ADD CONSTRAINT `user_approves_friendship` FOREIGN KEY (`user_two_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_requests_friendship` FOREIGN KEY (`user_one_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `post_is_liked` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_clicks_like` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `user_recieves_message` FOREIGN KEY (`to_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_sends_message` FOREIGN KEY (`from_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_authors_post` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
