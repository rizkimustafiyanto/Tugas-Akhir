-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2022 at 10:28 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbao`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `no_antrian` varchar(12) NOT NULL,
  `waktu` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  `id_poli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id`, `no_antrian`, `waktu`, `status`, `id_poli`) VALUES
(117, 'E001', '2022-10-17 16:17:46', 'Dilewati', '5'),
(118, 'E002', '2022-10-17 16:17:48', 'Dilewati', '5'),
(119, 'E003', '2022-10-17 16:47:02', 'Selesai', '5'),
(122, 'A001', '2022-10-18 18:46:14', 'Dilayani', '1'),
(123, 'A002', '2022-10-18 18:46:16', 'Dilewati', '1'),
(124, 'A003', '2022-10-18 18:46:18', 'Selesai', '1'),
(127, 'A001', '2022-10-19 09:39:07', 'Dilayani', '1');

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id_dokter` char(10) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `jk` varchar(100) NOT NULL,
  `spesialis` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id_dokter`, `nama`, `jk`, `spesialis`) VALUES
('1', 'Dr.Andre A', 'Pria', 'Bedah'),
('2', 'Rizki', 'Pria', 'Syaraf'),
('3', 'Khusnul', 'Wanita', 'Umum'),
('4', 'Dr. Fira', 'Wanita', 'Ortopedi');

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id_poli` char(10) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `deskripsi` varchar(225) NOT NULL,
  `loket` varchar(225) NOT NULL,
  `id_dokter` char(10) NOT NULL,
  `statu` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id_poli`, `nama`, `deskripsi`, `loket`, `id_dokter`, `statu`) VALUES
('1', 'ANAK & TUMBUH KEMBANG', '', 'A', '1', '1'),
('10', 'JANTUNG & PEMBULUH DARAH', '', 'J', '1', '1'),
('11', 'ORTHOPEDI', '', 'K', '1', '1'),
('12', 'KULIT & KELAMIN', '', 'L', '1', '1'),
('13', 'BEDAH SYARAF', '', 'M', '1', '1'),
('14', 'BEDAH PLASTIK', '', 'N', '1', '1'),
('15', 'UROLOGI', '', 'O', '1', '1'),
('16', 'PSIKOLOGI', '', 'P', '1', '1'),
('17', 'KESEHATAN JIWA', '', 'Q', '1', '1'),
('18', 'KESEHATAN', '', 'R', '1', '1'),
('19', 'VCT', '', 'S', '1', '1'),
('2', 'DALAM', '', 'B', '1', '1'),
('20', 'MEDHICAL CHECK UP', '', 'T', '3', '1'),
('3', 'OBSTETRI & GINEKOLOGI', '', 'C', '1', '1'),
('4', 'BEDAH', '', 'D', '1', '1'),
('5', 'GIGI', '', 'E', '1', '1'),
('6', 'MATA', '', 'F', '1', '1'),
('7', 'THT', '', 'G', '1', '1'),
('8', 'SYARAF', '', 'H', '1', '1'),
('9', 'PARU', '', 'I', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(225) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `level` varchar(20) NOT NULL,
  `id_poli` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `password`, `level`, `id_poli`) VALUES
(1, 'Andre', 'admin', '123456', '1', ''),
(2, 'Siska', 'siska', '123456', '2', '1'),
(3, 'Ajis', 'ajis', '123456', '2', '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_poli` (`id_poli`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id_poli`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_poli` (`id_poli`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_ibfk_1` FOREIGN KEY (`id_poli`) REFERENCES `poli` (`id_poli`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `poli`
--
ALTER TABLE `poli`
  ADD CONSTRAINT `poli_ibfk_1` FOREIGN KEY (`id_dokter`) REFERENCES `dokter` (`id_dokter`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
