-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 05:46 PM
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
(206, 'attila', 'attila.hetes@gmail.com', '2025-03-20 08:04:36'),
(209, 'Admin', 'admin@admin.com', '2025-04-18 14:23:34'),
(210, 'Attilas', '72517552872@szily.hu', '2025-04-18 14:00:33'),
(211, 'Gyula_Mester', '72377700971@szily.hu', '2025-04-18 14:23:28'),
(212, 'ya', '72517552872@szily.hu', '2025-04-18 17:05:30'),
(213, 'Attilas', '72517552872@szily.hu', '2025-04-18 17:15:30');

-- --------------------------------------------------------

--
-- Table structure for table `email_elozmenyek`
--

CREATE TABLE `email_elozmenyek` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `old_email` varchar(200) NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

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
(207, 'Szléj', '$2y$10$svqOUoF6BFd0Nrhq.tRekuFq.rKukD51Ulrose6gb7euyO33dvorG', 'ricsigyula6@gmail.com', 0, 1, 1, 5397, '2025-04-18', '2025-03-17 14:37:59', 'localhost', 1, 'Szléj_Arena.png'),
(208, 'Ka', '$2y$10$oUo4Vn//bCS7vzce39umNe/NgxrguwGgtEtzOMgAykLsEh2Md0KaS', 'attila.hetes@gmail.com', 0, 1, 1, 4765, '2025-04-18', '2025-04-18 16:57:22', 'localhost', 0, 'Attila_Gladiator.jpg'),
(214, 'asds', '$2y$10$uGHMtMIH83IjNSJMDL62tunA2tVyIMltNG8IvxSqqel1gGZOiMCSm', '72517552872@szily.hu', 1, 0, 1, 4427, '2025-04-18', NULL, NULL, 0, 'felh_ikon.png');

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
CREATE TRIGGER `email_elozmenyek` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.email <> NEW.email THEN
        INSERT INTO email_elozmenyek (felhasznalo_id, old_email, datum)
        VALUES (OLD.id, OLD.email, NOW());
    END IF;
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
CREATE TRIGGER `frissiti_ami_utoljara_volt_valtoztatva` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    SET NEW.datum = NOW();
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
CREATE TRIGGER `jelszo_elozmenyek` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.jelszo <> NEW.jelszo THEN
        INSERT INTO jelszo_elozmenyek (felhasznalo_id, old_password, datum)
        VALUES (OLD.id, OLD.jelszo, NOW());
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
CREATE TRIGGER `nev_elozmenyek` BEFORE UPDATE ON `felhasznalo` FOR EACH ROW BEGIN
    IF OLD.nev <> NEW.nev THEN
        INSERT INTO nev_elozmenyek (felhasznalo_id, old_nev, datum)
        VALUES (OLD.id, OLD.nev, NOW());
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
-- Table structure for table `hirek`
--

