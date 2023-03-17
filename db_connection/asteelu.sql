-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 25, 2021 at 04:03 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `asteelu`
--

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_about`
--

CREATE TABLE `asteelu_about` (
  `about_id` int(11) NOT NULL,
  `about_info` text NOT NULL,
  `about_street1` varchar(250) NOT NULL,
  `about_street2` varchar(250) NOT NULL,
  `about_country` varchar(250) NOT NULL,
  `about_state` varchar(250) NOT NULL,
  `about_city` varchar(250) NOT NULL,
  `about_phone` varchar(20) NOT NULL,
  `about_email` varchar(250) NOT NULL,
  `about_phone2` varchar(20) NOT NULL,
  `about_fax` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asteelu_about`
--

INSERT INTO `asteelu_about` (`about_id`, `about_info`, `about_street1`, `about_street2`, `about_country`, `about_state`, `about_city`, `about_phone`, `about_email`, `about_phone2`, `about_fax`) VALUES
(1, '&lt;p&gt;tijani Lorem moro dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. tijani Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation &lt;strong&gt;ullamco &lt;/strong&gt;laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. wsf&lt;/p&gt;', '123 6th St. ', 'FL 32904', 'USA', 'Oregon', 'Melbourne', '+1 234 567 89', 'info@asteelu.com', '+1 234 567 999', '+1 234 567 89');

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_admin`
--

CREATE TABLE `asteelu_admin` (
  `admin_id` int(11) NOT NULL,
  `admin_fullname` varchar(255) NOT NULL,
  `admin_email` varchar(175) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_joined_date` datetime NOT NULL DEFAULT current_timestamp(),
  `admin_last_login` datetime DEFAULT NULL,
  `admin_permissions` varchar(255) NOT NULL,
  `admin_trash` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `asteelu_admin`
--

INSERT INTO `asteelu_admin` (`admin_id`, `admin_fullname`, `admin_email`, `admin_password`, `admin_joined_date`, `admin_last_login`, `admin_permissions`, `admin_trash`) VALUES
(1, 'serwaa nyaako', 'admin@asteelu.com', '$2y$10$YisQySADJR3ZPrlg.Tezt.1WxV/fqoMYSr902u6DN.Dah8xhpLnR2', '2020-02-21 21:01:31', '2021-12-25 02:11:44', 'admin,editor', 0),
(3, 'mohammed amin', 'mohammed@asteelu.com', '$2y$10$YisQySADJR3ZPrlg.Tezt.1WxV/fqoMYSr902u6DN.Dah8xhpLnR2', '2021-12-17 13:03:14', '2021-12-17 22:02:36', 'editor', 1),
(4, 'mohammed amin', 'mohammed@email.com', '$2y$10$YisQySADJR3ZPrlg.Tezt.1WxV/fqoMYSr902u6DN.Dah8xhpLnR2', '2021-12-18 10:41:24', '2021-12-19 01:26:15', 'editor', 0),
(5, 'wadud umar', 'as@astewelu.com', '$2y$10$YisQySADJR3ZPrlg.Tezt.1WxV/fqoMYSr902u6DN.Dah8xhpLnR2', '2021-12-18 10:42:24', NULL, 'editor', 0),
(6, 'kjegvnkj', 'kjdnvdkj@sfgrd.com', 'we8YfQAXdm9dqnv', '2021-12-23 12:25:36', NULL, 'editor', 1),
(7, 'kjnkjrenj', 'qkjlnvfkjn@ffer.com', 'password', '2021-12-23 12:27:55', NULL, 'editor', 1),
(8, 'jkfn', 'df@efew.com', 'we8YfQAXdm9dqnv', '2021-12-23 12:29:05', NULL, 'admin,editor', 1),
(9, 'fkjgnkjn', 'jknwkfjdnj@efrew.com', 'password', '2021-12-23 12:37:43', NULL, 'editor', 1);

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_cart`
--

CREATE TABLE `asteelu_cart` (
  `cart_id` int(11) NOT NULL,
  `items` text NOT NULL,
  `expire_date` datetime NOT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT 0,
  `shipped` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_category`
--

CREATE TABLE `asteelu_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(200) NOT NULL,
  `category_added_date` datetime NOT NULL DEFAULT current_timestamp(),
  `category_trash` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_contact`
--

