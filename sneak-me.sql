-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 15 mai 2025 à 11:41
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
-- Base de données : `sneak-me`
--

-- --------------------------------------------------------

--
-- Structure de la table `keyword`
--

DROP TABLE IF EXISTS `keyword`;
CREATE TABLE IF NOT EXISTS `keyword` (
  `id` int NOT NULL AUTO_INCREMENT,
  `keyword_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`keyword_name`)
) ENGINE=InnoDB AUTO_INCREMENT=86 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `keyword`
--

INSERT INTO `keyword` (`id`, `keyword_name`) VALUES
(77, 'article'),
(78, 'articles'),
(75, 'catalogue'),
(76, 'catalogues'),
(68, 'Inscription'),
(79, 'oui'),
(81, 'panne'),
(84, 'problème'),
(72, 'produit'),
(74, 'produits'),
(85, 'remboursement'),
(83, 'retour'),
(64, 'sav'),
(80, 'soucis');

-- --------------------------------------------------------

--
-- Structure de la table `keyword_response`
--

DROP TABLE IF EXISTS `keyword_response`;
CREATE TABLE IF NOT EXISTS `keyword_response` (
  `keyword_id` int NOT NULL,
  `response_id` int NOT NULL,
  PRIMARY KEY (`keyword_id`,`response_id`),
  UNIQUE KEY `unique_keyword_id` (`keyword_id`),
  KEY `fk_response` (`response_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `keyword_response`
--

INSERT INTO `keyword_response` (`keyword_id`, `response_id`) VALUES
(63, 81),
(64, 69),
(65, 78),
(66, 70),
(67, 82),
(68, 83),
(69, 84),
(70, 85),
(71, 86),
(72, 87),
(74, 87),
(75, 87),
(76, 87),
(77, 87),
(78, 87),
(80, 90),
(81, 90),
(82, 90),
(83, 90),
(84, 90),
(85, 90);

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `product`
--

INSERT INTO `product` (`id`, `title`, `description`, `price`, `image`) VALUES
(1, 'FORUM LOW CL UNISEX - Baskets basses', 'C’est l’un de nos articles les plus populaires ce mois-ci.', 120.00, 'FORUM LOW CL UNISEX - Baskets basses_adidas.png'),
(8, 'SAMBA OG - Baskets basses', 'Pour celles qui créent les tendances plutôt que de les suivre, la chaussure adidas Samba OG est un must-have. Conçue à l\'origine pour le football en salle, cette chaussure a depuis transcendé ses débuts sportifs. La tige en cuir premium et les empiècements en nubuck s\'associent pour former une silhouette iconique parfaite pour imposer ton style. Les détails dorés et les 3 bandes signatures sur les côtés rendent discrètement hommage à l\'héritage adidas. Un grand classique revisité pour les créatrices de tendances.', 125.00, 'SAMBA OG - Baskets basses_samba.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `response`
--

DROP TABLE IF EXISTS `response`;
CREATE TABLE IF NOT EXISTS `response` (
  `id` int NOT NULL AUTO_INCREMENT,
  `response_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `response`
--

INSERT INTO `response` (`id`, `response_name`) VALUES
(1, 'Merci d\'être inscrit !'),
(2, 'Bon retour parmi nous !'),
(3, 'Vous avez été déconnecté avec succès.'),
(4, 'Pour joindre notre service après vente vous pouvez contacter le 0865342154 munit de votre numéro de commande'),
(6, 'Vous souhaiter voir nos produits en stock actuellement ? \nLes voici : '),
(7, 'Vous souhaiter voir nos produits en stock actuellement ? Les voici :'),
(8, 'Vous êtes maintenant déconnecté, à bientôt !'),
(52, 'bonjour'),
(67, 'sav ?'),
(68, 'Pour joindre notre service après vente, vous pouvez contacter le 0865342154 munit de votre numéro de commande'),
(69, 'Vous souhaitez voir nos produits en stock ? les voici :'),
(70, 'réponse'),
(71, 'Connexion réussie'),
(81, 'Vous êtes inscrit'),
(83, 'Vous êtes inscrit !'),
(85, 'reponse en minuscule'),
(86, 'masjucule'),
(87, 'Souhaitez-vous voir notre catalogue ?'),
(89, 'réponse à oui'),
(90, 'Vous souhaitez contacter le service après vente ?');

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
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$UOC70iO80WD/i3J9Q2a0me51OTxcRPufkLvaOQ0YMcaOhUHmPf1WC', 'admin');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
