-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 26 mars 2025 à 10:27
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sneakme`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Basketball'),
(3, 'Lifestyle'),
(2, 'Running'),
(4, 'Sneakers');

-- --------------------------------------------------------

--
-- Structure de la table `keyword`
--

DROP TABLE IF EXISTS `keyword`;
CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `keyword`
--

INSERT INTO `keyword` (`id`, `name`) VALUES
(10, 'catalogue'),
(11, 'commander'),
(16, 'connection'),
(17, 'connexion'),
(12, 'déco'),
(15, 'déconnection'),
(13, 'déconnexion'),
(1, 'inscription'),
(14, 'logout'),
(9, 'produit'),
(4, 'sav');

-- --------------------------------------------------------

--
-- Structure de la table `keyword_response`
--

DROP TABLE IF EXISTS `keyword_response`;
CREATE TABLE IF NOT EXISTS `keyword_response` (
  `keyword_id` int NOT NULL,
  `response_id` int NOT NULL,
  PRIMARY KEY (`keyword_id`,`response_id`),
  KEY `fk_response` (`response_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `keyword_response`
--

INSERT INTO `keyword_response` (`keyword_id`, `response_id`) VALUES
(1, 1),
(16, 2),
(17, 2),
(4, 4),
(9, 7),
(10, 7),
(11, 7),
(12, 8),
(13, 8),
(14, 8),
(15, 8);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_category` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `title`, `description`, `price`, `image`, `category_id`) VALUES
(1, 'Nike Air Force 1', 'Une basket emblématique de Nike', 99.99, 'air-force-1.jpg', 1),
(2, 'Adidas UltraBoost', 'Une chaussure de running confortable', 180.00, 'ultraboost.jpg', 2),
(3, 'Jordan 1 Retro', 'Un classique du basketball', 150.00, 'jordan-1.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `response`
--

DROP TABLE IF EXISTS `response`;
CREATE TABLE IF NOT EXISTS `response` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `response`
--

INSERT INTO `response` (`id`, `name`) VALUES
(1, 'Merci de vous êtes inscrit, bienvenue !'),
(2, 'Bon retour parmi nous !'),
(3, 'Vous avez été déconnecté avec succès.'),
(4, 'Pour joindre notre service après vente vous pouvez contacter le 0865342154 munit de votre numéro de commande'),
(5, 'test'),
(6, 'Vous souhaiter voir nos produits en stock actuellement ? \nLes voici : '),
(7, 'Vous souhaiter voir nos produits en stock actuellement ? Les voici :'),
(8, 'Vous êtes maintenant déconnecté, à bientôt !');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','client') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$UOC70iO80WD/i3J9Q2a0me51OTxcRPufkLvaOQ0YMcaOhUHmPf1WC', 'admin');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `keyword_response`
--
ALTER TABLE `keyword_response`
  ADD CONSTRAINT `fk_keyword` FOREIGN KEY (`keyword_id`) REFERENCES `keyword` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_response` FOREIGN KEY (`response_id`) REFERENCES `response` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
