-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 08:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `paywallet_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `admin_id` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `admin_id`, `password`, `created_at`, `token`) VALUES
(1, 'admin1', '$2y$10$WSyJvo6GvoAWaWAuRwLPSO5GNlpVupHpKzD60y56x74kFX87tV3GK', '2025-03-04 09:47:03', ''),
(2, 'admin2', '$2y$10$Et4jl/B1A1VgUKvco5yEj.qYSn42nfZC3OpOhtW.E2kN7/5iYzi6O', '2025-03-04 09:47:03', '');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `type` enum('deposit','withdrawal','transfer') NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `currency` enum('USD','LBP') NOT NULL,
  `status` enum('pending','completed','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verification_status` enum('unverified','individual','corporate') DEFAULT 'unverified',
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`, `verification_status`, `token`) VALUES
(1, 'user1', 'user1@example.com', 100000001, '$2y$10$YdSCDdjRD4r46Xaw19txf.aosMK8oIPaX66zGVlG/O5E4t6XtP.iK', '2025-03-04 11:23:35', 'individual', ''),
(2, 'user2', 'user2@example.com', 100000002, '$2y$10$Dpi2HCGiMueLLO/WonbUOeZ39YbhCvDfArruzG/qWI6srpEFH9QWO', '2025-03-04 11:23:35', 'corporate', ''),
(3, 'user3', 'user3@example.com', 100000003, '$2y$10$5fKyjDSyUqaKPc2o8Z7vyeuF9BwD5SExpDyQMjsXN65T4g87CH4n2', '2025-03-04 11:23:35', 'unverified', ''),
(4, 'user4', 'user4@example.com', 100000004, '$2y$10$A6Y4D8NIq9J01uzjXx4Gme0Pyyqskb2gARFz1DPs7.u3eJ9GT7MVW', '2025-03-04 11:23:35', 'individual', ''),
(5, 'user5', 'user5@example.com', 100000005, '$2y$10$hvxRrJuKne/X0eHA8J13E.RURX83YMBoLPu45WnmT4cTEEBnQBZq2', '2025-03-04 11:23:35', 'corporate', ''),
(8, 'ahmad', 'ahmad@gmail.com', 12345678, '12345678', '2025-03-04 22:41:30', 'unverified', ''),
(11, NULL, 'salim@gmzil.com', 10000001, '$2y$10$251NVkNT/7PA8SH80K8q8u8QWCN0mE6cWqtXKeuowLMIebZLOvSjK', '2025-03-04 23:42:07', 'unverified', ''),
(12, NULL, 'nancy%gmail.com', 2333999, '$2y$10$gZ577di4Bb.6xj026KZtxulv6iBN/Nj9bVda6BOHyTJ6.KsKJpGu.', '2025-03-04 23:46:18', 'unverified', '09d74920299e5f1e50b8869c328c81d7d5fe7688b645833905d75745b8c97f2f'),
(13, NULL, 'nancy@gmail.com', 1222233, '$2y$10$EqdbDhc.NfMU9TQNeTsxM.tfrzIQcPgEjcfr.2x/.529xtYlFfhKW', '2025-03-04 23:51:19', 'unverified', '00a3aad5c40b3c88848f8089b9a20641e66d43c3d6849d150014504e678a29aa'),
(14, NULL, 'test@example.com', 122223366, '$2y$10$vw4jFbPEKZhGywDrJbTZLeW/W/6McSsFQN7vNQ51yxRKakyM/6LHS', '2025-03-05 14:34:31', 'unverified', '933c025081685ce0b7bf0d8778fcb86d311dbe68a75ea8afedac578ca4f2febd'),
(15, NULL, '', 0, '$2y$10$i2TzD42dIhVYLeacuZcOM.XZahb5REKJGrr2oDsJbZ0cwvk20XYua', '2025-03-05 17:27:57', 'unverified', 'e09a8871b66baa135ba18625636a93525efd5f2b47a2123823bfafe663329495'),
(16, 'salim darwish', 'salim@gmail.com', 81787988, '$2y$10$dpaCkKdCJfkkbpQbgZaQAOIhJxJyetpskp4gJ8M/WkKON7iIRXerW', '2025-03-05 17:36:36', 'individual', '4f034ba687caab2d27eda1d4ed85868f71cf447b8c2aa742ea604963e35336c4');

-- --------------------------------------------------------

--
-- Table structure for table `wallets`
--

CREATE TABLE `wallets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `currency` enum('USD','LBP') NOT NULL,
  `balance` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wallets`
--

INSERT INTO `wallets` (`id`, `user_id`, `currency`, `balance`) VALUES
(1, 1, 'USD', 152.20),
(2, 1, 'LBP', 10988000.00),
(3, 2, 'USD', 2400.00),
(4, 2, 'LBP', 300985000.00),
(5, 3, 'USD', 0.00),
(6, 3, 'LBP', 0.00),
(7, 4, 'USD', 264.00),
(8, 4, 'LBP', 0.00),
(9, 5, 'USD', 1588.00),
(10, 5, 'LBP', 134555000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_id` (`admin_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `wallets`
--
ALTER TABLE `wallets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `wallets`
--
ALTER TABLE `wallets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `wallets` (`id`);

--
-- Constraints for table `wallets`
--
ALTER TABLE `wallets`
  ADD CONSTRAINT `wallets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
