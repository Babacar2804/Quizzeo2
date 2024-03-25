-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 25, 2024 at 11:03 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
DROP Database if EXISTS quizzeo;
CREATE DATABASE quizzeo

use quizzeo;
--
-- Database: `quizzeo2`
--

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id_quizz` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(50) DEFAULT NULL,
  `date_creation` date DEFAULT NULL,
  `type` enum('QCM','Sondage') NOT NULL,
  `Description` varchar(120) DEFAULT NULL,
  `statut_quizz` enum('creation','lance','termine') NOT NULL,
  `visi_res` tinyint NOT NULL,
  `id_user` int NOT NULL,
  `lien` varchar(100) NOT NULL,
  PRIMARY KEY (`id_quizz`),
  KEY `id_user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id_quizz`, `titre`, `date_creation`, `type`, `Description`, `statut_quizz`, `visi_res`, `id_user`, `lien`) VALUES
(20, 'Test', '2024-03-25', 'QCM', 'zsczsc', 'creation', 0, 26, ''),
(21, 'xQ', '2024-03-25', 'QCM', 'xqxqx', 'creation', 0, 26, ''),
(22, '&quot;rfef', '2024-03-25', 'QCM', '²frevfvz²²', 'creation', 0, 26, 'http://localhost/Projet%20Web/Quizzeo2/quizz.php/22/LiX5crT1eN');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
