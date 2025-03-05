-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 06:54 PM
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
-- Database: `game`
--

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `id` int(11) NOT NULL,
  `felhasznalo_nev` varchar(150) NOT NULL,
  `felhasznalo_jel` varchar(8) NOT NULL,
  `felhasznalo_gmail` varchar(30) NOT NULL,
  `Szerep` int(11) NOT NULL,
  `aktív` tinyint(1) NOT NULL,
  `megerositve` tinyint(1) NOT NULL,
  `kod` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `felhasznalo`
--

INSERT INTO `felhasznalo` (`id`, `felhasznalo_nev`, `felhasznalo_jel`, `felhasznalo_gmail`, `Szerep`, `aktív`, `megerositve`, `kod`) VALUES
(1, 'Attila', 'Attila11', 'attila.hetes@gmail.com', 0, 1, 0, 2562),
(7, 'Gyula', 'Attila11', '72517552872@szily.hu', 0, 0, 0, 2467);

-- --------------------------------------------------------

--
-- Table structure for table `jelentes`
--

CREATE TABLE `jelentes` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `aktiv_bej` tinyint(1) NOT NULL,
  `uzenettema` varchar(250) NOT NULL,
  `dates` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jelentes`
--

INSERT INTO `jelentes` (`id`, `felhasznalo_id`, `aktiv_bej`, `uzenettema`, `dates`) VALUES
(1, 1, 1, 'Káromkodás', '2024-11-14');

-- --------------------------------------------------------

--
-- Table structure for table `kommentek`
--

CREATE TABLE `kommentek` (
  `id` int(11) NOT NULL,
  `szoveg` varchar(100) NOT NULL,
  `datum` datetime NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `hir_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kommentek`
--

INSERT INTO `kommentek` (`id`, `szoveg`, `datum`, `felhasznalo_id`, `hir_id`) VALUES
(1, 'Gyula és Attila Mester MIND\r\n', '2024-11-14 09:48:26', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `Menunev` varchar(150) NOT NULL,
  `tartalom` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `Menunev`, `tartalom`) VALUES
(1, 'Elso', 'asd'),
(2, 'masodik', 'asd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `felhasznalo_gmail` (`felhasznalo_gmail`);

--
-- Indexes for table `jelentes`
--
ALTER TABLE `jelentes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kommentek`
--
ALTER TABLE `kommentek`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `jelentes`
--
ALTER TABLE `jelentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kommentek`
--
ALTER TABLE `kommentek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
