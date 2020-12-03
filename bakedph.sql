-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2020 at 07:56 AM
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
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `id` int(11) NOT NULL,
  `materialid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `material_inventory`
--

CREATE TABLE `material_inventory` (
  `id` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` double NOT NULL,
  `expiry_date` date NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `material_inventory`
--

INSERT INTO `material_inventory` (`id`, `storeid`, `name`, `qty`, `price`, `expiry_date`, `date_created`) VALUES
(8, 21, 'material1', 191, 2, '0011-02-11', '2020-11-02 02:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `amount` float(10,2) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `payment_status` varchar(255) NOT NULL,
  `captured_at` datetime NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `payment_id`, `amount`, `currency`, `payment_status`, `captured_at`, `userid`) VALUES
(11, 'ch_1HuBIbJmfnsrzK57UqMzcfqG', 1800.00, 'PHP', 'Captured', '2020-12-03 15:28:21', 37),
(12, 'ch_1HuBMhJmfnsrzK5769NNWqzx', 1800.00, 'PHP', 'Captured', '2020-12-03 15:32:33', 37),
(13, 'ch_1HuBTwJmfnsrzK573SpNZBoV', 3000.00, 'PHP', 'Captured', '2020-12-03 15:40:03', 37);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `srp` float NOT NULL,
  `qty` int(11) NOT NULL,
  `expiry_date` date NOT NULL,
  `storeid` int(11) NOT NULL,
  `date_created` int(11) NOT NULL DEFAULT current_timestamp(),
  `status` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `srp`, `qty`, `expiry_date`, `storeid`, `date_created`, `status`) VALUES
(11, 'Cheese Cake', 2, 233, '1991-02-21', 21, 2147483647, 1),
(12, 'Fudgee Bar', 3, 33, '1991-02-22', 21, 2147483647, 1);

-- --------------------------------------------------------

--
-- Table structure for table `production`
--

CREATE TABLE `production` (
  `id` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `batchnumber` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date_produced` date NOT NULL,
  `storeid` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `production`
--

INSERT INTO `production` (`id`, `productid`, `batchnumber`, `quantity`, `date_produced`, `storeid`, `date_created`) VALUES
(6, 11, '23', 24, '2020-01-01', 21, '2020-11-06 11:14:26'),
(7, 11, '23', 23, '2020-01-22', 21, '2020-11-06 11:25:54'),
(8, 11, '23', 23, '2020-02-21', 21, '2020-11-06 11:27:24'),
(9, 12, '23', 23, '2020-02-21', 21, '2020-11-06 11:27:40'),
(10, 11, '23', 23, '2020-01-21', 21, '2020-11-06 11:27:47'),
(11, 12, '23', 23, '2020-01-21', 21, '2020-11-06 11:28:12'),
(12, 11, '23', 23, '2021-01-21', 21, '2020-11-06 13:09:40'),
(13, 12, '23', 23, '2021-01-21', 21, '2020-11-06 13:09:56'),
(14, 11, '23', 100, '2020-11-11', 21, '2020-11-06 15:15:46'),
(15, 11, '23', 120, '2020-12-11', 21, '2020-11-06 15:23:35'),
(16, 12, '23', 120, '2020-12-11', 21, '2020-11-06 15:23:38'),
(17, 12, '23', 120, '2020-11-11', 21, '2020-11-06 15:23:46'),
(18, 11, '23', 420, '2020-11-11', 21, '2020-11-06 15:23:57');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `vendorid` int(11) NOT NULL,
  `materialid` int(11) NOT NULL,
  `date_purchased` date NOT NULL,
  `type` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `storeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `vendorid`, `materialid`, `date_purchased`, `type`, `qty`, `date_created`, `storeid`) VALUES
(16, 1, 8, '2020-01-21', 'cash', 1, '2020-11-06 11:12:08', 21);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `storeid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `date_purchased` date NOT NULL,
  `other_details` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `storeid`, `productid`, `qty`, `date_purchased`, `other_details`, `date_created`) VALUES
(4, 21, 11, 22, '2020-02-21', '', '2020-11-06 14:34:32'),
(5, 21, 11, 22, '2020-01-21', '', '2020-11-06 14:34:36'),
(6, 21, 12, 224, '2020-01-21', '', '2020-11-06 14:34:41'),
(7, 21, 12, 2, '2020-02-21', '', '2020-11-06 14:34:49'),
(8, 21, 11, 23, '2020-12-01', '', '2020-11-06 16:03:01'),
(9, 21, 11, 534, '2020-11-01', '', '2020-11-06 16:03:26');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `logo`, `userid`) VALUES
(1, './uploads/logo/logo.png', 36);

-- --------------------------------------------------------

--
-- Table structure for table `slides`
--

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `photo` varchar(255) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `type` varchar(255) NOT NULL DEFAULT 'slide'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slides`
--

