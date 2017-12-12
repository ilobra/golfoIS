-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2017 at 05:40 PM
-- Server version: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `golfois`
--

-- --------------------------------------------------------

--
-- Table structure for table `aikstynas`
--

DROP TABLE IF EXISTS `aikstynas`;
CREATE TABLE IF NOT EXISTS `aikstynas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aikstyno_info` varchar(500) COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `aikstynas`
--

INSERT INTO `aikstynas` (`id`, `aikstyno_info`) VALUES
(1, 'Žaliasis paviljonas'),
(2, 'Didysis laukas'),
(3, 'Pergalių zona'),
(4, 'Naujasis aikštynas');

-- --------------------------------------------------------

--
-- Table structure for table `aikstyno_tvarkymas`
--

DROP TABLE IF EXISTS `aikstyno_tvarkymas`;
CREATE TABLE IF NOT EXISTS `aikstyno_tvarkymas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `komentaras` varchar(500) COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `data` date NOT NULL,
  `pradzios_laikas` date DEFAULT NULL,
  `pabaigos_laikas` date DEFAULT NULL,
  `fk_Aikstynasid` int(11) DEFAULT NULL,
  `fk_Darbuotojasid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tvarkomas` (`fk_Aikstynasid`),
  KEY `tvarko` (`fk_Darbuotojasid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asmens_tipas`
--

DROP TABLE IF EXISTS `asmens_tipas`;
CREATE TABLE IF NOT EXISTS `asmens_tipas` (
  `id_Asmens_tipas` int(11) NOT NULL,
  `name` varchar(31) COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id_Asmens_tipas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `asmens_tipas`
--

INSERT INTO `asmens_tipas` (`id_Asmens_tipas`, `name`) VALUES
(1, 'stovejimo_aiksteles_darbuotojas'),
(2, 'golfo_aikstyno_darbuotojas'),
(3, 'irangos_nuomos_darbuotojas'),
(4, 'administratorius'),
(5, 'narys'),
(6, 'vip_narys');

-- --------------------------------------------------------

--
-- Table structure for table `asmuo`
--

DROP TABLE IF EXISTS `asmuo`;
CREATE TABLE IF NOT EXISTS `asmuo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vardas` varchar(30) COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `pavarde` varchar(40) COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `el_pastas` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL,
  `asmens_kodas` varchar(11) COLLATE utf8_lithuanian_ci NOT NULL,
  `slaptazodis` varchar(64) COLLATE utf8_lithuanian_ci NOT NULL,
  `tipas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipas` (`tipas`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `asmuo`
--

INSERT INTO `asmuo` (`id`, `vardas`, `pavarde`, `el_pastas`, `asmens_kodas`, `slaptazodis`, `tipas`) VALUES
(12, 'Jonas', 'Jonaitis', 'jonas.j@gmail.com', '39510121415', '$2y$13$ksPNFV8Jh2nD3ehmKPzoT.S6RgC7AxfJJC.5kGFtnSH14kSKgNxJ2', 5),
(13, 'Tomas', 'Tomaitis', 'tomas@gmail.com', '39611152326', '$2y$13$uzIL2VVxF.q/wB0Zd.deY.FpesBfPTtTH5EdRtzxQ0VoQadaOWHv6', 5),
(18, 'Ignas', 'Ignaitis', 'ignas@gmail.com', '39512141516', '$2y$13$/hDgdCID2QwhfJmThYN8cuhbzf.ydV.Imqiz3n4BOX3fNWs1QRjS.', 5),
(19, 'Haris', 'Haraitis', 'haris@gmail.com', '39412141314', '$2y$13$8leJUOgSrl9TKFGEO2HuPe.trnfn8dRC29lak1kREiTI47tCsJWi.', 6),
(20, 'Rasa', 'Rasaitytė', 'rasa@gmail.com', '50005302012', '$2y$13$8jQ1DmZr730goWvhlsOWmu8k.nHnbAl0P1tQk5F4iyLiv7tHxt17G', 4),
(21, 'vip', 'vipvip', 'vip@gmail.com', '8541212541', '$2y$13$BbLZGFsmMujfh77va0lV/uhufp7OEDiRE1XI2zwbGN.OmrvV.1fbG', 6),
(22, 'Stovejimo aiksteles', 'darbuotojas', 'SAdarbuotojas@mail.com', '11111111111', '$2y$13$YTZNcAa1HdwlAW4Yj/zjxOMzPokZqgHfAf2SMyH3sDOmofdw2LWLK', 1),
(23, 'golfo aiksteles', 'darbuotojas', 'GAdarbuotojas@mail.com', '22222222222', '$2y$13$rSkI8S9FdZd6KJgrt8L3v.xckDuVUDSvFKQRVWrknoEAsLUJRGmfi', 2),
(24, 'Irangos', 'darbuotojas', 'Idarbuotojas@mail.com', '33333333333', '$2y$13$euVYBbeb9E6XDr12MzuoT.5nYpdvArxf36CwlZaOFJDkle5rKUgUu', 3),
(26, 'Ilona', 'Brazauskaitė', 'ilonabra@gmail.com', '49702041234', '$2y$13$8jQ1DmZr730goWvhlsOWmu8k.nHnbAl0P1tQk5F4iyLiv7tHxt17G', 4),
(27, 'Indrė', 'Liepaitė', 'indrel@gmail.com', '48906221147', '$2y$13$.UW9Q8CpLHuz5OstW6FbUeESOmy8nzdLmxySc9DnokTxyXxy7essm', 5),
(28, 'Dainius', 'Vileišis', 'dainiusv@gmail.com', '47803042369', '$2y$13$354N2Bhf881tSiMex3C.1O7HwPXgMVZA00o0r/bhGpKVCzcc.hEVW', 6),
(30, 'Povilas', 'Povilaitis', 'povilasp@gmail.com', '38612142145', '$2y$13$vv57yJYK/y1/LxJFyYBkhOl7gBUHhJ1dJNdrUV6L9rYUnN1YhnG32', 5);

-- --------------------------------------------------------

--
-- Table structure for table `darbuotojas`
--

DROP TABLE IF EXISTS `darbuotojas`;
CREATE TABLE IF NOT EXISTS `darbuotojas` (
  `uzmokestis` decimal(10,0) DEFAULT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `darbuotojas`
--

INSERT INTO `darbuotojas` (`uzmokestis`, `id`) VALUES
(350, '22'),
(400, '23'),
(450, '24');

-- --------------------------------------------------------

--
-- Table structure for table `duobute`
--

DROP TABLE IF EXISTS `duobute`;
CREATE TABLE IF NOT EXISTS `duobute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `duobutes_info` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `fk_Aikstynasid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `turi` (`fk_Aikstynasid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `iranga`
--

