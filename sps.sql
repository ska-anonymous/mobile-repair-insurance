-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 07, 2024 at 08:42 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sps`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `date_registered` datetime DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT NULL,
  `claim_number` varchar(50) DEFAULT NULL,
  `deductible` decimal(10,2) DEFAULT NULL,
  `insurance_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `country`, `postal_code`, `date_registered`, `status`, `claim_number`, `deductible`, `insurance_id`) VALUES
(5, 'Salman Khan', 'hamadatusa@gmail.com', '03446044727', 'Village Jano serai Tehsil and P/O Khwaza Khela District Swat', 'KhwazaKhela', 'Pakistan', '19110', '2023-09-08 00:08:11', 'approved', '123454321', '200.50', 57),
(6, 'Khan', 'khan@gmail.com', '543534543', 'pasawa', 'thana', 'Pakistan', '1321', '2023-09-08 20:52:28', 'approved', '0988', '4343434.00', 57);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `brand`, `model`, `category`) VALUES
(1, 'iPhone', '13 Pro', 'mobile'),
(2, 'iPhone', '14 Pro', 'mobile'),
(3, 'iPhone', '14', 'mobile'),
(4, 'Samsung', 'S23', 'mobile'),
(5, 'Samsung', 'S22', 'mobile'),
(6, 'Samsung', 'A53', 'mobile'),
(7, 'Huawei', 'P30 Pro', 'mobile'),
(8, 'iPhone', 'X', 'mobile');

-- --------------------------------------------------------

--
-- Table structure for table `device_parts`
--

