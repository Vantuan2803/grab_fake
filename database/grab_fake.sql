-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 17, 2024 at 03:47 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grab_fake`
--

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `distance` varchar(50) NOT NULL,
  `is_available` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `distance`, `is_available`) VALUES
(1, 'Hà Đông', '0', 1),
(2, 'Cầu Giấy', '20', 1),
(3, 'Hoàng Mai', '15', 1),
(4, 'Đống Đa', '30', 1),
(5, 'Hai Bà Trưng', '50', 1),
(6, 'Thanh Xuân', '10', 1),
(7, 'Nam Từ Liêm', '90', 1),
(8, 'Tây Hồ', '70', 1),
(9, 'Bắc Từ Liêm', '100', 1),
(10, 'Long Biên', '60', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ride`
--

CREATE TABLE `ride` (
  `ride_id` int NOT NULL,
  `ride_date` varchar(20) NOT NULL,
  `from_distance` varchar(50) NOT NULL,
  `to_distance` varchar(50) NOT NULL,
  `cab_type` tinyint NOT NULL,
  `total_distance` varchar(50) NOT NULL,
  `luggage` varchar(50) NOT NULL,
  `total_fare` varchar(50) NOT NULL,
  `status` int NOT NULL,
  `customer_user_id` int NOT NULL,
  `driver_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ride`
--

INSERT INTO `ride` (`ride_id`, `ride_date`, `from_distance`, `to_distance`, `cab_type`, `total_distance`, `luggage`, `total_fare`, `status`, `customer_user_id`, `driver_id`) VALUES
(1, '2024-07-17 04:09', 'Hà Đông', 'Cầu Giấy', 1, '20', '10', '355', 0, 2, 0),
(2, '2024-07-17 04:09', 'Hoàng Mai', 'Đống Đa', 2, '15', '3', '410', 1, 2, 0),
(3, '2024-07-17 04:10', 'Đống Đa', 'Hai Bà Trưng', 3, '20', '5', '545', 1, 2, 0),
(4, '2024-07-17 04:10', 'Thanh Xuân', 'Tây Hồ', 4, '60', '7', '1265', 2, 2, 8),
(5, '2024-07-17 04:12', 'Nam Từ Liêm', 'Tây Hồ', 1, '20', '6', '355', 2, 3, 5),
(6, '2024-07-17 04:12', 'Hà Đông', 'Thanh Xuân', 2, '10', '2', '345', 2, 3, 6),
(7, '2024-07-17 04:12', 'Hai Bà Trưng', 'Long Biên', 3, '10', '4', '405', 2, 3, 7),
(8, '2024-07-17 04:12', 'Tây Hồ', 'Cầu Giấy', 4, '50', '7', '1115', 1, 3, 0),
(9, '2024-07-17 04:13', 'Thanh Xuân', 'Hà Đông', 1, '10', '10', '235', 1, 4, 0),
(10, '2024-07-17 04:13', 'Cầu Giấy', 'Đống Đa', 2, '10', '12', '395', 1, 4, 0),
(11, '2024-07-17 04:13', 'Bắc Từ Liêm', 'Đống Đa', 3, '70', '1', '1227', 1, 4, 0),
(12, '2024-07-17 04:14', 'Hai Bà Trưng', 'Long Biên', 4, '10', '7', '515', 1, 4, 0),
(13, '2024-07-17 04:36', 'Hà Đông', 'Tây Hồ', 2, '70', '20', '1157', 1, 2, 0),
(14, '2024-07-17 04:51', 'Cầu Giấy', 'Hà Đông', 1, '20', '20', '405', 1, 2, 0),
(15, '2024-07-17 07:47', 'Hà Đông', 'Đống Đa', 3, '30', '20', '735', 1, 3, 0),
(16, '2024-07-17 07:47', 'Hà Đông', 'Long Biên', 2, '60', '12', '1045', 1, 3, 0),
(17, '2024-07-17 07:53', 'Đống Đa', 'Hoàng Mai', 2, '15', '20', '460', 1, 4, 0),
(18, '2024-07-17 08:15', 'Hà Đông', 'Cầu Giấy', 2, '20', '20', '525', 1, 2, 0),
(19, '2024-07-17 09:12', 'Hoàng Mai', 'Cầu Giấy', 2, '5', '20', '322.5', 1, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `dateofsignup` varchar(20) NOT NULL,
  `mobile` varchar(15) NOT NULL,
  `isblock` tinyint(1) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `vehicle_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `name`, `dateofsignup`, `mobile`, `isblock`, `password`, `role`, `vehicle_type`) VALUES
(1, 'admin@gmail.com', 'Admin', '2024-07-01 03:48', '0123456789', 1, '202cb962ac59075b964b07152d234b70', 1, 0),
(2, 'user1@gmail.com', 'Nguyen Van A', '2024-07-01 06:03', '0987654321', 1, '202cb962ac59075b964b07152d234b70', 3, 0),
(3, 'user2@gmail.com', 'Nguyen Van B', '2024-07-01 11:19', '0987654321', 1, '202cb962ac59075b964b07152d234b70', 3, 0),
(4, 'user3@gmail.com', 'Nguyen Van C', '2024-07-15 09:06', '0987654321', 1, '202cb962ac59075b964b07152d234b70', 3, 0),
(5, 'taxi1@gmail.com', 'Taxi Xe Điện', '2024-07-17 09:00', '0987654321', 1, '202cb962ac59075b964b07152d234b70', 2, 1),
(6, 'taxi2@gmail.com', 'Taxi Xe Máy', '2024-07-17 09:00', '0987654322', 1, '202cb962ac59075b964b07152d234b70', 2, 2),
(7, 'taxi3@gmail.com', 'Taxi Xe Oto 4 chỗ', '2024-07-17 09:00', '0987654323', 1, '202cb962ac59075b964b07152d234b70', 2, 3),
(8, 'taxi4@gmail.com', 'Taxi Xe Oto 7 chỗ', '2024-07-17 09:00', '0987654324', 1, '202cb962ac59075b964b07152d234b70', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle`
--

CREATE TABLE `vehicle` (
  `id` int NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle`
--

INSERT INTO `vehicle` (`id`, `name`) VALUES
(1, 'Xe Điện'),
(2, 'Xe Máy'),
(3, 'Xe oto 4 chỗ'),
(4, 'Xe oto 7 chỗ');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_documents`
--

CREATE TABLE `vehicle_documents` (
  `id` int NOT NULL,
  `mobile` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `license` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `insurance` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_documents`
--

INSERT INTO `vehicle_documents` (`id`, `mobile`, `license`, `insurance`, `registration`) VALUES
(4, '0987654321', 'assets/img/license/0987654321_giay-phep-lai-xe.png', 'assets/img/insurance/0987654321_bao-hiem-xe.png', 'assets/img/registration/0987654321_dang-ky-xe.png'),
(5, '0987654322', 'assets/img/license/0987654322_giay-phep-lai-xe.png', 'assets/img/insurance/0987654322_bao-hiem-xe.png', 'assets/img/registration/0987654322_dang-ky-xe.png'),
(6, '0987654323', 'assets/img/license/0987654323_giay-phep-lai-xe.png', 'assets/img/insurance/0987654323_bao-hiem-xe.png', 'assets/img/registration/0987654323_dang-ky-xe.png'),
(7, '0987654324', 'assets/img/license/0987654324_giay-phep-lai-xe.png', 'assets/img/insurance/0987654324_bao-hiem-xe.png', 'assets/img/registration/0987654324_dang-ky-xe.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ride`
--
ALTER TABLE `ride`
  ADD PRIMARY KEY (`ride_id`),
  ADD KEY `id` (`customer_user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `vehicle`
--
ALTER TABLE `vehicle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_documents`
--
ALTER TABLE `vehicle_documents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ride`
--
ALTER TABLE `ride`
  MODIFY `ride_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vehicle`
--
ALTER TABLE `vehicle`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_documents`
--
ALTER TABLE `vehicle_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ride`
--
ALTER TABLE `ride`
  ADD CONSTRAINT `id` FOREIGN KEY (`customer_user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
