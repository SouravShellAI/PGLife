-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 17, 2026 at 03:22 PM
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
-- Database: `pg_life`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `type`, `icon`) VALUES
(1, 'Wifi', 'Common Area', 'wifi'),
(2, 'Power Backup', 'Building', 'powerbackup'),
(3, 'Fire Extinguisher', 'Building', 'fireext'),
(4, 'TV', 'Common Area', 'tv'),
(5, 'Bed with Mattress', 'Bedroom', 'bed'),
(6, 'Parking', 'Building', 'parking'),
(7, 'Water Purifier', 'Common Area', 'rowater'),
(8, 'Dining', 'Common Area', 'dining'),
(9, 'Air Conditioner', 'Bedroom', 'ac'),
(10, 'Washing Machine', 'Common Area', 'washingmachine'),
(11, 'Lift', 'Building', 'lift'),
(12, 'CCTV', 'Building', 'cctv'),
(13, 'Geyser', 'Washroom', 'geyser');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_cancellations`
--

CREATE TABLE `booking_cancellations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `comments` text DEFAULT NULL,
  `cancellation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_cancellations`
--

INSERT INTO `booking_cancellations` (`id`, `user_id`, `property_id`, `reason`, `comments`, `cancellation_date`) VALUES
(1, 5, 1, 'Found a better place', 'Too Expensive', '2026-01-17 13:51:19');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`) VALUES
(1, 'Delhi'),
(2, 'Mumbai'),
(3, 'Bengaluru'),
(4, 'Hyderabad');

-- --------------------------------------------------------

--
-- Table structure for table `favourites`
--

CREATE TABLE `favourites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favourites`
--

INSERT INTO `favourites` (`id`, `user_id`, `property_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 5),
(4, 2, 1),
(5, 2, 5),
(6, 3, 1),
(7, 3, 2),
(8, 3, 5),
(9, 4, 2),
(10, 4, 3),
(11, 4, 4);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `gender_allowed` enum('Male','Female','Unisex') DEFAULT NULL,
  `rent` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `rating_clean` float DEFAULT NULL,
  `rating_food` float DEFAULT NULL,
  `rating_safety` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `name`, `address`, `city_id`, `gender_allowed`, `rent`, `description`, `image_url`, `rating_clean`, `rating_food`, `rating_safety`) VALUES
(1, 'Saxena\'s Paying Guest', 'H.No. 3958 Kaseru Walan, Pahar Ganj, New Delhi, Delhi 110055', 1, 'Male', 5000, 'Furnished studio apartment - share it with close friends! Located in posh area of Bijwasan in Delhi. With a common living area and a shared kitchen, make it your own FRIENDS moments.', 'img/properties/1/saxena.jpg', 4.3, 3.4, 4.8),
(2, 'Navrang PG Home', '644-C,Mohalla Baoli 6 Tooti Chowk, Paharganj, New Delhi, Delhi 110055', 1, 'Unisex', 6000, 'Furnished studio apartment - share it with close friends! Located in posh area of Bijwasan in Delhi. Private and shared rooms available.', 'img/properties/1/navrang.jpg', 2.9, 3.4, 3.8),
(3, 'Navkar Paying Guest', '44, Juhu Scheme, Juhu, Mumbai, Maharashtra 400058', 2, 'Female', 9500, 'Furnished studio apartment with all basic amenities. Shared living space, cozy and safe environment.', 'img/properties/1/navkar.jpg', 3.9, 3.8, 4.9),
(4, 'PG for Girls Borivali West', 'Plot no.258/D4, Gorai no.2, Borivali West, Mumbai, Maharashtra 400092', 2, 'Female', 8000, 'Furnished studio apartment for girls. Shared kitchen and common areas. Safe and comfortable.', 'img/properties/1/borivali.jpg', 4.2, 4.1, 4.5),
(5, 'Ganpati Paying Guest', 'Police Beat, Sainath Complex, Besides, SV Rd, Daulat Nagar, Borivali East, Mumbai - 400066', 2, 'Male', 8500, 'Furnished studio apartment - share it with close friends! Cozy, well-maintained, and safe.', 'img/properties/1/ganpati.jpg', 4.2, 3.9, 4.6);

-- --------------------------------------------------------