CREATE TABLE `device_parts` (
  `id` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `part_name` varchar(30) NOT NULL,
  `price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `device_parts`
--

INSERT INTO `device_parts` (`id`, `device_id`, `part_name`, `price`) VALUES
(1, 1, 'Display', 349),
(2, 1, 'Backcover', 449),
(3, 2, 'Display', 379),
(4, 2, 'Backcover', 449),
(5, 3, 'Display', 349),
(6, 3, 'Backcover', 399),
(7, 4, 'Display', 329),
(8, 4, 'Backcover', 99),
(9, 5, 'Display', 329),
(10, 5, 'Backcover', 99),
(11, 6, 'Display', 159),
(12, 6, 'Backcover', 99),
(13, 7, 'Display', 349),
(14, 7, 'Backcover', 149),
(15, 7, 'battery', 800);

-- --------------------------------------------------------

--
-- Table structure for table `insurances`
--

CREATE TABLE `insurances` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(300) NOT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `postal_code` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `logo` varchar(200) DEFAULT NULL,
  `status` varchar(30) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `insurances`
--

INSERT INTO `insurances` (`id`, `name`, `address`, `country`, `city`, `postal_code`, `email`, `phone`, `logo`, `status`, `date_created`, `date_modified`) VALUES
(57, 'My Insurance', 'Village Jano serai Tehsil and P/O', 'Pakistan', 'KhwazaKhela', '11110', 'salmankhanserai@gmail.com', '03377883333', '', 'approved', '2023-09-08 02:31:32', '2023-09-08 02:33:10');

-- --------------------------------------------------------

--
-- Table structure for table `repair_cases`
--

CREATE TABLE `repair_cases` (
  `id` int(11) NOT NULL,
  `repair_registration_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `workshop_id` int(11) DEFAULT NULL,
  `status` enum('awaiting','approved','rejected','received','inqueue','working','done') DEFAULT NULL,
  `date_opened` datetime DEFAULT current_timestamp(),
  `date_closed` datetime DEFAULT NULL,
  `description` text DEFAULT NULL,
  `damaged_parts` text NOT NULL,
  `estimated_price` double NOT NULL,
  `actual_price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repair_cases`
--

INSERT INTO `repair_cases` (`id`, `repair_registration_id`, `insurance_id`, `workshop_id`, `status`, `date_opened`, `date_closed`, `description`, `damaged_parts`, `estimated_price`, `actual_price`) VALUES
(33, 3, 57, 6, 'done', '2023-09-09 12:25:02', '2023-09-09 23:38:03', 'Please repair this device. Thanks.', 'battery_$$_cover', 100, '1000.00'),
(34, 1, 57, 6, 'done', '2023-09-09 12:26:46', '2023-09-10 02:21:34', 'Please repair this anothe device. Thanks in advance.', 'battery_$$_new cover_$$_charging base', 500, '1000.00'),
(36, 2, 57, 6, 'awaiting', '2023-09-12 04:52:25', NULL, 'Please repair my device. This time you may have definitly received my email.', 'Display_$$_Backcover_$$_extra cover', 800, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `repair_registration`
--

CREATE TABLE `repair_registration` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `insurance_id` int(11) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `model` varchar(255) DEFAULT NULL,
  `damaged_parts` text DEFAULT NULL,
  `estimated_price` decimal(10,2) DEFAULT NULL,
  `date_registered` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `repair_registration`
--

INSERT INTO `repair_registration` (`id`, `customer_id`, `insurance_id`, `device_name`, `category`, `model`, `damaged_parts`, `estimated_price`, `date_registered`) VALUES
(1, 5, 57, 'mobile', 'mobile', 'A53', 'pasawa_$$_pasawa bia', '500.00', '2023-09-08 12:47:10'),
(2, 5, 57, 'iPhone\r\n', 'mobile', '14', 'Display_$$_Backcover_$$_extra cover', '800.00', '2023-09-08 13:49:23'),
(3, 5, 57, 'my device', 'My Category', 'my model', 'my part', '100.00', '2023-09-08 14:03:11'),
(4, 6, 57, 'oppo', 'My Category', 'y09', 'extra cover_$$_new', '3400.00', '2023-09-08 20:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `role` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `business_id` int(11) DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `username`, `password`, `role`, `type`, `business_id`, `date_registered`) VALUES
(47, 'Admin', 'salmankhanserai@gmail.com', '00000000000', 'admin', '25d55ad283aa400af464c76d713c07ad', 'super_admin', 'super_admin', NULL, '2023-09-08 01:11:25'),
(51, 'Admin Insurance', 'insuranceadmin@gmail.com', '03409403290', 'insurancelogin', '25d55ad283aa400af464c76d713c07ad', 'admin', 'insurance', 57, '2023-09-08 02:31:32'),
(52, 'Workshop Owner', 'workshopuser@gmail.com', '034353423423', 'workshopuser', '25d55ad283aa400af464c76d713c07ad', 'admin', 'workshop', 6, '2023-09-08 23:10:03');

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `date_modified` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `name`, `address`, `email`, `phone`, `city`, `country`, `postal_code`, `logo`, `status`, `date_created`, `date_modified`) VALUES
(6, 'Best Workshop', 'My workshop address which is unknown', 'salmankhanserai@gmail.com', '03454367823', 'Khwaza Khela', 'Pakistan', '111222333', '', 'approved', '2023-09-08 16:10:03', '2023-09-12 04:40:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_parts`
--
ALTER TABLE `device_parts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `insurances`
--
ALTER TABLE `insurances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `repair_cases`
--
ALTER TABLE `repair_cases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `insurance_id` (`insurance_id`),
  ADD KEY `workshop_id` (`workshop_id`);

--
-- Indexes for table `repair_registration`
--
ALTER TABLE `repair_registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `insurance_id` (`insurance_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `device_parts`
--
ALTER TABLE `device_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `insurances`
--
ALTER TABLE `insurances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `repair_cases`
--
ALTER TABLE `repair_cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `repair_registration`
--
ALTER TABLE `repair_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `repair_registration`
--
ALTER TABLE `repair_registration`
  ADD CONSTRAINT `repair_registration_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `repair_registration_ibfk_2` FOREIGN KEY (`insurance_id`) REFERENCES `insurances` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
