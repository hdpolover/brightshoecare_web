-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2022 at 07:37 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `pakaian`
--

CREATE TABLE `pakaian` (
  `id_pakaian` int(255) NOT NULL,
  `nama_pakaian` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pakaian`
--

INSERT INTO `pakaian` (`id_pakaian`, `nama_pakaian`) VALUES
(1, 'Jaket'),
(2, 'Kaos'),
(3, 'Celana'),
(4, 'Sprei'),
(5, 'Sarung'),
(6, 'Sajadah'),
(7, 'Selimut'),
(8, 'Baju'),
(9, 'Celana Panjang');

-- --------------------------------------------------------

--
-- Table structure for table `tarif`
--

CREATE TABLE `tarif` (
  `id_tarif` int(25) NOT NULL,
  `nama_tarif` varchar(255) NOT NULL,
  `waktu_tarif` text NOT NULL,
  `biaya_tarif` int(255) NOT NULL,
  `jenis_tarif` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tarif`
--

INSERT INTO `tarif` (`id_tarif`, `nama_tarif`, `waktu_tarif`, `biaya_tarif`, `jenis_tarif`) VALUES
(7, 'Cuci + Setrika (Biasa)', '3 hari', 5000, 'Kg'),
(9, 'Cuci + Setrika (Cepat)', '1 Hari', 8000, 'Kg'),
(11, 'Cuci + Setrika (Express)', '5 Jam', 6000, 'Kg'),
(14, 'Super Cepat', '1 Jam', 10000, 'Kg');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl_transaksi` varchar(255) DEFAULT NULL,
  `jam_transaksi` varchar(255) NOT NULL,
  `paket_transaksi` varchar(255) NOT NULL,
  `jenis_paket` enum('Kg','Satuan') NOT NULL,
  `berat_jumlah` double NOT NULL,
  `total_transaksi` int(50) NOT NULL,
  `status` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `nama`, `tgl_transaksi`, `jam_transaksi`, `paket_transaksi`, `jenis_paket`, `berat_jumlah`, `total_transaksi`, `status`) VALUES
('04062215064601', 'Pradita Aldi Setiawan', '04-06-2022', '15:06', 'Biasa (5000)', 'Kg', 3.4, 17000, 1),
('04062215172102', 'Sebastianus Aditya Narendra', '04-06-2022', '15:17', 'Express (8000)', 'Kg', 3, 24000, 0),
('16062213262703', 'Leonardo', '16-06-2022', '13:26', 'Super Cepat (10000)', 'Kg', 5, 50000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_detail`
--

CREATE TABLE `transaksi_detail` (
  `id_detail` varchar(255) DEFAULT NULL,
  `id_transaksi_d` varchar(255) NOT NULL,
  `nama_d` varchar(255) NOT NULL,
  `jumlah_d` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_detail`
--

INSERT INTO `transaksi_detail` (`id_detail`, `id_transaksi_d`, `nama_d`, `jumlah_d`) VALUES
(NULL, '04062215064601', 'Celana', 2),
(NULL, '04062215064601', 'Jaket', 1),
(NULL, '04062215172102', 'Jaket', 2),
(NULL, '16062213262703', 'Baju', 1),
(NULL, '16062213262703', 'Celana', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_status`
--

CREATE TABLE `transaksi_status` (
  `id_status` varchar(255) DEFAULT NULL,
  `id_transaksi_s` varchar(255) NOT NULL,
  `cuci` tinyint(4) NOT NULL,
  `kering` tinyint(4) NOT NULL,
  `strika` tinyint(4) NOT NULL,
  `siap` tinyint(4) NOT NULL,
  `selesai` tinyint(4) NOT NULL,
  `tgl_ambil` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi_status`
--

INSERT INTO `transaksi_status` (`id_status`, `id_transaksi_s`, `cuci`, `kering`, `strika`, `siap`, `selesai`, `tgl_ambil`) VALUES
(NULL, '04062215064601', 1, 1, 1, 1, 1, '04-06-2022'),
(NULL, '04062215172102', 1, 0, 0, 0, 0, '0'),
(NULL, '16062213262703', 1, 1, 1, 1, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(25) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `level`) VALUES
(2, 'Admin', 'admin', '$2y$10$O9D9MwhScesMyAquc.da2urhTTZmoRbcEPjiXw3gEuAr1MjJaJ28S', 1),
(7, 'Faris', 'faris', '$2y$10$O9D9MwhScesMyAquc.da2urhTTZmoRbcEPjiXw3gEuAr1MjJaJ28S', 1),
(9, 'Pradita Aldi Setiawan', 'pradita', '$2y$10$y24ayvgxz576.keflGQNZuDUcM6VB69jnt3VBM8uvp5kfJ3XQfpNW', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pakaian`
--
ALTER TABLE `pakaian`
  ADD PRIMARY KEY (`id_pakaian`);

--
-- Indexes for table `tarif`
--
ALTER TABLE `tarif`
  ADD PRIMARY KEY (`id_tarif`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pakaian`
--
ALTER TABLE `pakaian`
  MODIFY `id_pakaian` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tarif`
--
ALTER TABLE `tarif`
  MODIFY `id_tarif` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
