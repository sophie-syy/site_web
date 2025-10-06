CREATE DATABASE IF NOT EXISTS ue_compte;
USE ue_compte;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ue_compte`
--

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `prix` int NOT NULL,
  `quantité` int NOT NULL,
  `user_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL,
  `type` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `commentaire` varchar(255) NOT NULL,
  `prix` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `type`, `nom`, `commentaire`, `prix`) VALUES
(1, 'glace', 'café&vanille', '', 1),
(2, 'glace', 'chataigne', '', 1),
(3, 'glace', 'chocolat', '', 1),
(4, 'glace', 'chocolat&vanille', '', 1),
(5, 'glace', 'citron&vanille', '', 1),
(6, 'glace', 'fraise', '', 1),
(7, 'glace', 'haricot-vert', '', 1),
(8, 'glace', 'pêche', '', 1),
(9, 'glace', 'litchi', '', 1),
(10, 'glace', 'longjing', '', 1),
(11, 'glace', 'matcha', '', 1),
(14, 'glace', 'raisin', '', 1),
(15, 'glace', 'taro', '', 1),
(16, 'glace', 'taro&vanille', '', 1),
(17, 'glace', 'vanille', '', 1),
(18, 'glace', 'litchi&rose', '', 1),
(12, 'glace', 'matcha&haricot-rouge_l', '', 2),
(13, 'glace', 'matcha&oréo_l', '', 2),
(19, 'glace', 'fraise_l', '', 2),
(51, 'glace', 'mange_l', '', 2),
(20, 'jus-de-fruit', 'ananas&orange', '', 4),
(21, 'jus-de-fruit', 'citron', '', 4),
(22, 'jus-de-fruit', 'fraise', '', 4),
(23, 'jus-de-fruit', 'fraise&orange', '', 4),
(24, 'jus-de-fruit', 'mange', '', 4),
(25, 'jus-de-fruit', 'maracuja', '', 4),
(26, 'jus-de-fruit', 'orange', '', 4),
(27, 'jus-de-fruit', 'pêche', '', 4),
(28, 'jus-de-fruit', 'raisin', '', 4),
(29, 'jus-de-fruit', 'kiwi', '', 4),
(30, 'mousse-de-lait', 'fraise', 'fromage, lait, fraise', 4),
(31, 'mousse-de-lait', 'matcha', 'fromage, lait, matcha', 4),
(32, 'mousse-de-lait', 'pêche', 'fromage, lait, pêche', 4),
(33, 'mousse-de-lait', 'raisin', 'fromage, lait, raisin', 4),
(34, 'mousse-de-lait', 'thé-lait', 'fromage, lait, thé au lait', 4),
(35, 'mousse-de-lait', 'thé-oolong', 'fromage, lait, thé oolong', 4),
(36, 'mousse-de-lait', 'thé-rouge', 'fromage, lait, thé rouge', 4),
(37, 'shake', 'boba', 'glace vanille/chocolat, lait au chocolat, boule-manioc', 4),
(38, 'shake', 'fraise', 'glace vanille/fraise, jus fraise', 4),
(39, 'shake', 'mange', 'glace vanille/mange, jus mange', 4),
(40, 'shake', 'mélange', 'glace fraise/vanille, jus fraise/orange/pêche', 4),
(41, 'shake', 'pêche', 'glace vanille/pêche, jus pêche', 4),
(42, 'thé', 'aricot-rouge', 'thé, aricot-rouge, lait', 4),
(43, 'thé', 'boule-manioc', 'thé, boule-manioc, lait', 4),
(44, 'thé', 'boule-manioc&sucre', 'thé, boule-manioc, lait, sucre fondu', 4),
(45, 'thé', 'boule-taro', 'thé, boule-taro, lait', 4),
(46, 'thé', 'gelée-coco', 'thé, gelée de coco, lait', 4),
(47, 'thé', 'match&aricot', 'thé matcha, lait, haricot-rouge', 4),
(48, 'thé', 'matcha&fraise', 'thé matcha, lait, fraise', 4),
(49, 'thé', 'melange', 'thé, lait, boule-taro, aricot rouge, boule-manioc', 4),
(50, 'thé', 'melon', 'thé, melon, lait, boule-taro', 4);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_admin` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`) VALUES
(8, 'test', 'test@gmail.com', '$2y$10$A5bg/YPkQoiYxuzmzq6M1O1Agc8UZJyLqzVfbLS4rvRjJstcxgfFy');
COMMIT;

UPDATE users SET is_admin = 1 WHERE email = 'test@gmail.com';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
