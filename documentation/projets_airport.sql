SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+01:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `avions`;
CREATE TABLE IF NOT EXISTS `avions` (
                                        `id_avion` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l''avion',
                                        `immatriculation` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Immatriculation unique de l''avion',
                                        `modele` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Modèle de l''avion',
                                        `capacite` int NOT NULL COMMENT 'Capacité de passagers de l''avion',
                                        `id_compagnie` int DEFAULT NULL COMMENT 'Référence vers la compagnie aérienne',
                                        PRIMARY KEY (`id_avion`),
                                        UNIQUE KEY `immatriculation` (`immatriculation`),
                                        KEY `id_compagnie` (`id_compagnie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `compagnies_aeriennes`;
CREATE TABLE IF NOT EXISTS `compagnies_aeriennes` (
                                                      `id_compagnie` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la compagnie',
                                                      `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nom de la compagnie',
                                                      `pays` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Pays d''origine de la compagnie',
                                                      PRIMARY KEY (`id_compagnie`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
                                        `id_conge` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du congé',
                                        `id_pilote` int NOT NULL COMMENT 'Référence vers le pilote concerné',
                                        `date_debut` date NOT NULL COMMENT 'Date de début du congé',
                                        `date_fin` date NOT NULL COMMENT 'Date de fin du congé',
                                        PRIMARY KEY (`id_conge`),
                                        KEY `id_pilote` (`id_pilote`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `pilotes`;
CREATE TABLE IF NOT EXISTS `pilotes` (
                                         `id_pilote` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du pilote',
                                         `id_utilisateur` int NOT NULL COMMENT 'Lien avec l''utilisateur',
                                         `id_avion` int DEFAULT NULL COMMENT 'Avion affecté au pilote',
                                         `disponible` tinyint(1) DEFAULT '1' COMMENT 'Disponibilité du pilote pour un vol',
                                         PRIMARY KEY (`id_pilote`),
                                         UNIQUE KEY `id_utilisateur` (`id_utilisateur`),
                                         KEY `id_avion` (`id_avion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
                                              `id_reservation` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la réservation',
                                              `id_utilisateur` int NOT NULL COMMENT 'Référence vers l''utilisateur qui réserve',
                                              `id_vol` int NOT NULL COMMENT 'Référence vers le vol réservé',
                                              `classe` enum('Économique','Affaires','Première') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Économique' COMMENT 'Classe de la réservation',
                                              `statut` enum('confirmé','annulé','en attente') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'confirmé' COMMENT 'Statut de la réservation',
                                              `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de la réservation',
                                              PRIMARY KEY (`id_reservation`),
                                              KEY `id_utilisateur` (`id_utilisateur`),
                                              KEY `id_vol` (`id_vol`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
                                              `id_utilisateur` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l''utilisateur',
                                              `prenom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Prénom de l''utilisateur',
                                              `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nom de l''utilisateur',
                                              `telephone` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Numéro de téléphone de l''utilisateur',
                                              `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Email de l''utilisateur',
                                              `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Mot de passe (haché pour la sécurité)',
                                              `date_naissance` date NOT NULL COMMENT 'Date de naissance de l''utilisateur',
                                              `ville_residence` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Ville de résidence de l''utilisateur',
                                              `inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date d''inscription de l''utilisateur',
                                              PRIMARY KEY (`id_utilisateur`),
                                              UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `vols`;
CREATE TABLE IF NOT EXISTS `vols` (
                                      `id_vol` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du vol',
                                      `numero_vol` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Numéro unique du vol',
                                      `id_compagnie` int NOT NULL COMMENT 'Référence vers la compagnie opérant le vol',
                                      `id_avion` int NOT NULL COMMENT 'Référence vers l''avion utilisé',
                                      `aeroport_depart` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Aéroport de départ',
                                      `aeroport_arrivee` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Aéroport d''arrivée',
                                      `date_depart` datetime NOT NULL COMMENT 'Date et heure de départ',
                                      `date_arrivee` datetime NOT NULL COMMENT 'Date et heure d''arrivée',
                                      `prix` decimal(10,2) NOT NULL COMMENT 'Prix du vol',
                                      `statut` enum('prévu','en cours','retardé','annulé','terminé') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'prévu' COMMENT 'Statut du vol',
                                      PRIMARY KEY (`id_vol`),
                                      UNIQUE KEY `numero_vol` (`numero_vol`),
                                      KEY `id_compagnie` (`id_compagnie`),
                                      KEY `id_avion` (`id_avion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
