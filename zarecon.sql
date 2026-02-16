-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 16, 2026 at 08:47 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ZARECON`
--

-- --------------------------------------------------------

--
-- Table structure for table `abstract_submissions`
--

CREATE TABLE `abstract_submissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(190) NOT NULL,
  `institution` varchar(190) NOT NULL,
  `abstract_title` varchar(255) NOT NULL,
  `file_original_name` varchar(255) NOT NULL,
  `file_stored_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_mime` varchar(100) NOT NULL,
  `file_size_bytes` bigint(20) UNSIGNED NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `abstract_submissions`
--

INSERT INTO `abstract_submissions` (`id`, `full_name`, `email`, `institution`, `abstract_title`, `file_original_name`, `file_stored_name`, `file_path`, `file_mime`, `file_size_bytes`, `ip_address`, `user_agent`, `created_at`) VALUES
(3, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_ Mapalo Chibwe- Developer & IT Support Officer.docx', '7224d567192ef5a76d81dfb473c91958.docx', 'uploads/abstracts/7224d567192ef5a76d81dfb473c91958.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 454088, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 06:50:40'),
(4, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_ Mapalo Chibwe- Developer & IT Support Officer.docx', '2ef88084255090211141ff7533a91d66.docx', 'uploads/abstracts/2ef88084255090211141ff7533a91d66.docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 454088, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 06:53:51'),
(5, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_  Developer & IT Support Officer.pdf', '460ae230381f38020259b4026b1ced32.pdf', 'uploads/abstracts/460ae230381f38020259b4026b1ced32.pdf', 'application/pdf', 228407, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 06:57:41'),
(6, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_  Developer & IT Support Officer.pdf', '6953a69b12e78ff0c53ededbefb046e3.pdf', 'uploads/abstracts/6953a69b12e78ff0c53ededbefb046e3.pdf', 'application/pdf', 228407, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 07:16:22'),
(7, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_  Developer & IT Support Officer.pdf', '8cc114fa0d0dfa12ca1b01781b50430c.pdf', 'uploads/abstracts/8cc114fa0d0dfa12ca1b01781b50430c.pdf', 'application/pdf', 228407, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 07:24:22'),
(8, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_  Developer & IT Support Officer.pdf', 'f724c4fd933154dac8c2dd6dede82a8a.pdf', 'uploads/abstracts/f724c4fd933154dac8c2dd6dede82a8a.pdf', 'application/pdf', 228407, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 07:29:05'),
(9, 'Ernest Lubinda', 'ernestlubinda1@gmail.com', 'Rideve Media', 'Test', 'Job Description_  Developer & IT Support Officer.pdf', '3214fc2ece1fcf991b9e225974fac03a.pdf', 'uploads/abstracts/3214fc2ece1fcf991b9e225974fac03a.pdf', 'application/pdf', 228407, '::1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', '2026-02-06 07:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE `papers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `paper_title` varchar(255) NOT NULL,
  `authors` text NOT NULL,
  `keywords` text NOT NULL,
  `track` varchar(100) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `agreement` tinyint(1) NOT NULL DEFAULT 0,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `papers`
--

INSERT INTO `papers` (`id`, `full_name`, `email`, `institution`, `phone`, `paper_title`, `authors`, `keywords`, `track`, `file_path`, `agreement`, `submitted_at`) VALUES
(1, 'Prof.James Nyierenda', 'Jamesnyierenda@gmail.com', 'UNZA', '+1 (415) 800-2020', 'The Effect of CFCs on the Atmosphere', 'Prof.James Nyrienda', 'Hydrogen', 'Climate Resilience', 'uploads/abstracts/2025-ICTAZ-Membership-Guide.pdf', 1, '2026-02-13 15:39:24'),
(2, 'Prof. Joan Mute', 'joan@unilus.co.za', 'University Of Lusaka', '0667459444', 'Understanding complex psycho-social issues amongst students in relation to young adult suicide', 'Prof. Joan Mute', 'Suicide', 'Energy Storage', 'uploads/abstracts/MEMORANDUM.pdf', 1, '2026-02-13 15:45:46'),
(3, 'Prof. Joan Mute', 'joan@unilus.co.za', 'University Of Lusaka', '0667459444', 'Understanding complex psycho-social issues amongst students in relation to young adult suicide', 'Prof. Joan Mute', 'Suicide', 'Energy Storage', 'uploads/abstracts/MEMORANDUM.pdf', 1, '2026-02-14 10:59:44'),
(4, 'Prof. Joan Mute', 'joan@unilus.co.za', 'University Of Lusaka', '0667459444', 'Understanding complex psycho-social issues amongst students in relation to young adult suicide', 'Prof. Joan Mute', 'Suicide', 'Energy Storage', 'uploads/abstracts/MEMORANDUM.pdf', 1, '2026-02-14 10:59:49'),
(5, 'Prof. Joan Mute', 'joan@unilus.co.za', 'University Of Lusaka', '0667459444', 'Understanding complex psycho-social issues amongst students in relation to young adult suicide', 'Prof. Joan Mute', 'Suicide', 'Energy Storage', 'uploads/abstracts/MEMORANDUM.pdf', 1, '2026-02-14 16:32:51');

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `institution` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `country` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `dietary` varchar(255) DEFAULT NULL,
  `accessibility` varchar(255) DEFAULT NULL,
  `agreement` tinyint(1) NOT NULL DEFAULT 0,
  `submitted_at` datetime DEFAULT current_timestamp(),
  `type` varchar(20) DEFAULT 'delegate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sponsor_registrations`
--

CREATE TABLE `sponsor_registrations` (
  `id` int(11) NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `package` varchar(100) NOT NULL,
  `additional_info` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `agreement` tinyint(1) NOT NULL DEFAULT 0,
  `submitted_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `institution` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `institution`) VALUES
(1, 'Mapalo Chibwe', 'mapalo@ridevemedia.com', '$2y$10$h06XKVP8uuzpd.CKiF.pPeC7FN58cIVyXVHIKOjvaoOwMpA4DsEEO', 'Rideve Media'),
(2, 'Ernest Lubinda', 'ernest@ridevemedia.com', '$2y$10$iENMuv.oBwmF46Do7HMIAezYs8gUjKMB.BhJ6uFJoMtSo1SEoO.ue', 'Rideve Media'),
(3, 'Natalie Thule', 'natalie@gmail.com', '$2y$10$RZ8Dv4MmbXDkQbs80xhfsOKHILKtZ/Kpf9Nr7ExeYypyU4vXay3/.', 'BeeInitiative'),
(4, 'Melinda Gates', 'melindagates@gmail.com', '$2y$10$uDCso5szyC73Pxpy71PUVO/FjXzci7cJp4AZhWlH3YsHUC8/HdBUi', 'Gates Foundation'),
(5, 'Lightning McQueen', 'Lightningm23@gmail.com', '$2y$10$BMvD2GQD33dPAiHiR2QSY.PA9GI7IfZ6H./6SFF3SiL.6Vdl9xEea', 'Fast Wheels'),
(6, 'Noah Singh', 'noahsingh@gmail.com', '$2y$10$4FlHk1G7mXYmRMFF4YYAjupgARTT.a3zktUwIlIPoskH6rCzMpmyK', 'Stranger Things'),
(7, 'Christopher Bwalya', 'Christopherb@yahoo.com', '$2y$10$ReHCauSPmozV14.h/x2VUOf3KKztsAOxwzC7qLV3c3lYwATU8uTqO', 'Radio Phoenix');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abstract_submissions`
--
ALTER TABLE `abstract_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Indexes for table `papers`
--
ALTER TABLE `papers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsor_registrations`
--
ALTER TABLE `sponsor_registrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abstract_submissions`
--
ALTER TABLE `abstract_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `papers`
--
ALTER TABLE `papers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sponsor_registrations`
--
ALTER TABLE `sponsor_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
