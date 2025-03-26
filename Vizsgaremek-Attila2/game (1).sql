-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2025 at 06:37 AM
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
  `datum` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bejelentesek`
--

INSERT INTO `bejelentesek` (`id`, `cim`, `leiras`, `datum`) VALUES
(1, 'Káromkodás', 'Ez a felhasználó káromkodott', '2025-03-09 12:39:54');

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
(194, 'Attila', 'attila.hetes@gmail.com', '2025-03-09 10:06:34'),
(195, 'Gyula', 'ricsigyula6@gmail.com', '2025-03-09 10:06:36');

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
  `elrontott_bejelenkezes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `felhasznalo`
--

INSERT INTO `felhasznalo` (`id`, `nev`, `jelszo`, `email`, `aktív`, `Szerep`, `megerositve`, `kod`, `datum`, `utolso_bejelentkezes`, `utoljara_hasznalt_ip`, `elrontott_bejelenkezes`) VALUES
(196, 'Attila', '$2y$10$x6h2I1t9amKeTWOyXo6H5OXmbA5ROYVL14VHf2t9WpML0R02CdZ.y', 'attila.hetes@gmail.com', 1, 0, 1, 9389, '2025-03-10', '2025-03-09 16:23:21', 'localhost', 0);

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
(1, 196, 'aktiv', '1', '0', '2025-03-09 12:31:12'),
(4, 196, 'aktiv', '0', '1', '2025-03-09 12:34:57'),
(5, 196, 'aktiv', '1', '0', '2025-03-09 14:27:08'),
(6, 196, 'aktiv', '0', '1', '2025-03-09 14:32:23'),
(7, 196, 'aktiv', '1', '0', '2025-03-09 16:21:13'),
(8, 196, 'aktiv', '0', '1', '2025-03-09 16:23:21');

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
(15, 12, 'Sanyi', 'asd', '2025-03-10');

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=197;

--
-- AUTO_INCREMENT for table `felhasznaloi_valtozasok`
--
ALTER TABLE `felhasznaloi_valtozasok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jelszo_elozmenyek`
--
ALTER TABLE `jelszo_elozmenyek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