INSERT INTO `slides` (`id`, `title`, `content`, `status`, `photo`, `date_created`, `type`) VALUES
(9, 'Lorem ipsum dolor sit amet', 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 1, 'uploads/admin/banner6.jpg', '2020-11-08 12:04:17', 'slider'),
(10, 'Excepteur sint occaecat', 'Non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 1, 'uploads/admin/banner3.jpg', '2020-11-08 12:04:39', 'slider'),
(11, 'Promo #1', 'laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehen', 1, 'uploads/admin/banner1.jpg', '2020-11-08 12:06:34', 'news'),
(12, 'Promo #2', 'laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehen', 1, 'uploads/admin/banner5.png', '2020-11-08 12:06:40', 'news'),
(13, 'Promo #3', 'laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehen', 1, 'uploads/admin/banner4.jpg', '2020-11-08 12:06:45', 'news'),
(14, 'Promo Optional', 'laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehen', 0, 'uploads/admin/banner2.jpg', '2020-11-08 12:06:59', 'news');

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
  `subscriptionid` int(255) DEFAULT NULL,
  `last_payment_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`id`, `name`, `description`, `logo`, `date_creaed`, `userid`, `subscriptionid`, `last_payment_id`) VALUES
(20, 'jorjor', NULL, NULL, '2020-10-12 15:57:01', 36, 30, NULL),
(21, 'cyborg999', NULL, NULL, '2020-10-17 04:48:07', 37, 32, 'ch_1HuBTwJmfnsrzK573SpNZBoV'),
(22, 'User2 Store', NULL, NULL, '2020-11-29 14:50:17', 38, 32, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subscription`
--

CREATE TABLE `subscription` (
  `id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `cost` float NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1,
  `title` varchar(255) NOT NULL,
  `caption` varchar(255) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subscription`
--

INSERT INTO `subscription` (`id`, `duration`, `cost`, `active`, `title`, `caption`, `deleted`) VALUES
(24, 23, 2, 1, '1', '2', 1),
(25, 1, 1, 1, '1', '1', 1),
(26, 1, 1, 1, '1', '1', 1),
(27, 23, 23, 1, 'q', '3', 1),
(28, 234, 242, 1, '4', '2344', 1),
(29, 234, 324, 1, '34', '42', 1),
(30, 3, 600, 1, 'Plan #1', '3 Months', 0),
(31, 1, 800, 1, 'Plan #2', '1 Month', 0),
(32, 6, 500, 1, 'Plan #3', '6 Months', 0),
(33, 12, 450, 0, 'Plan #4', '1 Year', 0),
(34, 7, 550, 0, 'Plan #5', '7 Months', 0);

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
(36, 'admin', 'eed57216df3731106517ccaf5da2122d', 'admin', 0, '2020-10-12 15:56:55'),
(37, 'cyborg999', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 0, '2020-10-17 04:48:06'),
(38, 'user2', '5c07f19fdd6ce3b1a588f71d11ee2b23', 'basic', 1, '2020-11-29 14:50:17');

-- --------------------------------------------------------

--
-- Table structure for table `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userinfo`
--

INSERT INTO `userinfo` (`id`, `fullname`, `address`, `contact`, `email`, `bday`, `date_created`, `userid`) VALUES
(2, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '09287655606', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '0000-00-00', '2020-10-12 15:56:56', 36),
(3, 'Jordan Sadiwa', '1852 Sandejas Pasay City', '09287655606', 'JORDAN-E14NWI096B87359TFWN@TEST.INFO', '0000-00-00', '2020-10-17 04:48:06', 37),
(15, NULL, NULL, NULL, NULL, NULL, '2020-11-29 14:50:17', 38);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `storeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `address`, `contact`, `date_created`, `storeid`) VALUES
(1, 'Jordan Sadiwa', '1852 Sandejas Pasay City', 2342342, '2020-10-17 11:17:37', 21),
(3, 'test345', '345', 234, '2020-10-17 11:20:20', 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `material_inventory`
--
ALTER TABLE `material_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `production`
--
ALTER TABLE `production`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slides`
--
ALTER TABLE `slides`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscription`
--
ALTER TABLE `subscription`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `material_inventory`
--
ALTER TABLE `material_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `production`
--
ALTER TABLE `production`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `slides`
--
ALTER TABLE `slides`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `subscription`
--
ALTER TABLE `subscription`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
