CREATE DATABASE IF NOT EXISTS SubMarineSerie;
use SubMarineSerie;

DROP TABLE IF EXISTS `regarde`;
DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `traitement`;
DROP TABLE IF EXISTS `series`;


CREATE TABLE IF NOT EXISTS `user` (
  `identifiant` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civilite` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_Naissance` Date COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_Admin` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`identifiant`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `serie` (
  `id_Serie` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom_Serie` varchar(50)  NOT NULL,
  `genre_theme` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_Saison`  int UNSIGNED DEFAULT NULL,
  `notation` int UNSIGNED DEFAULT NULL,
  `version` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_Serie`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE IF NOT EXISTS `traitement` (
  `id_Traitement` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `mot` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serie` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_Serie` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id_Traitement`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `regarde` (
  `identifiant` int UNSIGNED NOT NULL,
  `id_Serie` int UNSIGNED NOT NULL,
  PRIMARY KEY `user` (`identifiant`),
  KEY `serie` (`id_Serie`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `regarde`
  ADD CONSTRAINT `identifiant_fk_1` FOREIGN KEY (`identifiant`) REFERENCES `user` (`identifiant`) ON DELETE CASCADE,
  ADD CONSTRAINT `nom_Serie_fk_2` FOREIGN KEY (`id_Serie`) REFERENCES `serie` (`id_Serie`) ON DELETE CASCADE ON UPDATE RESTRICT;


ALTER TABLE `traitement`
  ADD CONSTRAINT `traitement_fk` FOREIGN KEY (`id_Serie`) REFERENCES `serie` (`id_Serie`) ON DELETE CASCADE;

