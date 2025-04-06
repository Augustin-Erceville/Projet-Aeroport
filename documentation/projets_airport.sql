SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

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
                                        `ref_compagnie` int DEFAULT NULL COMMENT 'Référence vers la compagnie aérienne',
                                        PRIMARY KEY (`id_avion`),
                                        KEY `id_compagnie` (`ref_compagnie`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `compagnies`;
CREATE TABLE IF NOT EXISTS `compagnies` (
                                            `id_compagnie` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la compagnie',
                                            `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Nom de la compagnie',
                                            `pays` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL COMMENT 'Pays d''origine de la compagnie',
                                            PRIMARY KEY (`id_compagnie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
                                        `id_conge` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du congé',
                                        `ref_pilote` int NOT NULL COMMENT 'Référence vers le pilote concerné',
                                        `date_debut` date NOT NULL COMMENT 'Date de début du congé',
                                        `date_fin` date NOT NULL COMMENT 'Date de fin du congé',
                                        PRIMARY KEY (`id_conge`),
                                        KEY `id_pilote` (`ref_pilote`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `pilotes`;
CREATE TABLE IF NOT EXISTS `pilotes` (
                                         `id_pilote` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du pilote',
                                         `ref_utilisateur` int NOT NULL COMMENT 'Lien avec l''utilisateur',
                                         `ref_avion` int DEFAULT NULL COMMENT 'Avion affecté au pilote',
                                         `disponible` enum('Disponible','En vol','En congé','Indisponible') DEFAULT 'Disponible' COMMENT 'Disponibilité du pilote pour un vol',
                                         PRIMARY KEY (`id_pilote`),
                                         UNIQUE KEY `id_utilisateur` (`ref_utilisateur`),
                                         KEY `id_avion` (`ref_avion`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
                                              `id_reservation` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la réservation',
                                              `ref_utilisateur` int NOT NULL COMMENT 'Référence vers l''utilisateur qui réserve',
                                              `ref_vol` int NOT NULL COMMENT 'Référence vers le vol réservé',
                                              `classe` enum('Économique','Affaires','Première') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'Économique' COMMENT 'Classe de la réservation',
                                              `statut` enum('confirmé','annulé','en attente') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'confirmé' COMMENT 'Statut de la réservation',
                                              `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de la réservation',
                                              PRIMARY KEY (`id_reservation`),
                                              KEY `id_vol` (`ref_vol`) USING BTREE,
                                              KEY `id_utilisateur` (`ref_utilisateur`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `vols`;
CREATE TABLE IF NOT EXISTS `vols` (
                                      `id_vol` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du vol',
                                      `numero_vol` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Numéro unique du vol',
                                      `ref_compagnie` int NOT NULL COMMENT 'Référence vers la compagnie opérant le vol',
                                      `ref_avion` int NOT NULL COMMENT 'Référence vers l''avion utilisé',
                                      `aeroport_depart` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Aéroport de départ',
                                      `aeroport_arrivee` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Aéroport d''arrivée',
                                      `date_depart` datetime NOT NULL COMMENT 'Date et heure de départ',
                                      `date_arrivee` datetime NOT NULL COMMENT 'Date et heure d''arrivée',
                                      `prix` decimal(10,2) NOT NULL COMMENT 'Prix du vol',
                                      `statut` enum('prévu','en cours','retardé','annulé','terminé') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'prévu' COMMENT 'Statut du vol',
                                      PRIMARY KEY (`id_vol`),
                                      KEY `id_compagnie` (`ref_compagnie`),
                                      KEY `id_avion` (`ref_avion`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
