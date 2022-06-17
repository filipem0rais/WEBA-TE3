-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 09 juin 2022 à 08:54
-- Version du serveur : 10.4.20-MariaDB
-- Version de PHP : 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `weba-te3`
--

-- --------------------------------------------------------

--
-- Structure de la table `grade`
--
DROP DATABASE IF EXISTS weba_te3;
CREATE DATABASE weba_te3;

USE weba_te3;

CREATE TABLE `grade` (
  `idGrade` int(11) NOT NULL,
  `idSubject` int(11) NOT NULL,
  `description` varchar(255) NULL,
  `value` float(2,1) NOT NULL,
  `date` datetime NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `grade`
--

INSERT INTO `grade` (`idGrade`, `idSubject`, `description`, `value`, `date`) VALUES
(1, 1, 'TE1 MDLD', 6.0, '2022-01-01 16:35:00'),
(2, 2, 'TE1 BDON', 3.5, '2022-01-21 08:30:00'),
(3, 3, 'TE3 WEBA', 4.0, '2022-02-10 15:00:00'),
(4, 4, 'TE1 DROIT', 4.5, '2022-03-02 11:25:00'),
(5, 5, 'TE2 GEFI', 3.0, '2022-03-22 15:00:00'),
(6, 6, 'TE3 COMPTA', 4.5, '2022-04-11 13:10:00'),
(7, 7, 'TE1 IOBJ', 5.5, '2022-05-01 12:20:00'),
(8, 8, 'TE2 MATH', 5.0, '2022-05-21 14:45:00'),
(9, 9, 'TE3 ASRV', 6.0, '2022-06-10 15:00:00'),
(10, 10, 'TE1 TKDE', 4.5, '2022-06-30 08:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `subject`
--

CREATE TABLE `subject` (
  `idSubject` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `subject`
--

INSERT INTO `subject` (`idSubject`, `name`) VALUES
(1, 'MDLD'),
(2, 'BDON'),
(3, 'WEBA'),
(4, 'DROIT'),
(5, 'GEFI'),
(6, 'COMPTA'),
(7, 'IOBJ'),
(8, 'MATH'),
(9, 'ASRV'),
(10, 'TKDE');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`idGrade`),
  ADD KEY `I_FK_GRADE_SUBJECT` (`IDSUBJECT`);

--
-- Index pour la table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`idSubject`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `grade`
--
ALTER TABLE `grade`
  MODIFY `idGrade` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `subject`
--
ALTER TABLE `subject`
  MODIFY `idSubject` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `FK_GRADE_SUBJECT` FOREIGN KEY (`idSubject`) REFERENCES `subject` (`idSubject`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
