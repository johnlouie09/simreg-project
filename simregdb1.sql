-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2023 at 09:06 AM
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
-- Database: `simregdb1`
--

-- --------------------------------------------------------

--
-- Table structure for table `registrants`
--

CREATE TABLE `registrants` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `provider` varchar(10) NOT NULL,
  `mobile_number` bigint(20) NOT NULL,
  `date_of_birth` text NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `street` text NOT NULL,
  `date_registered` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registrants`
--

INSERT INTO `registrants` (`id`, `firstname`, `middlename`, `surname`, `gender`, `provider`, `mobile_number`, `date_of_birth`, `province`, `city`, `barangay`, `street`, `date_registered`) VALUES
(1, 'John Louie', 'Molina', 'Navales', 'Male', 'Globe', 9155106506, '2003-01-09', 'Camarines Sur', 'Buhi', 'San Antonio', 'Zone 3', '2023-06-26 19:34:10'),
(2, 'Jean', 'Baita', 'Ayen', 'Female', 'Globe', 9148374839, '2001-12-26', 'Camarines Sur', 'Nabua', 'Duran', 'Zone 7', '2023-06-26 17:59:40'),
(3, 'Kris Jane', 'Adoptante', 'Cabilan', 'Female', 'DITO', 9924857483, '2003-12-04', 'Camarines Sur', 'Buhi', 'San Isidro', 'Zone 3', '2023-06-26 17:59:56'),
(4, 'Felma', 'San Juan', 'Colico', 'Female', 'Globe', 9156784627, '2002-12-02', 'Camarines Sur', 'Nabua', 'Duran', 'Zone 6', '2023-06-26 18:00:06'),
(5, 'Rizaline', 'Bañaga', 'Bonilla', 'Female', 'DITO', 9917329754, '2002-12-30', 'Camarines Sur', 'Baao', 'Buluang (San Antonio)', 'St. Philip', '2023-06-26 19:31:40'),
(6, 'Apri Anne', 'Tabayag', 'Cadag', 'Female', 'TNT', 9385519445, '2001-04-30', 'Camarines Sur', 'Iriga City', 'Sta. Elena', 'Narra St.', '2023-06-26 19:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(5, 'admin', '$2y$10$XkChk8Pcb3BUwf92Ge2/6.fvup8ijcscC9PMVxz0kHebVEzUFIM4e', '2023-06-07 00:02:14'),
(7, 'riza', '$2y$10$7eskDPV0eNz0PXonlwzA3uvHU0aV9dY4mrgj0AjEzQluec84Iph9m', '2023-06-07 07:43:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `registrants`
--
ALTER TABLE `registrants`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registrants`
--
ALTER TABLE `registrants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
