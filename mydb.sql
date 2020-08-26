-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 02 mai 2019 à 16:36
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `mydb`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidature`
--

DROP TABLE IF EXISTS `candidature`;
CREATE TABLE IF NOT EXISTS `candidature` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_client` int(255) NOT NULL,
  `id_chien` int(255) NOT NULL,
  `presentation` varchar(255) NOT NULL,
  `id_maitre` int(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'attente',
  PRIMARY KEY (`id`),
  KEY `fk_constraint` (`id_chien`),
  KEY `fk_constraint2` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `candidature`
--

INSERT INTO `candidature` (`id`, `id_client`, `id_chien`, `presentation`, `id_maitre`, `status`) VALUES
(18, 27, 28, 'je suis étudiante', 26, 'accepter');

-- --------------------------------------------------------

--
-- Structure de la table `chien`
--

DROP TABLE IF EXISTS `chien`;
CREATE TABLE IF NOT EXISTS `chien` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `naissance` date NOT NULL,
  `race` varchar(50) NOT NULL,
  `id_user` int(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sexe` varchar(5) NOT NULL,
  `presentation` varchar(255) NOT NULL,
  `adoptable` varchar(50) NOT NULL DEFAULT 'oui',
  PRIMARY KEY (`id`),
  KEY `test` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `chien`
--

INSERT INTO `chien` (`id`, `nom`, `naissance`, `race`, `id_user`, `url`, `sexe`, `presentation`, `adoptable`) VALUES
(28, 'rex', '2018-04-19', 'border collie', 27, 'photo5ccb1b12b01b2.jpg', 'F', 'un chien très gentil ', 'non');

-- --------------------------------------------------------

--
-- Structure de la table `mess`
--

DROP TABLE IF EXISTS `mess`;
CREATE TABLE IF NOT EXISTS `mess` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `id_expediteur` int(255) NOT NULL,
  `id_destinataire` int(255) NOT NULL,
  `message` text NOT NULL,
  `date_envoi` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `id_expediteur` (`id_expediteur`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mess`
--

INSERT INTO `mess` (`id`, `id_expediteur`, `id_destinataire`, `message`, `date_envoi`) VALUES
(7, 4, 22, 'je suis admin max ', '2019-04-29 20:37:38'),
(15, 4, 22, 'fqdf', '2019-04-29 23:32:02'),
(16, 4, 22, 'fsfsdf', '2019-04-29 23:34:15'),
(17, 4, 21, 'dis moi ton problème quentin ? ', '2019-04-29 23:39:33'),
(18, 27, 26, 'bonjour ton chien est gentil ? ', '2019-05-02 18:32:01'),
(19, 26, 27, 'oui vraiment mignon comme toi fabrizio ', '2019-05-02 18:32:21');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `mdp` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `role` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `mdp`, `email`, `pseudo`, `role`) VALUES
(4, 'admin', 'admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'admin@hotmail.com', 'admin', 'admin'),
(26, 'legrand', 'william', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'clement@hotmail.com', 'clement', 'user'),
(27, 'chiara', 'manunta', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'chiara@hotmail.com', 'chiara', 'user');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidature`
--
ALTER TABLE `candidature`
  ADD CONSTRAINT `fk_constraint` FOREIGN KEY (`id_chien`) REFERENCES `chien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_constraint2` FOREIGN KEY (`id_client`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `chien`
--
ALTER TABLE `chien`
  ADD CONSTRAINT `test` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `mess`
--
ALTER TABLE `mess`
  ADD CONSTRAINT `mess_ibfk_1` FOREIGN KEY (`id_expediteur`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