DROP TABLE IF EXISTS `iranga`;
CREATE TABLE IF NOT EXISTS `iranga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kokybe` varchar(255) COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `isigijimo_data` date NOT NULL,
  `tipas` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tipas` (`tipas`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `iranga`
--

INSERT INTO `iranga` (`id`, `kokybe`, `isigijimo_data`, `tipas`) VALUES
(1, 'gera', '2011-10-15', 1),
(2, 'su pabraižymais', '2015-10-18', 1),
(3, 'puiki', '2017-10-11', 2),
(5, 'ideali', '2017-12-01', 3),
(6, 'l. gera', '2015-12-13', 1),
(7, 'normali', '2015-06-15', 1),
(8, 'puiki', '2017-10-15', 2),
(9, 'nebloga', '2015-10-15', 2),
(10, 'gera', '2016-07-16', 2),
(11, 'l. gera', '2017-05-15', 3),
(12, 'su pabraižymais', '2016-12-08', 3);

-- --------------------------------------------------------

--
-- Table structure for table `irangos_apmokejimas`
--

DROP TABLE IF EXISTS `irangos_apmokejimas`;
CREATE TABLE IF NOT EXISTS `irangos_apmokejimas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suma` decimal(10,0) NOT NULL,
  `isnuomojimo_pradzia` date NOT NULL,
  `isnuomojimo_pabaiga` date NOT NULL,
  `fk_Narysid` int(11) DEFAULT NULL,
  `fk_Irangaid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `atlieka` (`fk_Narysid`),
  KEY `apmokama` (`fk_Irangaid`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `irangos_apmokejimas`
--

INSERT INTO `irangos_apmokejimas` (`id`, `suma`, `isnuomojimo_pradzia`, `isnuomojimo_pabaiga`, `fk_Narysid`, `fk_Irangaid`) VALUES
(2, '11', '2017-12-01', '2017-12-02', 13, 3),
(3, '6', '2017-12-03', '2017-12-06', 13, 2),
(6, '14', '2017-12-03', '2017-12-10', 20, 1),
(7, '49', '2017-12-03', '2017-12-17', 13, 3),
(8, '6', '2017-12-03', '2017-12-06', 20, 6),
(9, '6', '2017-12-11', '2017-12-14', 28, 6),
(10, '11', '2017-12-11', '2017-12-14', 28, 8),
(11, '105', '2017-12-11', '2017-12-14', 28, 5),
(12, '245', '2017-12-12', '2017-12-19', 12, 11);

-- --------------------------------------------------------

--
-- Table structure for table `irangos_tipas`
--

DROP TABLE IF EXISTS `irangos_tipas`;
CREATE TABLE IF NOT EXISTS `irangos_tipas` (
  `id_Irangos_tipas` int(11) NOT NULL,
  `name` varchar(11) COLLATE utf8_lithuanian_ci NOT NULL,
  PRIMARY KEY (`id_Irangos_tipas`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `irangos_tipas`
--

INSERT INTO `irangos_tipas` (`id_Irangos_tipas`, `name`) VALUES
(1, 'Lazdos'),
(2, 'Kamuoliukai'),
(3, 'Transportas');

-- --------------------------------------------------------

--
-- Table structure for table `komanda`
--

DROP TABLE IF EXISTS `komanda`;
CREATE TABLE IF NOT EXISTS `komanda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pavadinimas` varchar(40) COLLATE utf8_lithuanian_ci NOT NULL,
  `ikurimo_data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `narys`
--

DROP TABLE IF EXISTS `narys`;
CREATE TABLE IF NOT EXISTS `narys` (
  `banko_kort_numeris` varchar(20) COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `id` int(11) NOT NULL,
  `fk_Komandaid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `VIP_narys_priklauso` (`fk_Komandaid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `narys`
--

INSERT INTO `narys` (`banko_kort_numeris`, `id`, `fk_Komandaid`) VALUES
('8944512512', 12, NULL),
('9465451232501', 13, NULL),
('1254451233', 18, NULL),
('1444512', 19, NULL),
('LT96101523654', 20, NULL),
(NULL, 21, NULL),
(NULL, 26, NULL),
(NULL, 27, NULL),
('LT996586532085200000', 28, NULL),
(NULL, 30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `narystes_apmokejimas`
--

DROP TABLE IF EXISTS `narystes_apmokejimas`;
CREATE TABLE IF NOT EXISTS `narystes_apmokejimas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suma` decimal(10,0) NOT NULL,
  `narystes_pradzia` date NOT NULL,
  `narystes_pabaiga` date NOT NULL,
  `fk_Narysid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `VIP_narys_atlieka` (`fk_Narysid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `narystes_apmokejimas`
--

INSERT INTO `narystes_apmokejimas` (`id`, `suma`, `narystes_pradzia`, `narystes_pabaiga`, `fk_Narysid`) VALUES
(1, '3', '2017-12-01', '2017-12-08', 13),
(2, '7', '2017-12-02', '2017-12-12', 19);

-- --------------------------------------------------------

--
-- Table structure for table `rezultatas`
--

DROP TABLE IF EXISTS `rezultatas`;
CREATE TABLE IF NOT EXISTS `rezultatas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raundas` int(11) NOT NULL,
  `musimu_sk` int(11) NOT NULL,
  `fk_Aikstynasid` int(11) DEFAULT NULL,
  `fk_Narysid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `priklauso` (`fk_Aikstynasid`),
  KEY `seka_ir_registruoja` (`fk_Narysid`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `rezultatas`
--

INSERT INTO `rezultatas` (`id`, `raundas`, `musimu_sk`, `fk_Aikstynasid`, `fk_Narysid`) VALUES
(5, 3, 25, 2, 13),
(6, 3, 25, 3, 20),
(7, 15, 15, 3, 13),
(9, 4, 52, 3, 13),
(10, 6, 115, 3, 13),
(11, 2, 20, 2, 13),
(12, 3, 55, 3, 13),
(13, 2, 20, 4, 28),
(14, 3, 15, 4, 28);

-- --------------------------------------------------------

--
-- Table structure for table `stovejimo_aikstele`
--

DROP TABLE IF EXISTS `stovejimo_aikstele`;
CREATE TABLE IF NOT EXISTS `stovejimo_aikstele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vietos_nr` varchar(50) COLLATE utf8_lithuanian_ci NOT NULL,
  `priskyrimo_data` date NULL,
  `fk_Asmuoid` int(11) NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fk_Asmuoid` (`fk_Asmuoid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `stovejimo_aikstele`
--

INSERT INTO `stovejimo_aikstele` (`id`, `vietos_nr`, `priskyrimo_data`, `fk_Asmuoid`) VALUES
(1, 11, null, null),
(2, 12, null, null),
(3, 13, '2013-05-11', 20),
(4, 14, '2017-11-01', 22),
(5, 15, '2015-05-11', 23),
(6, 16, null, null);

-- --------------------------------------------------------

--
-- Table structure for table `turnyras`
--

DROP TABLE IF EXISTS `turnyras`;
CREATE TABLE IF NOT EXISTS `turnyras` (
  `id` varchar(255) COLLATE utf8_lithuanian_ci NOT NULL,
  `fk_Zaidimo_rezervacijaid` int(11) DEFAULT NULL,
  `fk_Narysid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `priskirta` (`fk_Zaidimo_rezervacijaid`),
  KEY `dalyvauja` (`fk_Narysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `turnyras`
--

INSERT INTO `turnyras` (`id`, `fk_Zaidimo_rezervacijaid`, `fk_Narysid`) VALUES
('54a4775a3d69b2ade3028981e5ebc571', 12, 26),
('5ea948fb53717dafbd22b7967f181891', 4, 20),
('72c6798ee5f7591ca36b4e81b45272ab', 3, 13),
('925f1b1fdb6c78f055acbafdb1515c03', 4, 13),
('971ae6e9eb950ba00d156101ee6220c2', 3, 27),
('a83e98e96991898760ac3daf6aab95b7', 3, 26),
('c9ffbed93dbb7c09feb8b7da11206c6e', 12, 20),
('e04c5f98a9d212ddc190d861acda37f5', 12, 13),
('f9c01c4d43ebd284b86e2d3632fcd789', 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `zaidimo_rezervacija`
--

DROP TABLE IF EXISTS `zaidimo_rezervacija`;
CREATE TABLE IF NOT EXISTS `zaidimo_rezervacija` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` date NOT NULL,
  `pradzios_laikas` time NOT NULL,
  `pabaigos_laikas` time NOT NULL,
  `pavadinimas` varchar(255) COLLATE utf8_lithuanian_ci DEFAULT NULL,
  `fk_Aikstynasid` int(11) DEFAULT NULL,
  `fk_Narysid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `skiriama` (`fk_Aikstynasid`),
  KEY `sukuria_turnyra_rezervuoja_zaidima` (`fk_Narysid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_lithuanian_ci;

--
-- Dumping data for table `zaidimo_rezervacija`
--

INSERT INTO `zaidimo_rezervacija` (`id`, `data`, `pradzios_laikas`, `pabaigos_laikas`, `pavadinimas`, `fk_Aikstynasid`, `fk_Narysid`) VALUES
(2, '2017-12-03', '08:00:00', '11:00:00', 'Rezervacija', 2, 13),
(3, '2017-12-30', '16:00:00', '21:00:00', 'Turnyras A', 3, 19),
(4, '2017-12-07', '16:00:00', '21:00:00', 'Turnyras2', 1, 19),
(5, '2017-12-01', '08:00:00', '11:00:00', 'Rezervacija', 2, 19),
(6, '2017-12-01', '12:00:00', '15:00:00', 'Rezervacija', 3, 13),
(10, '2017-12-20', '12:00:00', '15:00:00', 'Rezervacija', 4, 20),
(11, '2017-12-02', '08:00:00', '11:00:00', 'Rezervacija', 1, 13),
(12, '2017-12-27', '16:00:00', '21:00:00', 'Turnyras B', 4, 21),
(13, '2017-12-20', '08:00:00', '11:00:00', 'Rezervacija', 4, 20),
(15, '2017-12-14', '08:00:00', '11:00:00', 'Rezervacija', 3, 27),
(16, '2017-12-11', '08:00:00', '11:00:00', 'Rezervacija', 1, 28),
(17, '2017-12-20', '12:00:00', '15:00:00', 'Rezervacija', 1, 13),
(18, '2017-12-12', '08:00:00', '11:00:00', 'Rezervacija', 1, 13),
(19, '2017-12-13', '08:00:00', '11:00:00', 'Rezervacija', 2, 13),
(20, '2018-01-15', '16:00:00', '21:00:00', 'Turnyras C', 2, 28),
(21, '2018-02-15', '16:00:00', '21:00:00', 'Turnyras D', 1, 28),
(22, '2017-12-13', '08:00:00', '11:00:00', 'Rezervacija', 3, 12);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aikstyno_tvarkymas`
--
ALTER TABLE `aikstyno_tvarkymas`
  ADD CONSTRAINT `tvarko` FOREIGN KEY (`fk_Darbuotojasid`) REFERENCES `darbuotojas` (`id`),
  ADD CONSTRAINT `tvarkomas` FOREIGN KEY (`fk_Aikstynasid`) REFERENCES `aikstynas` (`id`);

--
-- Constraints for table `asmuo`
--
ALTER TABLE `asmuo`
  ADD CONSTRAINT `Asmuo_ibfk_1` FOREIGN KEY (`tipas`) REFERENCES `asmens_tipas` (`id_Asmens_tipas`);

--
-- Constraints for table `darbuotojas`
--
ALTER TABLE `darbuotojas`
  ADD CONSTRAINT `Darbuotojas_ibfk_1` FOREIGN KEY (`id`) REFERENCES `asmuo` (`id`);

--
-- Constraints for table `duobute`
--
ALTER TABLE `duobute`
  ADD CONSTRAINT `turi` FOREIGN KEY (`fk_Aikstynasid`) REFERENCES `aikstynas` (`id`);

--
-- Constraints for table `iranga`
--
ALTER TABLE `iranga`
  ADD CONSTRAINT `Iranga_ibfk_1` FOREIGN KEY (`tipas`) REFERENCES `irangos_tipas` (`id_Irangos_tipas`);

--
-- Constraints for table `irangos_apmokejimas`
--
ALTER TABLE `irangos_apmokejimas`
  ADD CONSTRAINT `apmokama` FOREIGN KEY (`fk_Irangaid`) REFERENCES `iranga` (`id`),
  ADD CONSTRAINT `atlieka` FOREIGN KEY (`fk_Narysid`) REFERENCES `narys` (`id`);

--
-- Constraints for table `narys`
--
ALTER TABLE `narys`
  ADD CONSTRAINT `Narys_ibfk_1` FOREIGN KEY (`id`) REFERENCES `asmuo` (`id`),
  ADD CONSTRAINT `VIP_narys_priklauso` FOREIGN KEY (`fk_Komandaid`) REFERENCES `komanda` (`id`);

--
-- Constraints for table `narystes_apmokejimas`
--
ALTER TABLE `narystes_apmokejimas`
  ADD CONSTRAINT `VIP_narys_atlieka` FOREIGN KEY (`fk_Narysid`) REFERENCES `narys` (`id`);

--
-- Constraints for table `rezultatas`
--
ALTER TABLE `rezultatas`
  ADD CONSTRAINT `priklauso` FOREIGN KEY (`fk_Aikstynasid`) REFERENCES `aikstynas` (`id`),
  ADD CONSTRAINT `seka_ir_registruoja` FOREIGN KEY (`fk_Narysid`) REFERENCES `narys` (`id`);

--
-- Constraints for table `stovejimo_aikstele`
--
ALTER TABLE `stovejimo_aikstele`
  ADD CONSTRAINT `turi_vieta` FOREIGN KEY (`fk_Asmuoid`) REFERENCES `asmuo` (`id`);

--
-- Constraints for table `turnyras`
--
ALTER TABLE `turnyras`
  ADD CONSTRAINT `dalyvauja` FOREIGN KEY (`fk_Narysid`) REFERENCES `narys` (`id`),
  ADD CONSTRAINT `priskirta` FOREIGN KEY (`fk_Zaidimo_rezervacijaid`) REFERENCES `zaidimo_rezervacija` (`id`);

--
-- Constraints for table `zaidimo_rezervacija`
--
ALTER TABLE `zaidimo_rezervacija`
  ADD CONSTRAINT `skiriama` FOREIGN KEY (`fk_Aikstynasid`) REFERENCES `aikstynas` (`id`),
  ADD CONSTRAINT `sukuria_turnyra_rezervuoja_zaidima` FOREIGN KEY (`fk_Narysid`) REFERENCES `narys` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
