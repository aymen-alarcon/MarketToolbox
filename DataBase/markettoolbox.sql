-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 08:05 PM
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
-- Database: `markettoolbox`
--

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `GenderID` tinyint(3) UNSIGNED NOT NULL,
  `gender_name` varchar(20) NOT NULL,
  `gender_name_ar` varchar(20) NOT NULL,
  `gender_name_fr` varchar(20) NOT NULL,
  `gender_value` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`GenderID`, `gender_name`, `gender_name_ar`, `gender_name_fr`, `gender_value`) VALUES
(1, 'Male', 'ذكر', 'Homme', 0),
(2, 'Female', 'أنثى', 'Femme', 1),
(3, 'Prefer not to say', 'لا أرغب في الكشف', 'Préfère ne pas dire', 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ProductID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `height` float NOT NULL,
  `width` float NOT NULL,
  `material` varchar(255) NOT NULL,
  `room` int(1) NOT NULL,
  `colors_images` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ProductID`, `UserID`, `name`, `price`, `height`, `width`, `material`, `room`, `colors_images`, `created_at`) VALUES
(2, 9, 'Asad', 5555.00, 54, 35, 'wood', 2, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (1).png\"},{\"color\":\"#ffff00\",\"image\":\"uploads\\/Screenshot (1).png\"}]', '2024-09-19 11:16:07'),
(3, 9, 'Aymen Oumaalla', 24525.00, 548, 254, 'carbon fiber', 3, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (10).png\"},{\"color\":\"#ffff00\",\"image\":\"uploads\\/Screenshot (1).png\"}]', '2024-09-19 14:08:31'),
(4, 9, 'Alarc ', 54.00, 534, 685, 'wood', 5, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (3).png\"},{\"color\":\"#ffff00\",\"image\":\"uploads\\/Screenshot (1).png\"}]', '2024-09-19 14:09:03'),
(5, 9, 'bc', 6568.00, 65, 25, 'wood', 6, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (26).png\"},{\"color\":\"#ffff00\",\"image\":\"uploads\\/Screenshot (1).png\"}]', '2024-09-19 14:09:47'),
(6, 9, 'Aymen ss', 35.00, 65468, 654, 'steal', 4, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (7).png\"},{\"color\":\"#ffff00\",\"image\":\"uploads\\/Screenshot (1).png\"}]', '2024-09-19 14:10:24'),
(23, 9, 'Asad', 5341.00, 653, 6, '58', 2, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (2).png\"},{\"color\":\"#ffff00\",\"image\":\"uploads\\/Screenshot (1).png\"}]', '2024-09-30 12:21:47'),
(24, 9, 'Aymen', 687.00, 45, 35, 'steal', 3, '[{\"color\":\"#ff0000\",\"image\":\"uploads\\/Screenshot (7).png\"},{\"color\":\"#ffc0cb\",\"image\":\"uploads\\/Capture d\'\\u00e9cran 2024-08-04 202522.png\"}]', '2024-09-30 13:09:37');

-- --------------------------------------------------------

--
-- Table structure for table `profile_pictures`
--

CREATE TABLE `profile_pictures` (
  `PPID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_type` int(1) NOT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_pictures`
--

INSERT INTO `profile_pictures` (`PPID`, `UserID`, `image_url`, `image_type`, `uploaded_at`, `is_deleted`) VALUES
(17, 6, 'users/profile_Screenshot (2).png', 1, '2024-08-21 16:34:01', 0),
(18, 6, 'users/background_Capture d\'écran 2024-08-04 202522.png', 2, '2024-08-21 16:34:01', 1),
(19, 6, 'users/background_Capture d\'écran 2024-07-18 163646.png', 2, '2024-08-21 17:23:50', 1),
(20, 6, 'users/background_Capture d\'écran 2024-07-18 171904.png', 2, '2024-08-21 17:55:45', 1),
(21, 6, 'users/background_Screenshot (9).png', 2, '2024-08-21 17:58:01', 1),
(22, 6, 'users/background_Screenshot (3).png', 2, '2024-08-21 17:59:17', 1),
(23, 6, 'users/background_Capture d\'écran 2024-08-04 195852.png', 2, '2024-08-21 18:00:14', 1),
(24, 6, 'users/background_Screenshot (3).png', 2, '2024-08-21 18:00:28', 0),
(25, 9, 'users/profile_Capture d\'écran 2024-07-19 200149.png', 1, '2024-09-18 11:43:29', 1),
(26, 9, 'users/background_Screenshot (1).png', 2, '2024-09-18 11:43:29', 1),
(27, 9, 'users/profile_Capture d\'écran 2024-07-19 200149.png', 1, '2024-09-18 11:49:28', 1),
(28, 9, 'users/background_Screenshot (1).png', 2, '2024-09-18 11:49:28', 1),
(29, 9, 'users/profile_Screenshot (9).png', 1, '2024-10-08 10:18:48', 1),
(30, 9, 'users/profile_Screenshot (46).png', 1, '2024-10-08 10:22:22', 1),
(31, 9, 'users/profile_Capture d\'écran 2024-08-04 195852.png', 1, '2024-10-08 10:23:12', 1),
(32, 9, 'users/profile_Capture d\'écran 2024-08-04 195852.png', 1, '2024-10-08 10:23:15', 1),
(33, 9, 'users/profile_Screenshot (22).png', 1, '2024-10-08 10:23:36', 1),
(34, 9, 'users/profile_Screenshot (2).png', 1, '2024-10-08 10:29:36', 1),
(35, 9, 'users/background_Capture d\'écran 2024-08-04 195852.png', 2, '2024-10-08 10:37:11', 1),
(36, 9, 'users/profile_Screenshot (42).png', 1, '2024-10-08 10:39:44', 1),
(37, 9, 'users/background_Screenshot (43).png', 2, '2024-10-08 10:40:02', 0),
(38, 9, 'users/profile_Screenshot (46).png', 1, '2024-10-10 09:52:18', 0),
(39, 9, 'users/profile_Screenshot (2).png', 1, '2024-10-10 10:46:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `ratings_reviews`
--

CREATE TABLE `ratings_reviews` (
  `ReviewID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `review_text` text DEFAULT NULL,
  `DateAdded` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ratings_reviews`
--

INSERT INTO `ratings_reviews` (`ReviewID`, `ProductID`, `UserID`, `rating`, `review_text`, `DateAdded`) VALUES
(13, 6, 6, 4, '', '2024-10-04'),
(15, 3, 6, 5, 'good product mate', '2024-10-07');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name_en` varchar(255) NOT NULL,
  `room_name_fr` varchar(255) NOT NULL,
  `room_name_ar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name_en`, `room_name_fr`, `room_name_ar`) VALUES
(1, 'Living Room', 'Salon', 'غرفة المعيشة'),
(2, 'Bedroom', 'Chambre', 'غرفة النوم'),
(3, 'Kitchen', 'Cuisine', 'مطبخ'),
(4, 'Dining Room', 'Salle à Manger', 'غرفة الطعام'),
(5, 'Office', 'Bureau', 'مكتب'),
(6, 'Bathroom', 'Salle de Bain', 'حمام');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phonenumber` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` char(60) NOT NULL,
  `adresse` varchar(30) DEFAULT NULL,
  `type` int(1) NOT NULL DEFAULT 1,
  `Gender` int(1) NOT NULL,
  `DateAdded` date NOT NULL DEFAULT current_timestamp(),
  `is_deleted` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `fullname`, `username`, `phonenumber`, `email`, `password`, `adresse`, `type`, `Gender`, `DateAdded`, `is_deleted`) VALUES
(6, 'Aymen Oumaalla', 'aymen2002@gmail.com', '0629474030', 'aymenoml2002@gmail.com', '$2y$10$wjGg8ZWY5HfZB8syCDu4zeExMnrDP1agjAk6ImAP/o3sNS93juWMC', NULL, 0, 3, '2024-08-20', 0),
(9, 'Aymen Oumaalla', 'alarcon', '0629474030', 'aymenoml200@gmail.com', '$2y$10$xdzdyQI0lpqUfoOTUaky/O44gDmU.UFN1wxohXprUHQmIdl4pR8YW', 'ISEBTIENNE DB EL HAMMAME NO 61', 2, 2, '2024-09-18', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_ratings`
--

CREATE TABLE `user_ratings` (
  `RatingID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `RatedBy` int(11) NOT NULL,
  `Rating` int(11) DEFAULT NULL CHECK (`Rating` between 1 and 10),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`GenderID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  ADD PRIMARY KEY (`PPID`),
  ADD KEY `profile_pictures_ibfk_1` (`UserID`);

--
-- Indexes for table `ratings_reviews`
--
ALTER TABLE `ratings_reviews`
  ADD PRIMARY KEY (`ReviewID`),
  ADD UNIQUE KEY `unique_product_user` (`ProductID`,`UserID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`) USING BTREE;

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD PRIMARY KEY (`RatingID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `RatedBy` (`RatedBy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `GenderID` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  MODIFY `PPID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `ratings_reviews`
--
ALTER TABLE `ratings_reviews`
  MODIFY `ReviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user_ratings`
--
ALTER TABLE `user_ratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `profile_pictures`
--
ALTER TABLE `profile_pictures`
  ADD CONSTRAINT `profile_pictures_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ratings_reviews`
--
ALTER TABLE `ratings_reviews`
  ADD CONSTRAINT `ratings_reviews_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ProductID`),
  ADD CONSTRAINT `ratings_reviews_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`);

--
-- Constraints for table `user_ratings`
--
ALTER TABLE `user_ratings`
  ADD CONSTRAINT `user_ratings_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `user_ratings_ibfk_2` FOREIGN KEY (`RatedBy`) REFERENCES `users` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
