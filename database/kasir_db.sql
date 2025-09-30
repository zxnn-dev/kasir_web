-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 30, 2025 at 03:10 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_pembelian`
--

CREATE TABLE `detail_pembelian` (
  `detail_id` int(11) NOT NULL,
  `pembelian_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pembelian`
--

INSERT INTO `detail_pembelian` (`detail_id`, `pembelian_id`, `produk_id`, `jumlah`, `harga`) VALUES
(1, 1, 2, 22, 2000.00),
(2, 2, 6, 100, 1500.00),
(3, 3, 9, 12, 5000.00);

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `detail_id` int(11) NOT NULL,
  `penjualan_id` int(11) DEFAULT NULL,
  `produk_id` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penjualan`
--

INSERT INTO `detail_penjualan` (`detail_id`, `penjualan_id`, `produk_id`, `jumlah`, `subtotal`) VALUES
(1, 1, 1, 1, 3500.00),
(2, 2, 1, 1, 3500.00),
(3, 3, 1, 3, 10500.00),
(4, 3, 2, 3, 15000.00),
(5, 3, 3, 3, 21000.00),
(6, 3, 4, 3, 90000.00),
(7, 4, 1, 5, 17500.00),
(8, 4, 2, 5, 25000.00),
(9, 4, 3, 5, 35000.00),
(10, 4, 4, 5, 150000.00),
(11, 4, 5, 5, 10000.00),
(12, 4, 6, 5, 10000.00),
(13, 4, 7, 5, 175000.00),
(14, 4, 8, 1, 2000.00),
(15, 4, 9, 5, 20000.00),
(16, 6, 1, 1, 3500.00),
(17, 6, 2, 1, 5000.00),
(18, 6, 3, 1, 7000.00),
(19, 6, 4, 1, 30000.00),
(20, 6, 5, 1, 2000.00),
(21, 6, 6, 1, 2000.00),
(22, 6, 7, 1, 35000.00),
(23, 6, 9, 1, 4000.00),
(24, 7, 1, 1, 3500.00),
(25, 7, 2, 1, 5000.00),
(26, 7, 3, 1, 7000.00),
(27, 7, 4, 1, 30000.00),
(28, 7, 5, 1, 2000.00),
(29, 7, 6, 1, 2000.00),
(30, 7, 7, 1, 35000.00),
(31, 7, 9, 1, 4000.00),
(32, 8, 1, 1, 3500.00),
(33, 8, 2, 1, 5000.00),
(34, 9, 5, 1, 2000.00),
(35, 9, 6, 1, 2000.00),
(36, 10, 1, 1, 3500.00),
(37, 10, 2, 3, 15000.00),
(38, 12, 9, 1, 4000.00),
(39, 14, 1, 5, 17500.00),
(40, 15, 4, 1, 30000.00),
(41, 16, 1, 1, 3500.00),
(42, 16, 2, 3, 15000.00),
(43, 17, 1, 4, 14000.00),
(44, 17, 2, 5, 25000.00),
(45, 18, 1, 3, 10500.00),
(46, 18, 2, 12, 60000.00),
(47, 19, 2, 2, 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `member_id` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `poin` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `nama`, `nik`, `no_hp`, `email`, `alamat`, `poin`) VALUES
('MBR0001', 'zxx', '12345', '122333', 'a@gmail.com', 'aaaa', 1),
('MBR0002', 'zxx', '12345', '122333', 'a@gmail.com', 'aaaa', 0),
('MBR0003', 'w', 'w', 'w', 'a@gmail.com', 'w', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `pembelian_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`pembelian_id`, `user_id`, `tanggal`, `total_harga`) VALUES
(1, 1, '2025-09-10 09:02:05', 44000.00),
(2, 1, '2025-09-10 09:04:16', 150000.00),
(3, 11, '2025-09-30 13:52:41', 60000.00);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `penjualan_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`penjualan_id`, `user_id`, `tanggal`, `total_harga`) VALUES
(1, 1, '2025-09-10 03:35:41', 3500.00),
(2, 1, '2025-09-10 03:35:53', 3500.00),
(3, 2, '2025-09-10 03:55:35', 136500.00),
(4, 11, '2025-09-30 08:53:55', 444500.00),
(5, 13, '2025-09-30 12:59:45', 0.00),
(6, 13, '2025-09-30 13:04:04', 88500.00),
(7, 13, '2025-09-30 13:05:14', 88500.00),
(8, 13, '2025-09-30 13:05:27', 8500.00),
(9, 13, '2025-09-30 13:07:26', 4000.00),
(10, 13, '2025-09-30 13:09:11', 18500.00),
(11, 13, '2025-09-30 13:18:12', 0.00),
(12, 13, '2025-09-30 13:20:25', 4000.00),
(13, 13, '2025-09-30 13:23:54', 0.00),
(14, 13, '2025-09-30 13:27:01', 17500.00),
(15, 13, '2025-09-30 13:44:36', 30000.00),
(16, 13, '2025-09-30 13:51:37', 18500.00),
(17, 13, '2025-09-30 13:54:24', 39000.00),
(18, 13, '2025-09-30 13:54:39', 70500.00),
(19, 13, '2025-09-30 14:02:17', 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produk_id`, `nama_produk`, `harga`, `stok`) VALUES
(1, 'Indomie Goreng', 3500.00, 73),
(2, 'Teh Botol Sosro', 5000.00, 36),
(3, 'Roti Coklat', 7000.00, 20),
(4, 'beras', 30000.00, 89),
(5, 'susu', 2000.00, 92),
(6, 'gelas', 2000.00, 92),
(7, '1', 35000.00, 88),
(8, '1', 2000.00, 0),
(9, 'teh', 4000.00, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nik` int(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `poin` int(11) DEFAULT 0,
  `role` enum('admin','petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nik`, `email`, `username`, `password`, `poin`, `role`) VALUES
(10, 1, 'zzz@gmail.com', 'z', '202cb962ac59075b964b07152d234b70', 0, ''),
(11, 2147483647, 'a@gmail.com', 'admin1', '81dc9bdb52d04dc20036dbd8313ed055', 0, 'admin'),
(13, 112, '1@gmail.com', 'admin', '202cb962ac59075b964b07152d234b70', 8, 'admin'),
(16, 1234567890, 'admin@example.com', 'adminn', '$2y$10$EgQ1PJIeV6w9Ut3B.acaH.TOu0SrRbe3O/e82UEvzAaCpjdkyp/2S', 0, 'admin'),
(19, 12223, 'w@gmail.com', 'zhafran', '$2y$10$1HGUhiC//AGflK1omLlHCOfLBBbdv9yaXA4jHpGqwmHTIpFfwZjWq', 0, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `pembelian_id` (`pembelian_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `penjualan_id` (`penjualan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`pembelian_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`penjualan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `pembelian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `penjualan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pembelian`
--
ALTER TABLE `detail_pembelian`
  ADD CONSTRAINT `detail_pembelian_ibfk_1` FOREIGN KEY (`pembelian_id`) REFERENCES `pembelian` (`pembelian_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_pembelian_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`penjualan_id`) REFERENCES `penjualan` (`penjualan_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