CREATE TABLE `asteelu_contact` (
  `contact_id` int(11) NOT NULL,
  `contact_firstname` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_subject` varchar(500) NOT NULL,
  `contact_message` text NOT NULL,
  `contact_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_product`
--

CREATE TABLE `asteelu_product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_category` int(11) DEFAULT NULL,
  `product_list_price` decimal(10,2) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_threshold` int(11) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_added_by` int(11) DEFAULT NULL,
  `product_added_date` datetime DEFAULT current_timestamp(),
  `product_featured` tinyint(4) NOT NULL DEFAULT 0,
  `product_trash` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_subscription`
--

CREATE TABLE `asteelu_subscription` (
  `subscription_id` int(11) NOT NULL,
  `subscription_email` varchar(255) NOT NULL,
  `subscription_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_transaction`
--

CREATE TABLE `asteelu_transaction` (
  `transaction_id` int(11) NOT NULL,
  `transaction_charge_id` varchar(255) NOT NULL,
  `transaction_cart_id` int(11) NOT NULL,
  `transaction_user_id` int(11) NOT NULL,
  `transaction_full_name` varchar(255) NOT NULL,
  `transaction_email` varchar(255) NOT NULL,
  `transaction_street` varchar(255) NOT NULL,
  `transaction_street2` varchar(255) NOT NULL,
  `transaction_company` varchar(255) NOT NULL,
  `transaction_country` varchar(255) NOT NULL,
  `transaction_state` varchar(255) NOT NULL,
  `transaction_city` varchar(255) NOT NULL,
  `transaction_postcode` varchar(50) NOT NULL,
  `transaction_phone` varchar(20) NOT NULL,
  `transaction_sub_total` decimal(10,2) NOT NULL,
  `transaction_tax` decimal(10,2) NOT NULL,
  `transaction_grand_total` decimal(10,2) NOT NULL,
  `transaction_description` text NOT NULL,
  `transaction_type` varchar(255) NOT NULL,
  `transaction_txn_date` datetime NOT NULL DEFAULT current_timestamp(),
  `transaction_shipped_product_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_user`
--

CREATE TABLE `asteelu_user` (
  `user_id` int(11) NOT NULL,
  `user_fullname` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_phone` varchar(50) DEFAULT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_country` varchar(255) DEFAULT NULL,
  `user_state` varchar(225) DEFAULT NULL,
  `user_city` varchar(225) DEFAULT NULL,
  `user_address` varchar(255) DEFAULT NULL,
  `user_address2` varchar(255) NOT NULL,
  `user_postcode` varchar(50) NOT NULL,
  `user_company` varchar(255) NOT NULL,
  `user_verified` tinyint(1) DEFAULT 0,
  `user_vericode` varchar(50) NOT NULL,
  `user_joined_date` datetime NOT NULL DEFAULT current_timestamp(),
  `user_last_login` datetime DEFAULT NULL,
  `user_trash` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `asteelu_user_password_resets`
--

CREATE TABLE `asteelu_user_password_resets` (
  `password_reset_id` int(11) NOT NULL,
  `password_reset_created_at` datetime DEFAULT NULL,
  `password_reset_user_id` int(11) NOT NULL,
  `password_reset_verify` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asteelu_about`
--
ALTER TABLE `asteelu_about`
  ADD PRIMARY KEY (`about_id`);

--
-- Indexes for table `asteelu_admin`
--
ALTER TABLE `asteelu_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `asteelu_cart`
--
ALTER TABLE `asteelu_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`items`(768)),
  ADD KEY `expire_date` (`expire_date`) USING BTREE,
  ADD KEY `paid` (`paid`) USING BTREE;

--
-- Indexes for table `asteelu_category`
--
ALTER TABLE `asteelu_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `category_name` (`category_name`),
  ADD KEY `category_added_date` (`category_added_date`);

--
-- Indexes for table `asteelu_contact`
--
ALTER TABLE `asteelu_contact`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `contact_firstname` (`contact_firstname`),
  ADD KEY `contact_email` (`contact_email`),
  ADD KEY `contact_subject` (`contact_subject`),
  ADD KEY `contact_date` (`contact_date`);

--
-- Indexes for table `asteelu_product`
--
ALTER TABLE `asteelu_product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_name` (`product_name`),
  ADD KEY `product_category` (`product_category`),
  ADD KEY `product_price` (`product_price`),
  ADD KEY `product_added_date` (`product_added_date`),
  ADD KEY `product_added_by` (`product_added_by`),
  ADD KEY `product_list_price` (`product_list_price`),
  ADD KEY `product_threshold` (`product_threshold`),
  ADD KEY `product_quantity` (`product_quantity`) USING BTREE;

--
-- Indexes for table `asteelu_subscription`
--
ALTER TABLE `asteelu_subscription`
  ADD PRIMARY KEY (`subscription_id`);

--
-- Indexes for table `asteelu_transaction`
--
ALTER TABLE `asteelu_transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `transaction_user_id` (`transaction_user_id`);

--
-- Indexes for table `asteelu_user`
--
ALTER TABLE `asteelu_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_phone` (`user_phone`),
  ADD KEY `user_country` (`user_country`),
  ADD KEY `user_state` (`user_state`),
  ADD KEY `user_trash` (`user_trash`),
  ADD KEY `user_fullname` (`user_fullname`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `user_postcode` (`user_postcode`),
  ADD KEY `user_company` (`user_company`),
  ADD KEY `user_city` (`user_city`) USING BTREE;

--
-- Indexes for table `asteelu_user_password_resets`
--
ALTER TABLE `asteelu_user_password_resets`
  ADD PRIMARY KEY (`password_reset_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asteelu_about`
--
ALTER TABLE `asteelu_about`
  MODIFY `about_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asteelu_admin`
--
ALTER TABLE `asteelu_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `asteelu_cart`
--
ALTER TABLE `asteelu_cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_category`
--
ALTER TABLE `asteelu_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_contact`
--
ALTER TABLE `asteelu_contact`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_product`
--
ALTER TABLE `asteelu_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_subscription`
--
ALTER TABLE `asteelu_subscription`
  MODIFY `subscription_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_transaction`
--
ALTER TABLE `asteelu_transaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_user`
--
ALTER TABLE `asteelu_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `asteelu_user_password_resets`
--
ALTER TABLE `asteelu_user_password_resets`
  MODIFY `password_reset_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