CREATE TABLE `hirek` (
  `id` int(11) NOT NULL,
  `hir_cim` varchar(50) NOT NULL,
  `hir_szoveg` mediumtext NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `hirek`
--

INSERT INTO `hirek` (`id`, `hir_cim`, `hir_szoveg`, `datum`) VALUES
(1, 'Megyílt a fórumunk!', 'Sziasztok lelkes gladiátor fanok, megnyílt a fórumunk! Alig várjuk, hogy megnyíljon az első chatszoba is az oldalunkon.', '2025-03-13 08:27:00'),
(2, 'Teszt cím', 'Teszt szoveg 1\r\nContrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.\r\n\r\nThe standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum et Malorum\" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.', '2025-03-13 08:46:20'),
(3, 'Teszt c', 'Teszt szoveg 2', '2025-03-13 08:46:20'),
(0, 'Szia', 'Új hír', '2025-04-18 14:29:55');

-- --------------------------------------------------------

--
-- Table structure for table `jelentesek`
--

CREATE TABLE `jelentesek` (
  `id` int(11) NOT NULL,
  `jelentes_cime` varchar(255) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `datum` datetime NOT NULL,
  `jovahagyva` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jelszo_elozmenyek`
--

CREATE TABLE `jelszo_elozmenyek` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `old_password` varchar(255) NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kommentek`
--

CREATE TABLE `kommentek` (
  `id` int(11) NOT NULL,
  `szoveg` varchar(255) NOT NULL,
  `datum` datetime NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `hir_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `kommentek`
--

INSERT INTO `kommentek` (`id`, `szoveg`, `datum`, `felhasznalo_id`, `hir_id`) VALUES
(61, 'Hewlo', '2025-04-13 19:16:19', 213, 7),
(62, 'Howla', '2025-04-13 19:20:27', 212, 7),
(63, 'Bugulu', '2025-04-13 19:21:37', 212, 7);

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
(8, 'Kilépés', 'Kilépés'),
(9, 'Admin', 'Admin\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `nev_elozmenyek`
--

CREATE TABLE `nev_elozmenyek` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `old_nev` varchar(200) NOT NULL,
  `datum` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_hungarian_ci;

--
-- Dumping data for table `nev_elozmenyek`
--

INSERT INTO `nev_elozmenyek` (`id`, `felhasznalo_id`, `old_nev`, `datum`) VALUES
(10, 208, 'Attila', '2025-04-18 17:24:48'),
(11, 214, 'asd', '2025-04-18 17:25:05');

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
(7, 'Hírek', 'Hírek', 'News.php'),
(8, 'Profil', 'Profil', 'felhasznaloi.php'),
(10, 'Fooldal', 'Fooldal', 'fooldal.php'),
(11, 'Kilépés', 'Kilépés', 'kilepes.php'),
(12, 'Admin', 'Admin', 'Admin.php');

-- --------------------------------------------------------

--
-- Table structure for table `uzenetek`
--

CREATE TABLE `uzenetek` (
  `id` int(11) NOT NULL,
  `szoveg` text NOT NULL,
  `datum` datetime NOT NULL,
  `jelentesek_id` int(11) DEFAULT NULL,
  `felhasznalo_id` int(11) DEFAULT NULL,
  `szal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uzenet_szalk`
--

CREATE TABLE `uzenet_szalk` (
  `id` int(11) NOT NULL,
  `felhasznalo_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `statusz` enum('nyitott','zart') DEFAULT 'nyitott'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzenet_szalk`
--

INSERT INTO `uzenet_szalk` (`id`, `felhasznalo_id`, `admin_id`, `statusz`) VALUES
(35, 208, NULL, ''),
(36, 208, NULL, '');

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
-- Indexes for table `email_elozmenyek`
--
ALTER TABLE `email_elozmenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- Indexes for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nev` (`nev`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `jelentesek`
--
ALTER TABLE `jelentesek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jelentesek_felhasznalo` (`felhasznalo_id`);

--
-- Indexes for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`felhasznalo_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `nev_elozmenyek`
--
ALTER TABLE `nev_elozmenyek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `uzenetek`
--
ALTER TABLE `uzenetek`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jelentesek_id` (`jelentesek_id`),
  ADD KEY `fk_uzenetek_felhasznalo` (`felhasznalo_id`);

--
-- Indexes for table `uzenet_szalk`
--
ALTER TABLE `uzenet_szalk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `felhasznalo_id` (`felhasznalo_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bejelentesek`
--
ALTER TABLE `bejelentesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `email_elozmenyek`
--
ALTER TABLE `email_elozmenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `felhasznalo`
--
ALTER TABLE `felhasznalo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT for table `jelentesek`
--
ALTER TABLE `jelentesek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `nev_elozmenyek`
--
ALTER TABLE `nev_elozmenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `uzenetek`
--
ALTER TABLE `uzenetek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=330;

--
-- AUTO_INCREMENT for table `uzenet_szalk`
--
ALTER TABLE `uzenet_szalk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `email_elozmenyek`
--
ALTER TABLE `email_elozmenyek`
  ADD CONSTRAINT `email_elozmenyek_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`);

--
-- Constraints for table `jelentesek`
--
ALTER TABLE `jelentesek`
  ADD CONSTRAINT `fk_jelentesek_felhasznalo` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  ADD CONSTRAINT `jelszo_elozmenyek_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`);

--
-- Constraints for table `nev_elozmenyek`
--
ALTER TABLE `nev_elozmenyek`
  ADD CONSTRAINT `nev_elozmenyek_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`);

--
-- Constraints for table `uzenetek`
--
ALTER TABLE `uzenetek`
  ADD CONSTRAINT `fk_uzenetek_felhasznalo` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uzenetek_ibfk_1` FOREIGN KEY (`jelentesek_id`) REFERENCES `jelentesek` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uzenet_szalk`
--
ALTER TABLE `uzenet_szalk`
  ADD CONSTRAINT `uzenet_szalk_ibfk_1` FOREIGN KEY (`felhasznalo_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `uzenet_szalk_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `felhasznalo` (`id`) ON DELETE CASCADE;

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
