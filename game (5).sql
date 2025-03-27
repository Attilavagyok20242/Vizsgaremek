-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 27, 2025 at 08:55 AM
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
-- Table structure for table `bejelentesek`
--

CREATE TABLE `bejelentesek` (
  `id` int(11) NOT NULL,
  `cim` varchar(255) NOT NULL,
  `leiras` text NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bejelentesek`
--

INSERT INTO `bejelentesek` (`id`, `cim`, `leiras`, `felhasznalo_id`, `datum`) VALUES
(1, 'Káromkodás', 'Ez a felhasználó káromkodott', 1, '2025-03-09 12:39:54');

-- --------------------------------------------------------

--
-- Table structure for table `deleted_users`
--

CREATE TABLE `deleted_users` (
  `id` int(11) NOT NULL,
  `nev` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `torles_idopont` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_users`
--

INSERT INTO `deleted_users` (`id`, `nev`, `email`, `torles_idopont`) VALUES
(199, 'Attila', 'attila.hetes@gmail.com', '2025-03-17 09:09:43'),
(200, 'Gyula', 'ricsigyula6@gmail.com', '2025-03-17 13:53:10'),
(201, 'Attila', 'attila.hetes@gmail.com', '2025-03-17 13:53:29'),
(202, 'Attila2', '72517552872@szily.hu', '2025-03-17 10:37:01'),
(203, 'Attila2', '72517552872@szily.hu', '2025-03-17 12:47:39'),
(204, 'Attila2', '72517552872@szily.hu', '2025-03-17 13:53:29'),
(205, 'Szlej', '72377700971@szily.hu', '2025-03-17 13:53:29'),
(206, 'attila', 'attila.hetes@gmail.com', '2025-03-20 08:04:36');

-- --------------------------------------------------------

--
-- Table structure for table `felhasznalo`
--

CREATE TABLE `felhasznalo` (
  `id` int(11) NOT NULL,
  `nev` varchar(255) NOT NULL,
  `jelszo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `aktív` tinyint(1) NOT NULL,
  `Szerep` tinyint(1) NOT NULL,
  `megerositve` tinyint(1) NOT NULL,
  `kod` int(11) NOT NULL,
  `datum` date NOT NULL,
  `utolso_bejelentkezes` datetime DEFAULT NULL,
  `utoljara_hasznalt_ip` varchar(45) DEFAULT NULL,
  `elrontott_bejelenkezes` int(11) DEFAULT 0,
  `profilkep` varchar(255) NOT NULL DEFAULT 'felh_ikon.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `felhasznalo`
--

INSERT INTO `felhasznalo` (`id`, `nev`, `jelszo`, `email`, `aktív`, `Szerep`, `megerositve`, `kod`, `datum`, `utolso_bejelentkezes`, `utoljara_hasznalt_ip`, `elrontott_bejelenkezes`, `profilkep`) VALUES
(207, 'Szléj', '$2y$10$svqOUoF6BFd0Nrhq.tRekuFq.rKukD51Ulrose6gb7euyO33dvorG', 'ricsigyula6@gmail.com', 1, 0, 1, 5397, '2025-03-17', '2025-03-17 14:37:59', 'localhost', 0, 'Szléj_Arena.png'),
(208, 'Attila', '$2y$10$oUo4Vn//bCS7vzce39umNe/NgxrguwGgtEtzOMgAykLsEh2Md0KaS', 'attila.hetes@gmail.com', 1, 0, 1, 4765, '2025-03-27', '2025-03-27 08:37:26', 'localhost', 0, 'Attila_download (2).jpg');

--
-- Triggers `felhasznalo`
--
DELIMITER $$
CREATE TRIGGER `Beallitja_az_alapertelmezett_erteket` BEFORE INSERT ON `felhasznalo` FOR EACH ROW BEGIN
    IF NEW.aktív IS NULL THEN
        SET NEW.aktív = 0;
    END IF;
    
    IF NEW.szerep IS NULL THEN
        SET NEW.szerep = 0;
    END IF;

    IF NEW.megerositve IS NULL THEN
        SET NEW.megerositve = 0;
    END IF;

    IF NEW.datum IS NULL THEN
        SET NEW.datum = NOW();
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `admin_vedelem_torlesre` BEFORE DELETE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.szerep = 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Admin felhasználók nem törölhetők!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `ellenorzo_kod_generalasara_uj_regisztraciokor` BEFORE INSERT ON `felhasznalo` FOR EACH ROW BEGIN
    SET NEW.kod = FLOOR(1000 + RAND() * 9000);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `email_kisbetusre_alakitasra` BEFORE INSERT ON `felhasznalo` FOR EACH ROW BEGIN
    SET NEW.email = LOWER(NEW.email);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `felhasznaloi_statusz_automatikus_frissitese` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF NEW.utolso_bejelentkezes < NOW() - INTERVAL 30 DAY THEN
        SET NEW.aktív = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `felhasznaloi_szerep_kor_valtozatatas` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.szerep <> NEW.szerep THEN
        INSERT INTO role_changes (user_id, old_role, new_role, change_date)
        VALUES (OLD.id, OLD.szerep, NEW.szerep, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `felhasznaloi_valtozasok` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.nev <> NEW.nev THEN
        INSERT INTO felhasznaloi_valtozasok (user_id, changed_column, old_value, new_value, change_date)
        VALUES (OLD.id, 'nev', OLD.nev, NEW.nev, NOW());
    END IF;
    
    IF OLD.email <> NEW.email THEN
        INSERT INTO felhasznaloi_valtozasok (user_id, changed_column, old_value, new_value, change_date)
        VALUES (OLD.id, 'email', OLD.email, NEW.email, NOW());
    END IF;

    IF OLD.aktív <> NEW.aktív THEN
        INSERT INTO felhasznaloi_valtozasok (user_id, changed_column, old_value, new_value, change_date)
        VALUES (OLD.id, 'aktiv', OLD.aktív, NEW.aktív, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `frissiti_ami_utoljara_volt_valtoztatva` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    SET NEW.datum = NOW();
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `gyakori_jelszo_valtoztasokra_valo_vedelem` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.jelszo <> NEW.jelszo AND 
       (SELECT MAX(change_date) FROM jelszo_elozmenyek WHERE user_id = OLD.id) > NOW() - INTERVAL 1 DAY THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Csak 24 óránként változtathatod meg a jelszavad!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `jelenlegi_dupliacio_az_emailek_kozott` BEFORE INSERT ON `felhasznalo` FOR EACH ROW BEGIN
    IF (SELECT COUNT(*) FROM felhasznalo WHERE email = NEW.email) > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Ez az e-mail cím már létezik!';
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `jelszo_valtozas` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.jelszo <> NEW.jelszo THEN
        INSERT INTO jelszo_elozmenyek (user_id, old_password, change_date)
        VALUES (OLD.id, OLD.jelszo, NOW());
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `sok_elrontott_bejelenkezes_kezeles` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF NEW.elrontott_bejelenkezes >= 5 THEN
        SET NEW.aktív = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `torolt_felhasznalok` BEFORE DELETE ON `felhasznalo` FOR EACH ROW BEGIN
    INSERT INTO deleted_users (id, nev, email, torles_idopont)
    VALUES (OLD.id, OLD.nev, OLD.email, NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `utoljara_hasznalt_ip_cim` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.aktív = 0 AND NEW.aktív = 1 THEN
        SET NEW.utoljara_hasznalt_ip = (SELECT SUBSTRING_INDEX(user(), '@', -1));
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `utolso_bejelentkezes` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.aktív = 0 AND NEW.aktív = 1 THEN
        SET NEW.utolso_bejelentkezes = NOW();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `felhasznaloi_valtozasok`
--

CREATE TABLE `felhasznaloi_valtozasok` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `changed_column` varchar(255) NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `felhasznaloi_valtozasok`
--

INSERT INTO `felhasznaloi_valtozasok` (`id`, `user_id`, `changed_column`, `old_value`, `new_value`, `change_date`) VALUES
(45, 208, 'aktiv', '1', '0', '2025-03-21 09:13:55'),
(46, 208, 'aktiv', '0', '1', '2025-03-21 09:25:52'),
(47, 208, 'aktiv', '1', '0', '2025-03-21 09:27:03'),
(48, 208, 'aktiv', '0', '1', '2025-03-21 09:27:09'),
(49, 208, 'aktiv', '1', '0', '2025-03-21 09:27:26'),
(50, 208, 'aktiv', '0', '1', '2025-03-21 09:27:31'),
(51, 208, 'aktiv', '1', '0', '2025-03-21 09:28:50'),
(52, 208, 'aktiv', '0', '1', '2025-03-21 09:29:20'),
(53, 208, 'aktiv', '1', '0', '2025-03-21 09:30:34'),
(54, 208, 'aktiv', '0', '1', '2025-03-21 09:30:40'),
(55, 208, 'aktiv', '1', '0', '2025-03-21 09:40:15'),
(56, 208, 'aktiv', '0', '1', '2025-03-21 09:40:30'),
(57, 208, 'aktiv', '1', '0', '2025-03-21 09:42:46'),
(58, 208, 'aktiv', '0', '1', '2025-03-21 10:12:25'),
(59, 208, 'aktiv', '1', '0', '2025-03-21 10:12:32'),
(60, 208, 'aktiv', '0', '1', '2025-03-21 10:12:41'),
(61, 208, 'aktiv', '1', '0', '2025-03-21 10:16:55'),
(62, 208, 'aktiv', '0', '1', '2025-03-21 10:17:01'),
(63, 208, 'aktiv', '1', '0', '2025-03-21 10:17:09'),
(64, 208, 'aktiv', '0', '1', '2025-03-21 10:17:52'),
(65, 208, 'aktiv', '1', '0', '2025-03-21 10:22:45'),
(66, 208, 'aktiv', '0', '1', '2025-03-21 10:23:40'),
(67, 208, 'aktiv', '1', '0', '2025-03-21 10:26:07'),
(68, 208, 'aktiv', '0', '1', '2025-03-21 10:26:19'),
(69, 208, 'aktiv', '1', '0', '2025-03-21 10:27:57'),
(70, 208, 'aktiv', '0', '1', '2025-03-21 10:29:19'),
(71, 208, 'aktiv', '1', '0', '2025-03-21 10:29:53'),
(72, 208, 'aktiv', '0', '1', '2025-03-21 10:29:59'),
(73, 208, 'aktiv', '1', '0', '2025-03-21 10:30:38'),
(74, 208, 'aktiv', '0', '1', '2025-03-21 10:31:01'),
(75, 208, 'aktiv', '1', '0', '2025-03-21 10:31:05'),
(76, 208, 'aktiv', '0', '1', '2025-03-21 10:31:15'),
(77, 208, 'aktiv', '1', '0', '2025-03-21 10:31:43'),
(78, 208, 'aktiv', '0', '1', '2025-03-21 10:39:48'),
(79, 208, 'aktiv', '1', '0', '2025-03-26 17:48:45'),
(80, 208, 'aktiv', '0', '1', '2025-03-26 18:13:16'),
(81, 208, 'aktiv', '1', '0', '2025-03-26 18:13:20'),
(82, 208, 'aktiv', '0', '1', '2025-03-26 18:17:17'),
(83, 208, 'aktiv', '1', '0', '2025-03-26 18:19:56'),
(84, 208, 'aktiv', '0', '1', '2025-03-26 18:21:28'),
(85, 208, 'aktiv', '1', '0', '2025-03-26 18:21:37'),
(86, 208, 'aktiv', '0', '1', '2025-03-26 18:23:13'),
(87, 208, 'aktiv', '1', '0', '2025-03-26 18:25:48'),
(88, 208, 'aktiv', '0', '1', '2025-03-26 18:41:00'),
(89, 208, 'aktiv', '1', '0', '2025-03-26 18:42:45'),
(90, 208, 'aktiv', '0', '1', '2025-03-27 07:39:26'),
(91, 208, 'aktiv', '1', '0', '2025-03-27 07:41:20'),
(92, 208, 'aktiv', '0', '1', '2025-03-27 07:42:13'),
(93, 208, 'aktiv', '1', '0', '2025-03-27 08:06:17'),
(94, 208, 'aktiv', '0', '1', '2025-03-27 08:06:23'),
(95, 208, 'aktiv', '1', '0', '2025-03-27 08:29:24'),
(96, 208, 'aktiv', '0', '1', '2025-03-27 08:37:26');

-- --------------------------------------------------------

--
-- Table structure for table `jelszo_elozmenyek`
--

CREATE TABLE `jelszo_elozmenyek` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `old_password` varchar(255) NOT NULL,
  `change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `slug`) VALUES
(2, 'Erdekesseg', 'Erdekesseg'),
(3, 'Profil', 'Profil'),
(4, 'Szobak', 'Szobak'),
(5, 'Hírek', 'Hírek'),
(7, 'Fooldal', 'Fooldal'),
(8, 'Kilépés', 'Kilépés');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `text` varchar(250) NOT NULL,
  `time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `room`, `name`, `text`, `time`) VALUES
(9, 2, 'Attila', 'asd', '2025-03-08'),
(10, 0, 'User', 'Szia', '2025-03-10'),
(11, 0, 'User', 'sad', '2025-03-10'),
(12, 0, 'User724', 'ad', '2025-03-10'),
(13, 12, 'Attila', 'das', '2025-03-10'),
(14, 12, 'Attila', 'asd', '2025-03-10'),
(15, 12, 'Sanyi', 'asd', '2025-03-10'),
(16, 2, 'Szabi', 'asds', '2025-03-11'),
(17, 2, 'Attila', 'asd', '2025-03-11'),
(18, 15, 'Szabi', 'asd', '2025-03-11'),
(19, 15, 'Attila', 'asd', '2025-03-11'),
(20, 9, 'Szlej', 'Hello', '2025-03-13'),
(21, 9, 'Attila', 'SZIA TE FASZ', '2025-03-13'),
(22, 9, 'Attila', 'asd', '2025-03-13'),
(23, 9, 'Attila', 'KAPD BE', '2025-03-13'),
(24, 9, 'Attila', 'das', '2025-03-13'),
(25, 9, 'Szlej', 'Hola gay ma bro', '2025-03-13'),
(26, 5, 'Attila_G', 'Me gay ma bro', '2025-03-13'),
(27, 5, 'Gyula_Ga', 'FUCK YA', '2025-03-13'),
(28, 5, 'Attila', 'asd', '2025-03-13'),
(29, 5, 'g', 'hola', '2025-03-13'),
(30, 5, 'Attila', 'Szia ', '2025-03-13'),
(31, 5, 'Attila', 'hogy vagy?', '2025-03-13'),
(32, 5, 'g', 'you perv uwu girl', '2025-03-13'),
(33, 5, 'g', 'sigma ba', '2025-03-13'),
(34, 5, 'Attila', 'nem is igaz', '2025-03-13'),
(35, 5, 'Attila', 'mit hauds', '2025-03-13'),
(36, 5, 'g', 'rizz skibidi toilet sigma male', '2025-03-13'),
(37, 5, 'Attila', 'sigma tojlat', '2025-03-13'),
(38, 5, 'Attila', 'Nem is igaz', '2025-03-13'),
(39, 9, 'Katica', 'Sziaa', '2025-03-13'),
(40, 9, 'Katica', 'én egy 35 éves faszi vagyok', '2025-03-13'),
(41, 9, 'Dr.Gyula', 'és kamion sofőr?', '2025-03-13'),
(42, 9, 'Katica', 'NEM', '2025-03-13'),
(43, 9, 'Katica', 'ez sértő volt', '2025-03-13'),
(44, 9, 'Katica', 'Discord moderátor', '2025-03-13'),
(45, 2, 'Gyuja', 'wtf', '2025-03-14'),
(46, 20, 'Attila', 'halló?', '2025-03-14'),
(47, 20, 'Gyula', 'hello', '2025-03-14');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`) VALUES
(2, 'Erdekesseg', 'Erdekesseg', 'gladiatorinformaciok.php'),
(3, 'Szobak', 'Szobak', 'szobak.php'),
(7, 'Hírek', 'Hírek', 'Hírek.php'),
(8, 'Profil', 'Profil', 'felhasznaloi.php'),
(9, 'Adminoldal', 'Adminoldal', 'index.php'),
(10, 'Fooldal', 'Fooldal', 'fooldal.php'),
(11, 'Kilépés', 'Kilépés', 'kilepes.php');

