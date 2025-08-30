-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2025 at 06:38 PM
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
-- Database: `tortoise_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `breeding_records`
--

CREATE TABLE `breeding_records` (
  `id` int(11) NOT NULL,
  `female_animal_id` int(11) NOT NULL,
  `male_animal_id` int(11) NOT NULL,
  `species` varchar(255) NOT NULL,
  `mating_date` date NOT NULL,
  `nesting_date` date DEFAULT NULL,
  `egg_count` int(11) DEFAULT NULL,
  `incubation_start` date DEFAULT NULL,
  `incubation_period` int(11) DEFAULT NULL,
  `hatch_date` date DEFAULT NULL,
  `hatching_success` decimal(5,2) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `breeding_records`
--

INSERT INTO `breeding_records` (`id`, `female_animal_id`, `male_animal_id`, `species`, `mating_date`, `nesting_date`, `egg_count`, `incubation_start`, `incubation_period`, `hatch_date`, `hatching_success`, `observations`, `created_at`, `updated_at`) VALUES
(1, 12, 11, 'Aldabra giant tortoise', '2025-03-10', '2025-03-20', 4, '2025-03-21', 60, '2025-05-20', 100.00, 'All eggs healthy', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(2, 12, 13, 'Leopard tortoise', '2025-04-01', '2025-04-12', 5, '2025-04-13', 55, '2025-06-07', 80.00, 'One egg damaged', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(3, 14, 15, 'African spurred tortoise', '2025-05-15', '2025-05-25', 3, '2025-05-26', 50, '2025-07-15', 66.00, 'Hatching success low', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(4, 16, 17, 'Burmese star tortoise', '2025-06-05', '2025-06-15', 6, '2025-06-16', 60, '2025-08-15', 83.00, 'All eggs healthy', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(5, 18, 19, 'Travancore tortoise', '2025-07-01', '2025-07-10', 4, '2025-07-11', 55, '2025-09-05', 75.00, 'One egg failed to hatch', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(6, 20, 21, 'Russian tortoise', '2025-08-01', '2025-08-12', 5, '2025-08-13', 50, '2025-10-02', 80.00, 'Minor incubation issue', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(7, 22, 23, 'Greek tortoise', '2025-08-15', '2025-08-25', 3, '2025-08-26', 45, '2025-10-10', 100.00, 'All eggs hatched successfully', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(8, 24, 25, 'Egyptian tortoise', '2025-09-01', '2025-09-10', 4, '2025-09-11', 55, '2025-11-05', 75.00, 'Some eggs infertile', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(9, 26, 27, 'Texas tortoise', '2025-09-15', '2025-09-25', 6, '2025-09-26', 60, '2025-11-25', 83.00, 'Good hatching success', '2025-08-29 12:53:43', '2025-08-29 12:53:43'),
(10, 28, 29, 'Sonoran desert tortoise', '2025-10-01', '2025-10-10', 5, '2025-10-11', 55, '2025-12-05', 80.00, 'Normal hatching', '2025-08-29 12:53:43', '2025-08-29 12:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `enclosures`
--

CREATE TABLE `enclosures` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `capacity` int(11) NOT NULL,
  `current_occupancy` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enclosures`
--

