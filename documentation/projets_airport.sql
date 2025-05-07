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
                                        `immatriculation` varchar(20) NOT NULL COMMENT 'Immatriculation',
                                        `modele` varchar(50) NOT NULL COMMENT 'Modèle',
                                        `capacite` int NOT NULL COMMENT 'Capacité',
                                        `ref_compagnie` int DEFAULT NULL COMMENT 'Référence compagnie',
                                        PRIMARY KEY (`id_avion`),
                                        KEY `ref_compagnie` (`ref_compagnie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `compagnies`;
CREATE TABLE IF NOT EXISTS `compagnies` (
                                            `id_compagnie` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la compagnie',
                                            `nom` varchar(100) NOT NULL COMMENT 'Nom de la compagnie',
                                            `pays` varchar(50) DEFAULT NULL COMMENT 'Pays',
                                            PRIMARY KEY (`id_compagnie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
                                        `id_conge` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du congé',
                                        `ref_pilote` int NOT NULL COMMENT 'Référence pilote',
                                        `date_debut` date NOT NULL COMMENT 'Début',
                                        `date_fin` date NOT NULL COMMENT 'Fin',
                                        PRIMARY KEY (`id_conge`),
                                        KEY `ref_pilote` (`ref_pilote`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `pilotes`;
CREATE TABLE IF NOT EXISTS `pilotes` (
                                         `id_pilote` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du pilote',
                                         `ref_utilisateur` int NOT NULL COMMENT 'Référence utilisateur',
                                         `ref_avion` int DEFAULT NULL COMMENT 'Référence avion',
                                         `disponible` enum('Disponible','En vol','En congé','Indisponible') DEFAULT 'Disponible' COMMENT 'Disponibilité',
                                         PRIMARY KEY (`id_pilote`),
                                         UNIQUE KEY `ref_utilisateur` (`ref_utilisateur`),
                                         KEY `ref_avion` (`ref_avion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
                                              `id_reservation` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la réservation',
                                              `ref_utilisateur` int NOT NULL COMMENT 'Référence utilisateur',
                                              `ref_vol` int NOT NULL COMMENT 'Référence vol',
                                              `classe` enum('Économique','Affaires','Première') DEFAULT 'Économique' COMMENT 'Classe',
                                              `statut` enum('confirmé','annulé','en attente') DEFAULT 'confirmé' COMMENT 'Statut réservation',
                                              `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP COMMENT 'Date de réservation',
                                              PRIMARY KEY (`id_reservation`),
                                              KEY `ref_utilisateur` (`ref_utilisateur`),
                                              KEY `ref_vol` (`ref_vol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
                                              `id_utilisateur` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l''utilisateur',
                                              `prenom` varchar(50) NOT NULL COMMENT 'Prénom',
                                              `nom` varchar(50) NOT NULL COMMENT 'Nom',
                                              `telephone` varchar(13) NOT NULL COMMENT 'Téléphone',
                                              `email` varchar(100) NOT NULL COMMENT 'Email',
                                              `mot_de_passe` varchar(255) NOT NULL COMMENT 'Mot de passe',
                                              `date_naissance` date NOT NULL COMMENT 'Date de naissance',
                                              `ville_residence` varchar(50) NOT NULL COMMENT 'Ville de résidence',
                                              `inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Date d''inscription',
                                              PRIMARY KEY (`id_utilisateur`),
                                              UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

DROP TABLE IF EXISTS `vols`;
CREATE TABLE IF NOT EXISTS `vols` (
                                      `id_vol` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du vol',
                                      `numero_vol` varchar(10) NOT NULL COMMENT 'Numéro du vol',
                                      `ref_compagnie` int NOT NULL COMMENT 'Référence compagnie',
                                      `ref_avion` int NOT NULL COMMENT 'Référence avion',
                                      `aeroport_depart` varchar(100) NOT NULL COMMENT 'Aéroport départ',
                                      `aeroport_arrivee` varchar(100) NOT NULL COMMENT 'Aéroport arrivée',
                                      `date_depart` datetime NOT NULL COMMENT 'Départ',
                                      `date_arrivee` datetime NOT NULL COMMENT 'Arrivée',
                                      `prix` decimal(10,2) NOT NULL COMMENT 'Prix',
                                      `statut` enum('prévu','en cours','retardé','annulé','terminé') DEFAULT 'prévu' COMMENT 'Statut',
                                      PRIMARY KEY (`id_vol`),
                                      KEY `ref_compagnie` (`ref_compagnie`),
                                      KEY `ref_avion` (`ref_avion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


ALTER TABLE `avions`
    ADD CONSTRAINT `fk_avions_compagnie` FOREIGN KEY (`ref_compagnie`) REFERENCES `compagnies` (`id_compagnie`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `conges`
    ADD CONSTRAINT `fk_conges_pilote` FOREIGN KEY (`ref_pilote`) REFERENCES `pilotes` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pilotes`
    ADD CONSTRAINT `fk_pilotes_avion` FOREIGN KEY (`ref_avion`) REFERENCES `avions` (`id_avion`) ON DELETE SET NULL ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_pilotes_utilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `reservations`
    ADD CONSTRAINT `fk_reservations_utilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_reservations_vol` FOREIGN KEY (`ref_vol`) REFERENCES `vols` (`id_vol`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `vols`
    ADD CONSTRAINT `fk_vols_avion` FOREIGN KEY (`ref_avion`) REFERENCES `avions` (`id_avion`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_vols_compagnie` FOREIGN KEY (`ref_compagnie`) REFERENCES `compagnies` (`id_compagnie`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