-- --------------------------------------------------------

--
-- Table structure for table `role_changes`
--

CREATE TABLE `role_changes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `old_role` int(11) NOT NULL,
  `new_role` int(11) NOT NULL,
  `change_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bejelentesek`
--
ALTER TABLE `bejelentesek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `deleted_users`
--
ALTER TABLE `deleted_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nev` (`nev`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `felhasznaloi_valtozasok`
--
ALTER TABLE `felhasznaloi_valtozasok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `role_changes`
--
ALTER TABLE `role_changes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bejelentesek`
--
ALTER TABLE `bejelentesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `felhasznaloi_valtozasok`
--
ALTER TABLE `felhasznaloi_valtozasok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `role_changes`
--
ALTER TABLE `role_changes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `felhasznaloi_valtozasok`
--
ALTER TABLE `felhasznaloi_valtozasok`
  ADD CONSTRAINT `felhasznaloi_valtozasok_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `felhasznalo` (`id`);

--
-- Constraints for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  ADD CONSTRAINT `jelszo_elozmenyek_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `felhasznalo` (`id`);

--
-- Constraints for table `role_changes`
--
ALTER TABLE `role_changes`
  ADD CONSTRAINT `role_changes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `felhasznalo` (`id`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `nem_megerositett_felhasznalo_torles` ON SCHEDULE EVERY 1 DAY STARTS '2025-03-09 09:37:23' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM felhasznalo
    WHERE megerositve = 0 AND datum < NOW() - INTERVAL 1 DAY;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