--
-- Table structure for table `property_amenities`
--

CREATE TABLE `property_amenities` (
  `id` int(11) NOT NULL,
  `property_id` int(11) DEFAULT NULL,
  `amenity_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_amenities`
--

INSERT INTO `property_amenities` (`id`, `property_id`, `amenity_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 4),
(4, 1, 5),
(5, 1, 7),
(6, 1, 8),
(7, 1, 9),
(8, 1, 10),
(9, 1, 11),
(10, 1, 13),
(11, 2, 1),
(12, 2, 2),
(13, 2, 3),
(14, 2, 4),
(15, 2, 5),
(16, 2, 7),
(17, 2, 8),
(18, 2, 9),
(19, 2, 10),
(20, 2, 11),
(21, 2, 13),
(22, 3, 1),
(23, 3, 2),
(24, 3, 3),
(25, 3, 4),
(26, 3, 5),
(27, 3, 7),
(28, 3, 8),
(29, 3, 10),
(30, 3, 11),
(31, 3, 12),
(32, 3, 13),
(33, 4, 1),
(34, 4, 3),
(35, 4, 4),
(36, 4, 5),
(37, 4, 7),
(38, 4, 8),
(39, 4, 10),
(40, 4, 11),
(41, 4, 12),
(42, 4, 13),
(43, 5, 1),
(44, 5, 3),
(45, 5, 4),
(46, 5, 5),
(47, 5, 7),
(48, 5, 8),
(49, 5, 10),
(50, 5, 11),
(51, 5, 12),
(52, 5, 13);

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `property_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `date_posted` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `user_id`, `property_id`, `rating`, `comment`, `date_posted`) VALUES
(1, 1, 1, 5, 'Fully furnished, all basic amenities, great location!', '2025-10-13 00:00:00'),
(2, 1, 2, 4, 'Nice property with a friendly environment.', '2025-10-12 00:00:00'),
(3, 2, 1, 4, 'Clean rooms and good food.', '2025-10-10 00:00:00'),
(4, 2, 5, 5, 'Safe neighborhood and supportive staff.', '2025-10-11 00:00:00'),
(5, 3, 3, 4, 'Affordable and comfortable stay.', '2025-10-09 00:00:00'),
(6, 4, 2, 4, 'Good for girls, hygienic and spacious.', '2025-10-08 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `college` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `gender`, `college`) VALUES
(1, 'Anuj Kalbalia', 'anuj.kalbalia@gmail.com', 'anuj123', '9535100112', 'Male', 'NITD'),
(2, 'Shadab Alam', 'shadab@gmail.com', 'shadab123', '9876543210', 'Male', 'NITJ'),
(3, 'Aditya Sood', 'aditya@gmail.com', 'aditya123', '9876543210', 'Male', 'Chandigarh University'),
(4, 'Radhika Bhatia', 'radhika@gmail.com', 'radhika123', '9876543210', 'Female', 'Delhi University'),
(5, 'Mohit Sharma', 'sharmamohit01@gmail.com', 'Mohit@123', '9535100112', 'Male', 'Ayushman University'),
(6, 'Naina Sil', 'naina123@gmail.com', 'Naina@123', '6290656831', 'Female', 'ayushman university');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `property_id` (`property_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `booking_cancellations`
--
ALTER TABLE `booking_cancellations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favourites`
--
ALTER TABLE `favourites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`property_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- Indexes for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `property_id` (`property_id`,`amenity_id`),
  ADD KEY `amenity_id` (`amenity_id`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booking_cancellations`
--
ALTER TABLE `booking_cancellations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `favourites`
--
ALTER TABLE `favourites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `property_amenities`
--
ALTER TABLE `property_amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_cancellations`
--
ALTER TABLE `booking_cancellations`
  ADD CONSTRAINT `booking_cancellations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_cancellations_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `favourites`
--
ALTER TABLE `favourites`
  ADD CONSTRAINT `favourites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `favourites_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`);

--
-- Constraints for table `property_amenities`
--
ALTER TABLE `property_amenities`
  ADD CONSTRAINT `property_amenities_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`),
  ADD CONSTRAINT `property_amenities_ibfk_2` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`);

--
-- Constraints for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD CONSTRAINT `testimonials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `testimonials_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