INSERT INTO `enclosures` (`id`, `name`, `type`, `capacity`, `current_occupancy`, `created_at`, `updated_at`) VALUES
(9, 'Enclosure B', 'General', 50, 12, '2025-08-29 12:21:03', '2025-08-29 15:59:05'),
(10, 'Enclosure C', 'General', 50, 12, '2025-08-29 12:21:03', '2025-08-29 15:59:05'),
(11, 'Enclosure D', 'General', 50, 12, '2025-08-29 12:21:03', '2025-08-29 15:59:05'),
(12, 'Enclosure E', 'General', 50, 2, '2025-08-29 12:21:03', '2025-08-29 15:59:05'),
(13, 'Enclosure A', 'General', 50, 12, '2025-08-29 12:23:01', '2025-08-29 15:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `feeding_details`
--

CREATE TABLE `feeding_details` (
  `id` int(11) NOT NULL,
  `staff_assigned` varchar(100) DEFAULT NULL,
  `feeding_time` time NOT NULL,
  `food_type` varchar(100) DEFAULT NULL,
  `quantity` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Completed','Missed') DEFAULT 'Pending',
  `observations` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feeding_details`
--

INSERT INTO `feeding_details` (`id`, `staff_assigned`, `feeding_time`, `food_type`, `quantity`, `status`, `observations`, `created_at`, `updated_at`) VALUES
(11, 'Jane Smith', '21:43:00', 'Wet', '10', 'Completed', 'Healthy', '2025-08-29 21:38:37', '2025-08-29 21:43:22'),
(12, 'Bob Green', '09:30:00', 'Dry', '12', 'Pending', 'Feed later', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(13, 'Mary White', '12:15:00', 'Mixed', '8', 'Completed', 'Left some food', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(14, 'Alice Brown', '14:00:00', 'Wet', '9', 'Pending', 'Monitor', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(15, 'Jane Smith', '16:20:00', 'Dry', '11', 'Completed', 'Well fed', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(16, 'Bob Green', '07:50:00', 'Mixed', '7', 'Completed', 'Healthy', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(17, 'Mary White', '10:10:00', 'Wet', '10', 'Pending', 'Check appetite', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(18, 'Alice Brown', '13:45:00', 'Dry', '12', 'Completed', 'Active', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(19, 'Jane Smith', '15:30:00', 'Mixed', '9', 'Pending', 'Sick today', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(20, 'Bob Green', '18:00:00', 'Wet', '8', 'Completed', 'Healthy', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(21, 'Mary White', '08:30:00', 'Dry', '11', 'Completed', 'Normal', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(22, 'Alice Brown', '09:45:00', 'Mixed', '10', 'Pending', 'Observe', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(23, 'Jane Smith', '11:00:00', 'Wet', '12', 'Completed', 'Well fed', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(24, 'Bob Green', '12:30:00', 'Dry', '9', 'Pending', 'Monitor health', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(25, 'Mary White', '14:15:00', 'Mixed', '10', 'Completed', 'Good appetite', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(26, 'Alice Brown', '15:50:00', 'Wet', '11', 'Completed', 'Healthy', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(27, 'Jane Smith', '08:20:00', 'Dry', '7', 'Pending', 'Feed later', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(28, 'Bob Green', '10:40:00', 'Mixed', '12', 'Completed', 'Satisfied', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(29, 'Mary White', '13:10:00', 'Wet', '9', 'Completed', 'Normal', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(30, 'Alice Brown', '16:05:00', 'Dry', '10', 'Pending', 'Left some food', '2025-08-29 21:38:37', '2025-08-29 21:38:37'),
(53, 'Asad', '22:28:00', 'Wet', '5', 'Completed', 'Healthy', '2025-08-29 22:29:09', '2025-08-29 22:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `food_inventory`
--

CREATE TABLE `food_inventory` (
  `id` int(11) NOT NULL,
  `food_item` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_inventory`
--

INSERT INTO `food_inventory` (`id`, `food_item`, `quantity`, `added_at`) VALUES
(2, 'Food', 14, '2025-08-29 15:53:00'),
(10, 'Lettuce', 10, '2025-08-29 02:00:00'),
(11, 'Carrots', 14, '2025-08-29 03:30:00'),
(12, 'Apples', 8, '2025-08-29 04:15:00'),
(13, 'Spinach', 12, '2025-08-29 05:45:00'),
(14, 'Cucumbers', 6, '2025-08-29 06:30:00'),
(15, 'Kale', 9, '2025-08-29 07:50:00'),
(16, 'Bananas', 7, '2025-08-29 09:20:00'),
(17, 'Pumpkin', 11, '2025-08-29 10:10:00');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `age` int(11) DEFAULT NULL,
  `title` varchar(50) DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `name`, `age`, `title`, `join_date`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 35, 'Caretaker', '2020-01-15', '2025-08-29 20:55:41', '2025-08-29 20:55:41'),
(2, 'Jane Smith', 28, 'Veterinarian', '2021-06-20', '2025-08-29 20:55:41', '2025-08-29 20:55:41'),
(3, 'Alice Brown', 42, 'Senior Caretaker', '2018-03-10', '2025-08-29 20:55:41', '2025-08-29 20:55:41'),
(4, 'Bob Green', 30, 'Nutrition Specialist', '2019-11-05', '2025-08-29 20:55:41', '2025-08-29 20:55:41'),
(5, 'Mary White', 25, 'Assistant', '2022-07-01', '2025-08-29 20:55:41', '2025-08-29 20:55:41'),
(6, 'Asad', 25, 'CareTaker', '2025-08-21', '2025-08-29 22:24:52', '2025-08-29 22:25:05');

-- --------------------------------------------------------

--
-- Table structure for table `surveillance`
--

CREATE TABLE `surveillance` (
  `id` int(11) NOT NULL,
  `enclosure_id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `habitat_type` varchar(255) NOT NULL,
  `current_occupants` text DEFAULT NULL,
  `maintenance_schedule` text DEFAULT NULL,
  `temperature` decimal(5,2) DEFAULT NULL,
  `humidity` decimal(5,2) DEFAULT NULL,
  `light_level` varchar(50) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surveillance`
--

INSERT INTO `surveillance` (`id`, `enclosure_id`, `size`, `habitat_type`, `current_occupants`, `maintenance_schedule`, `temperature`, `humidity`, `light_level`, `observations`, `created_at`, `updated_at`) VALUES
(11, 13, '5 units', 'Forest', 'Star, Scout, Max', 'Clean weekly', 25.00, 60.00, 'High', 'All animals are healthy', '2025-08-29 13:18:28', '2025-08-29 13:27:16'),
(12, 9, '6 units', 'Desert', 'Speedy, Pebbles, Nile, Sunny', 'Clean bi-weekly', 30.00, 20.00, 'High', 'Some animals need vitamin supplements', '2025-08-29 13:18:28', '2025-08-29 13:18:28'),
(13, 10, '4 units', 'Grassland', 'Spot, Slinky, Buster, Nama, Geo, Hermie', 'Clean weekly', 28.00, 50.00, 'Medium', 'Grass growing well', '2025-08-29 13:18:28', '2025-08-29 13:18:28'),
(14, 11, '5 units', 'Aquatic', 'Tank, Rocky, Tex, Sunnyfoot, Rus, Afrie, Cris, Yello', 'Clean weekly', 24.00, 70.00, 'Low', 'Water level sufficient', '2025-08-29 13:18:28', '2025-08-29 13:18:28'),
(15, 12, '3 units', 'Savannah', 'Shelly, Momo', 'Clean weekly', 26.00, 45.00, 'Medium', 'Tortoises active', '2025-08-29 13:18:28', '2025-08-29 13:18:28');

-- --------------------------------------------------------

--
-- Table structure for table `tortoises`
--

CREATE TABLE `tortoises` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `species` varchar(100) NOT NULL,
  `age_years` int(11) NOT NULL,
  `gender` enum('Male','Female','Unknown') NOT NULL DEFAULT 'Unknown',
  `health_status` enum('Healthy','Sick','Injured','Quarantined') NOT NULL DEFAULT 'Healthy',
  `enclosure` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tortoises`
--

INSERT INTO `tortoises` (`id`, `name`, `species`, `age_years`, `gender`, `health_status`, `enclosure`, `created_at`) VALUES
(11, 'Shelly', 'Aldabra giant tortoise', 12, 'Male', 'Sick', 'Enclosure E', '2025-08-29 03:43:28'),
(12, 'Speedy', 'Galápagos giant tortoise', 45, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(13, 'Spot', 'Leopard tortoise', 7, 'Male', 'Injured', 'Enclosure C', '2025-08-29 03:43:28'),
(14, 'Tank', 'African spurred tortoise', 20, 'Female', 'Sick', 'Enclosure D', '2025-08-29 03:43:28'),
(15, 'Star', 'Indian star tortoise', 5, 'Male', 'Healthy', 'Enclosure A', '2025-08-29 03:43:28'),
(16, 'Pebbles', 'Burmese star tortoise', 9, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(17, 'Slinky', 'Elongated tortoise', 14, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(18, 'Rocky', 'Travancore tortoise', 11, 'Female', 'Injured', 'Enclosure D', '2025-08-29 03:43:28'),
(19, 'Scout', 'Forsten’s tortoise', 6, 'Male', 'Sick', 'Enclosure A', '2025-08-29 03:43:28'),
(20, 'Rusty', 'Russian tortoise', 4, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(21, 'Herman', 'Hermann’s tortoise', 8, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(22, 'Greta', 'Greek tortoise', 10, 'Female', 'Injured', 'Enclosure D', '2025-08-29 03:43:28'),
(23, 'Max', 'Marginated tortoise', 17, 'Male', 'Healthy', 'Enclosure A', '2025-08-29 03:43:28'),
(24, 'Nile', 'Egyptian tortoise', 3, 'Female', 'Sick', 'Enclosure B', '2025-08-29 03:43:28'),
(25, 'Buster', 'Bolson tortoise', 19, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(26, 'Tex', 'Texas tortoise', 15, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(27, 'Sandy', 'Desert tortoise', 28, 'Male', 'Healthy', 'Enclosure A', '2025-08-29 03:43:28'),
(28, 'Sunny', 'Sonoran desert tortoise', 9, 'Female', 'Injured', 'Enclosure B', '2025-08-29 03:43:28'),
(29, 'Gopher', 'Gopher tortoise', 6, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(30, 'Pancake', 'Pancake tortoise', 13, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(31, 'Angie', 'Angulate tortoise', 11, 'Male', 'Sick', 'Enclosure A', '2025-08-29 03:43:28'),
(32, 'Speckles', 'Speckled cape tortoise', 5, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(33, 'Nama', 'Namaqualand speckled tortoise', 2, 'Male', 'Sick', 'Enclosure C', '2025-08-29 03:43:28'),
(34, 'Karo', 'Karoo dwarf tortoise', 4, 'Female', 'Injured', 'Enclosure D', '2025-08-29 03:43:28'),
(35, 'Tentacle', 'Tent tortoise', 12, 'Male', 'Healthy', 'Enclosure A', '2025-08-29 03:43:28'),
(36, 'Serrato', 'Serrated tortoise', 14, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(37, 'Geo', 'Geometric tortoise', 6, 'Male', 'Sick', 'Enclosure C', '2025-08-29 03:43:28'),
(38, 'Sunnyfoot', 'Yellow-footed tortoise', 25, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(39, 'Red', 'Red-footed tortoise', 18, 'Male', 'Healthy', 'Enclosure A', '2025-08-29 03:43:28'),
(40, 'Chaco', 'Chaco tortoise', 9, 'Female', 'Injured', 'Enclosure B', '2025-08-29 03:43:28'),
(41, 'Brazil', 'Brazilian giant tortoise', 30, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(42, 'Cruz', 'Santa Cruz tortoise', 22, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(43, 'Izzy', 'Isabela giant tortoise', 44, 'Male', 'Sick', 'Enclosure A', '2025-08-29 03:43:28'),
(44, 'Sierra', 'Sierra Negra tortoise', 35, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(45, 'Espa', 'Española giant tortoise', 40, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(46, 'Cris', 'San Cristóbal giant tortoise', 27, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(47, 'Pinzo', 'Pinzón tortoise', 19, 'Male', 'Injured', 'Enclosure A', '2025-08-29 03:43:28'),
(48, 'Santi', 'Santiago tortoise', 24, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(49, 'Hermie', 'Hermann’s tortoise', 5, 'Male', 'Sick', 'Enclosure C', '2025-08-29 03:43:28'),
(50, 'Rus', 'Russian tortoise', 7, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(51, 'Leo', 'Leopard tortoise', 13, 'Male', 'Healthy', 'Enclosure A', '2025-08-29 03:43:28'),
(52, 'Gracie', 'Greek tortoise', 6, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(53, 'Egy', 'Egyptian tortoise', 2, 'Male', 'Injured', 'Enclosure C', '2025-08-29 03:43:28'),
(54, 'Afrie', 'African spurred tortoise', 21, 'Female', 'Sick', 'Enclosure D', '2025-08-29 03:43:28'),
(55, 'Bolly', 'Bolson tortoise', 29, 'Male', 'Sick', 'Enclosure A', '2025-08-29 03:43:28'),
(56, 'Indy', 'Indian star tortoise', 4, 'Female', 'Healthy', 'Enclosure B', '2025-08-29 03:43:28'),
(57, 'Redy', 'Red-footed tortoise', 15, 'Male', 'Healthy', 'Enclosure C', '2025-08-29 03:43:28'),
(58, 'Yello', 'Yellow-footed tortoise', 20, 'Female', 'Healthy', 'Enclosure D', '2025-08-29 03:43:28'),
(59, 'Marge', 'Marginated tortoise', 8, 'Male', 'Injured', 'Enclosure A', '2025-08-29 03:43:28'),
(61, 'Momo', 'Bolson tortoise', 5, 'Male', 'Sick', 'Enclosure E', '2025-08-29 12:22:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `breeding_records`
--
ALTER TABLE `breeding_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enclosures`
--
ALTER TABLE `enclosures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeding_details`
--
ALTER TABLE `feeding_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_inventory`
--
ALTER TABLE `food_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `surveillance`
--
ALTER TABLE `surveillance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enclosure_id` (`enclosure_id`);

--
-- Indexes for table `tortoises`
--
ALTER TABLE `tortoises`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `breeding_records`
--
ALTER TABLE `breeding_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `enclosures`
--
ALTER TABLE `enclosures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `feeding_details`
--
ALTER TABLE `feeding_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `food_inventory`
--
ALTER TABLE `food_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surveillance`
--
ALTER TABLE `surveillance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tortoises`
--
ALTER TABLE `tortoises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surveillance`
--
ALTER TABLE `surveillance`
  ADD CONSTRAINT `surveillance_ibfk_1` FOREIGN KEY (`enclosure_id`) REFERENCES `enclosures` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
