-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2020 at 07:12 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bakedph`
--

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `date_creaed` timestamp NULL DEFAULT current_timestamp(),
  `userid` int(11) NOT NULL,
  `subscription` varchar(255) NOT NULL DEFAULT '6 Months'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `description`, `logo`, `date_creaed`, `userid`, `subscription`) VALUES
(3, 'user5store', NULL, NULL, '2020-10-10 13:23:37', 7, '3 Months'),
(4, 'user6store', NULL, NULL, '2020-10-10 13:31:49', 8, '1 Year'),
(5, 'test', NULL, NULL, '2020-10-11 02:54:50', 9, '6 Months'),
(6, 'jey', NULL, NULL, '2020-10-11 04:57:31', 18, '6 Months'),
(7, 'jeys', NULL, NULL, '2020-10-11 04:58:56', 18, '6 Months'),
(8, 'asdas', NULL, NULL, '2020-10-11 05:04:56', 18, '6 Months'),
(9, 'asdass', NULL, NULL, '2020-10-11 05:05:01', 18, '6 Months');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `usertype` varchar(255) NOT NULL DEFAULT 'basic',
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `usertype`, `verified`, `date_created`) VALUES
(1, 'user', 'aaaaaaaa', 'basic', 0, '2020-10-10 11:04:52'),
(2, 'dan', 'a', 'basic', 0, '2020-10-10 11:12:20'),
(3, 'user1', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-10 11:32:13'),
(4, 'user2', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-10 12:13:35'),
(5, 'user3', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-10 12:14:09'),
(6, 'user4', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-10 12:16:30'),
(7, 'user5', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-10 13:23:30'),
(8, 'user6', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-10 13:31:45'),
(9, 'TEST', '96e79218965eb72c92a549dd5a330112', 'basic', 0, '2020-10-11 00:38:42'),
(10, 'adsa', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:50:03'),
(11, 'sdfsdf', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:50:40'),
(12, 'asd', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:51:47'),
(13, 'asda', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:53:58'),
(14, 'asdsad', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:54:20'),
(15, 'asdasdas', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:54:41'),
(16, 'asfdsfs', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:55:46'),
(17, 'asdsada', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:56:28'),
(18, 'sdfsdfs', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'basic', 0, '2020-10-11 04:57:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
