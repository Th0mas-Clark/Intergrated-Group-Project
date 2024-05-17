-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 17, 2024 at 01:26 PM
-- Server version: 8.0.37
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tc782_user_login`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `message`, `timestamp`) VALUES
(59, 23, 'I really like football innit', '2024-05-17 11:58:09'),
(60, 22, 'Up the Blues !', '2024-05-17 11:58:24'),
(61, 23, '(football related comment)', '2024-05-17 11:58:32'),
(62, 22, 'It\\\'s DECENT , TELL HIM JACK', '2024-05-17 11:58:42'),
(63, 25, 'what did you think of the \\\'big fixture\\\' lads?', '2024-05-17 11:59:44'),
(64, 25, '\\\"city is washed\\\"', '2024-05-17 12:00:14'),
(65, 25, ' Wuhan Three Towns are winning 0-1 crazy', '2024-05-17 12:00:46'),
(66, 22, 'Thing about arsenal is they always try and walk it in', '2024-05-17 12:00:59'),
(67, 25, 'What was Wenger thinking, sending Walcott on that early?', '2024-05-17 12:01:34'),
(68, 27, 'What do we think of tottenham ?!?!?', '2024-05-17 12:02:31'),
(69, 25, ';)', '2024-05-17 12:03:11'),
(70, 28, 'Hi all', '2024-05-17 12:38:47'),
(71, 28, 'hi', '2024-05-17 12:44:40'),
(72, 28, 'hi', '2024-05-17 12:45:18'),
(73, 28, 'hi', '2024-05-17 12:49:46'),
(74, 28, 'hi', '2024-05-17 12:50:55'),
(75, 28, 'hey', '2024-05-17 12:51:06'),
(76, 28, 'hy', '2024-05-17 12:51:55'),
(77, 29, 'hey ', '2024-05-17 12:53:31'),
(78, 28, 'hi', '2024-05-17 12:53:46'),
(79, 28, 'hi', '2024-05-17 12:57:32'),
(80, 30, 'yo guys whats up ', '2024-05-17 12:58:00'),
(81, 31, 'yo whats up !!!', '2024-05-17 13:02:41'),
(82, 31, 'not much man ', '2024-05-17 13:02:47'),
(83, 25, 'i am me', '2024-05-17 13:03:57'),
(84, 34, 'Have you seen the game last night?', '2024-05-17 13:06:36'),
(85, 32, 'I can see you', '2024-05-17 13:06:42'),
(86, 36, 'yo whats up ', '2024-05-17 13:09:44'),
(87, 32, 'I am IRON MAN', '2024-05-17 13:09:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id` int NOT NULL COMMENT 'Unique identifier for each account',
  `name` varchar(64) NOT NULL COMMENT 'name of author ',
  `username` varchar(16) NOT NULL COMMENT 'username for account',
  `password_hash` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'hashed password saved for security reasons ',
  `date_account_made` datetime NOT NULL COMMENT 'time account was created'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `name`, `username`, `password_hash`, `date_account_made`) VALUES
(22, 'Malitha', 'Malitha22', '$2y$10$AICgDE6mHbKvEOzv8yB9lOa6qVsJUXng3eJXr7Y806oywIG/2cfa2', '2024-05-17 11:57:55'),
(23, 'Callum', 'the_Blues', '$2y$10$jHXDSX2U.WPBGrMSY26tI.kZOxheoUVkKcCWM5lqyt50S.QpRztgO', '2024-05-17 11:57:56'),
(25, 'Harvey', 'Graham Fish', '$2y$10$LdIRhgc6VC45p8FBDtBQAesyZzDhq/YPqyRC9pJtJFxpH/IhqoiWS', '2024-05-17 11:59:10'),
(26, 'Dorian', 'D0reL1404', '$2y$10$iNgrb1LvKXx/OijfLjelQOLFY/fNLDAoHBNJeS/AMqZIAsRwEKN3u', '2024-05-17 11:59:38'),
(27, 'Ronnyy', 'Ronny Pickering', '$2y$10$ZwDjmoQpE2HsLYhOwYkSze5bJvv8EKPwjcDCXPdzq/MhV0V/DJaOm', '2024-05-17 12:01:09'),
(28, 'Dorian1', 'DORIAN.12345', '$2y$10$bgGdPwMHZJ50BewtLbd5heT/n92EXR6v9U/tr0CmpTzyizrbm6g4i', '2024-05-17 12:18:54'),
(29, 'thomas', 'Thomas Clark', '$2y$10$IR0KVhnYkXRFTGFIiJZnseN70ivyYl/P/ciamGfHsR33ZuyyhPUZO', '2024-05-17 12:53:10'),
(30, 'Thomas2', 'Thomas Clark2', '$2y$10$KnGdEzpC.a37ypRmBvLo7uJvgw1RXJfUDuN/5ab7zJ4hhgQWrjamG', '2024-05-17 12:57:35'),
(31, 'Rickyy', 'Rick Grimes', '$2y$10$qyb5CEqqZ3XMlfjecTTiEesfmHcJVpxoh1/a0.tyr.DFcrzzHUonG', '2024-05-17 13:02:20'),
(32, 'malitha12', 'malitha12', '$2y$10$/HvsBHUHv7qZ8i8P6nV2hew4vj7MTDdCVEa.Dmx4Ec/jlthFbiM9q', '2024-05-17 13:03:59'),
(33, 'Mortyy', 'Morty Sanders', '$2y$10$jcmFTN7ACSjGWBOJGXhoYONitO4SzJAKYpSTvy9obH4yDbjict3je', '2024-05-17 13:04:27'),
(34, 'Morty Sanders', 'Morty Sanders4', '$2y$10$oeNJ4y4MA4V3XE/TJOJKsOY4i8ZKcieufwB7W.Dfp3UDV0pRSF2Ki', '2024-05-17 13:05:46'),
(35, 'JohnCena', 'John Cena', '$2y$10$WOyP7Sl2u3TFUjNWFd9Ceeo6ccA/5xN49eIf2frX4Fi0BkmMLIKIW', '2024-05-17 13:06:25'),
(36, 'Tony_Stark', 'Tony Stark', '$2y$10$NMkqVDxZOldw6ASSkzZQ7.T79U6mRyPodqXTowft4NiXtmtzCFr46', '2024-05-17 13:09:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_ibfk_1` (`user_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int NOT NULL AUTO_INCREMENT COMMENT 'Unique identifier for each account', AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
