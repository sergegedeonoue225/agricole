-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 22 juil. 2024 à 22:39
-- Version du serveur : 8.0.31
-- Version de PHP : 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `compteflash`
--

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `solde` decimal(10,2) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `code_postal` varchar(10) NOT NULL,
  `numero_compte` varchar(20) NOT NULL,
  `rib` varchar(20) NOT NULL,
  `identifiant` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type_compte` varchar(50) NOT NULL,
  `numero_telephone` varchar(20) NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `derniere_connexion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `email`, `solde`, `adresse`, `ville`, `code_postal`, `numero_compte`, `rib`, `identifiant`, `password`, `type_compte`, `numero_telephone`, `date_creation`, `derniere_connexion`) VALUES
(1, 'Laguilliez', 'Scott', 'gedeonachat@gmail.com', '206781.00', '25 Rue des Champs Sarrazins', 'Champagnole', '39300', '17635780001', 'FR761659800001176357', '11111111111', '$2y$10$sBzbPe3K8ifpJqSK/NByf.08tzeOCFulkUm/g.7MN.Lju0DhGqXFy', 'Compte courant', '0788254371', '2024-06-08 12:31:40', '2024-07-11 17:35:22');

-- --------------------------------------------------------

--
-- Structure de la table `virements`
--

DROP TABLE IF EXISTS `virements`;
CREATE TABLE IF NOT EXISTS `virements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `nom_beneficiaire` varchar(255) NOT NULL,
  `email_beneficiaire` varchar(255) NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `numero_telephone` varchar(20) NOT NULL,
  `motif` varchar(255) NOT NULL,
  `rib` varchar(255) NOT NULL,
  `date_virement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `virements`
--

INSERT INTO `virements` (`id`, `user_id`, `nom_beneficiaire`, `email_beneficiaire`, `montant`, `numero_telephone`, `motif`, `rib`, `date_virement`) VALUES
(1, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '1000.00', '0788254371', 'ok', 'FR7616598000011763578000185', '2024-06-08 12:06:25'),
(2, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'ok', 'FR7616598000011763578000185', '2024-06-08 15:34:52'),
(3, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '122.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 15:44:02'),
(4, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 15:53:55'),
(5, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:02:01'),
(6, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:02:40'),
(7, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:02:47'),
(8, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:08:58'),
(9, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:12:34'),
(10, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:13:26'),
(11, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '122.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:16:39'),
(12, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '122.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 16:57:16'),
(13, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '122.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 18:16:31'),
(14, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '7613.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 18:17:50'),
(15, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '7613.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 18:21:22'),
(16, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '761.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-06-08 18:25:25'),
(17, 1, 'serge gedeon oue', 'ouesergegedeon225@gmail.com', '100.00', '0788254371', 'Règlement des acomptes ', 'FR7616598000011763578000185', '2024-07-11 17:35:22');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
