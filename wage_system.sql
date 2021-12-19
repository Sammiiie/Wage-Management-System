-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2021 at 08:28 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wage_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `message` longtext DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `compliant_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `message`, `date_sent`, `compliant_id`, `staff_id`) VALUES
(1, 'dsajdak', NULL, 1, 2),
(2, 'lkaksdaldj', '2021-12-09 00:00:00', 1, 2),
(3, 'asddd', '2021-12-09 04:10:00', 1, 2),
(4, 'lkdajalsdjsadajds', '2021-12-09 04:12:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `compliant`
--

CREATE TABLE `compliant` (
  `id` int(11) NOT NULL,
  `compliant_type` varchar(200) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `compliant`
--

INSERT INTO `compliant` (`id`, `compliant_type`, `message`, `staff_id`) VALUES
(1, 'Dancing is good', 'Would you dance with me?', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `firstname` varchar(60) DEFAULT NULL,
  `lastname` varchar(60) DEFAULT NULL,
  `staff_id` varchar(45) DEFAULT NULL,
  `designation` varchar(45) DEFAULT NULL,
  `password` varchar(800) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `firstname`, `lastname`, `staff_id`, `designation`, `password`) VALUES
(1, 'Samuel', 'Ejiga', '131QWSH', 'ADMIN', '$2y$10$szjDuLdZR5H15VIJekVEw.ODICtE.wlxkJEM8RYYrMqukB3zAv7GG'),
(2, 'Peter', 'Shallom', '152QWSH', 'STAFF', '$2y$10$.ZgI1CEtTwTF9gRvkw2x2uvOBVRpnzhIN3RTH.YVl1aai/.FqHeUe'),
(3, 'Dembe', 'Bitrus', '831QWSH', 'STAFF', '$2y$10$Q9vJDePgaIUnpiUUimLSRObkNV02GVOMiq9RTkl3bZj9eTKgLSHu.');

-- --------------------------------------------------------

--
-- Table structure for table `wages`
--

CREATE TABLE `wages` (
  `id` int(11) NOT NULL,
  `rate` decimal(19,2) DEFAULT NULL,
  `hours_worked` int(11) DEFAULT NULL,
  `pay` decimal(19,2) DEFAULT NULL,
  `day_worked` date DEFAULT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `wages`
--

INSERT INTO `wages` (`id`, `rate`, `hours_worked`, `pay`, `day_worked`, `staff_id`) VALUES
(2, '1000.00', 7, '7000.00', '2021-12-01', 2),
(3, '1000.00', 7, '7000.00', '2021-12-03', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comments_compliant1_idx` (`compliant_id`),
  ADD KEY `fk_comments_staff1_idx` (`staff_id`);

--
-- Indexes for table `compliant`
--
ALTER TABLE `compliant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_compliant_staff_idx` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wages`
--
ALTER TABLE `wages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_wages_staff1_idx` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `compliant`
--
ALTER TABLE `compliant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wages`
--
ALTER TABLE `wages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_compliant1` FOREIGN KEY (`compliant_id`) REFERENCES `compliant` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_comments_staff1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `compliant`
--
ALTER TABLE `compliant`
  ADD CONSTRAINT `fk_compliant_staff` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `wages`
--
ALTER TABLE `wages`
  ADD CONSTRAINT `fk_wages_staff1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
