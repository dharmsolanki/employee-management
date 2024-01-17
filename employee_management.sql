-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2024 at 03:33 PM
-- Server version: 8.0.35-0ubuntu0.20.04.1
-- PHP Version: 8.1.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1704878853, 1704878853);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `leave_type` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` text NOT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending' COMMENT '0=pending , 1=approve , 2=rejected',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `leave_applications`
--

INSERT INTO `leave_applications` (`id`, `user_id`, `leave_type`, `start_date`, `end_date`, `reason`, `status`, `created_at`) VALUES
(1, 5, 'sick', '2024-01-16', '2024-01-28', 'pet ma dukhe', '1', '2024-01-11 10:59:19'),
(2, 5, 'vacation', '2012-01-16', '1975-11-15', 'pet ma dukhe', '0', '2024-01-11 11:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1704696488),
('m130524_201442_init', 1704696491),
('m140506_102106_rbac_init', 1704878688),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1704878688),
('m180523_151638_rbac_updates_indexes_without_prefix', 1704878689),
('m190124_110200_add_verification_token_column_to_user_table', 1704696492),
('m200409_110543_rbac_update_mssql_trigger', 1704878690),
('m240109_062310_create_leave_applications_table', 1704781491);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` smallint NOT NULL DEFAULT '10',
  `created_at` int NOT NULL,
  `updated_at` int NOT NULL,
  `verification_token` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `verification_token`) VALUES
(1, 'admin', 'llQpo-PsHBn7wdWoS8d9je0BJqcxkP7E', '$2y$13$9.yYMcZpuW2QjL.OcCL8NONhE2er0YJwuel5H0r/f/.dMDXcSWlhW', NULL, 'admin@gmail.com', 10, 1704712626, 1704712657, 'nBKGnGrXR4KH_PeUTAyDSIdTtviSUEJC_1704712626'),
(2, 'kamal', 'JR1v83eTKcFwFWrXXildz7wMMZrKc5OX', '$2y$13$V3D6npF5hv28mk2h1FttH.96qC8hSRjt/HLkBAoQk/27.VLSJTVr2', NULL, 'kamal@gmail.com', 10, 1704712827, 1704712863, 'sGonVPlXM7ngRfFL7H76teE7XiyDujkb_1704712827'),
(3, 'vishwa', 'Hjaz_siahThOpw-5f_oR6sQgHSKG_fK5', '$2y$13$ofPSdzTZAiS/P9/E058V7.W3PnhNmK2WpBFisAEnITTwebpjAtdPq', 'TKlX9wXQL7manz80yKEtVNH23JNZpUZM_1704716676', 'vishwa@gmail.com', 10, 1704715988, 1704716676, '_QcymZsXStCCjWiGR7u_BqBJHNYl158r_1704715988'),
(4, 'zovas', 'Yu3vS4pbIuusbrhVnx5LY2o13fuxoKat', '$2y$13$lJAUL11OEAB0HrunKwr3L.qE4JRQtEpHkGaFAw4JDugLs29gTIGoK', NULL, 'berekeso@mailinator.com', 10, 1704716328, 1704716356, 'yzaEvsglooN00rTXTVbHXELaeQGiPnwk_1704716328'),
(5, 'jatin', 'MoQDS77vH5yLYWXu5gk1HPmQ3cpnLB_4', '$2y$13$j/g6GeU4ApMgW/TwSRv9iec/MzChIh4ziHwa/NHKMFa7TXj/VVa0O', NULL, 'jatin@example.com', 10, 1704716710, 1704717641, 'i-ql-ppQhw0G1pxNo38MFeGmrS3xNT4c_1704716710'),
(6, 'akshar', '5x_tjG5qgzo5fsM7wbCDUUe_RA4Sxgsb', '$2y$13$Ddde2Qpj/fmkMHd3TS0F7Oxht1.fLbEgh/cwVrM4XAgE1X8.IQrOu', NULL, 'akshar@gmail.com', 10, 1704716845, 1704716935, 'chuUm6c4eDs2geU8jZfaqRbRXgraZnXk_1704716845'),
(7, 'mehul', '_yVp5ZmAWSi2tz_2DHRnuXcfuI-gnvtu', '$2y$13$frXAcy26R7Yq7DI2GXw01e/U9abkIw.RBwl3Z.z0tN6hQG6lp8zni', NULL, 'mehul@gmail.com', 10, 1704717474, 1704717510, 'EcCm3ClDa8DFNEKRj8gOCJQUupUP4phV_1704717474'),
(8, 'wusise', 'gWtTPusPEUigxvVrIWlVWHCWMZppiGw-', '$2y$13$6H77m4TuS3yqixBzWxVTjO9a0r1G7tv7H0eF30BHz9USqq69jQcmG', NULL, 'qukuv@mailinator.com', 9, 1704717959, 1704717959, 'IoMcakMSHnmdPMnqowX7SkA48VHl-TRs_1704717959');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk-leave_applications-user_id` (`user_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD CONSTRAINT `fk-leave_applications-user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
