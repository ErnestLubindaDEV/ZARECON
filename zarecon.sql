-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 09, 2026 at 08:37 AM
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
-- Database: `zarecon`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abstract_submissions`
--
ALTER TABLE `abstract_submissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
