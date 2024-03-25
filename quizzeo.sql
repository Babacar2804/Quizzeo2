DROP Database if EXISTS quizzeo;
CREATE DATABASE quizzeo;

use quizzeo;
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 25, 2024 at 11:12 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quizzeo2`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id_question` int NOT NULL AUTO_INCREMENT,
  `question` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_quizz` int NOT NULL,
  PRIMARY KEY (`id_question`),
  KEY `questions_ibfk_1` (`id_quizz`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id_question`, `question`, `id_quizz`) VALUES
(27, 'zscd', 20),
(28, 'xqsx', 21),
(29, 'efead&amp;e&quot;²', 22);

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

-- --------------------------------------------------------

--
-- Table structure for table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id_reponse` int NOT NULL AUTO_INCREMENT,
  `reponses` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_question` int NOT NULL,
  PRIMARY KEY (`id_reponse`),
  KEY `reponses_ibfk_1` (`id_question`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reponses`
--

INSERT INTO `reponses` (`id_reponse`, `reponses`, `id_question`) VALUES
(50, 'dzcdc', 27),
(51, 'dzscd;c', 27),
(52, 'dc;scd;c', 27),
(53, 'XQXQXS', 28),
(54, 'xscsc', 28),
(55, 'xscsc', 28),
(56, 'efvrdv', 29),
(57, 'edzefvzd', 29),
(58, 'deafvedved', 29);

-- --------------------------------------------------------

--
-- Table structure for table `reponse_user`
--

DROP TABLE IF EXISTS `reponse_user`;
CREATE TABLE IF NOT EXISTS `reponse_user` (
  `id_repuser` int NOT NULL AUTO_INCREMENT,
  `id_user` int DEFAULT NULL,
  `id_question` int DEFAULT NULL,
  `id_reponse` int DEFAULT NULL,
  `statut_rep` enum('correct','incorrect') NOT NULL,
  PRIMARY KEY (`id_repuser`),
  KEY `id_user` (`id_user`),
  KEY `id_question` (`id_question`),
  KEY `id_reponse` (`id_reponse`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` int NOT NULL AUTO_INCREMENT,
  `nom_role` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`) VALUES
(1, 'Admin'),
(2, 'Validateur'),
(3, 'Quizz_admin'),
(4, 'Quizzer'),
(5, 'Utilisateur');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `statut_compte` tinyint(1) NOT NULL,
  `id_role` int NOT NULL,
  `api_key` varchar(250) NOT NULL,
  `status` tinyint NOT NULL,
  PRIMARY KEY (`id_user`),
  KEY `id_role` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `pseudo`, `email`, `password`, `statut_compte`, `id_role`, `api_key`, `status`) VALUES
(23, 'admin', 'admin@exemple.com', '$2y$10$vqYvdjjLbGKz9l1BgipAfe2gHTFU0qOjnqFl/mb0CcRAGlAiZceSe', 1, 1, '', 1),
(24, 'validateur', 'validateur@exemple.com', '$2y$10$zrpa15MB.k0RdeB59J1b4.W0szgbwpuLfhLawc5PK1FeK5OK8oR2u', 1, 2, '', 0),
(25, 'quizz_admin', 'quizzadmin@gmail.com', '$2y$10$z9ghxZVCJauFjo8s3EFAO.ThotXbrs3Ye7oqtPBCcajHX0aeQT/wi', 1, 3, '', 0),
(26, 'quizzer', 'quizzer@example.com', '$2y$10$yWmRRkObDgRPBjIPt0ifmuEqcXstXJmVjqDLt9B7b/nObDYIlGDrG', 1, 4, '', 0),
(51, 'toto', 'toto@to.fr', '$2y$10$nLczIri2Vn0vcRFLBP5Mauq4nuMTlMOzcVuHISNpoxJHclXOUV9dW', 0, 5, 'g2pc71i8olu1b8fxw', 1),
(52, 'stive', 'stive@gmail.com', '$2y$10$tlJzL2rKsEHQ6DcOyfwW1.zIzArM4wa0ooj/NTZO9my4UHWl0WjVK', 0, 5, 'g2pc71i8olu1bdj17', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`id_quizz`) REFERENCES `quizzes` (`id_quizz`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD CONSTRAINT `quizzes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `reponses`
--
ALTER TABLE `reponses`
  ADD CONSTRAINT `reponses_ibfk_1` FOREIGN KEY (`id_question`) REFERENCES `questions` (`id_question`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;