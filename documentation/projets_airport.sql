SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT;
SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS;
SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION;
SET NAMES utf8mb4;

DROP TABLE IF EXISTS `avions`;
CREATE TABLE IF NOT EXISTS `avions` (
                                        `id_avion` int NOT NULL AUTO_INCREMENT,
                                        `immatriculation` varchar(20) NOT NULL,
                                        `modele` varchar(50) NOT NULL,
                                        `capacite` int NOT NULL,
                                        `ref_compagnie` int DEFAULT NULL,
                                        PRIMARY KEY (`id_avion`),
                                        KEY `ref_compagnie` (`ref_compagnie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `avions` (`id_avion`, `immatriculation`, `modele`, `capacite`, `ref_compagnie`) VALUES
                                                                                                (1, 'AF1234', 'Airbus A320', 180, 1),
                                                                                                (2, 'DL5678', 'Boeing 737', 160, 2),
                                                                                                (3, 'LH9012', 'Airbus A350', 300, 3),
                                                                                                (4, 'EK3456', 'Boeing 777', 350, 4),
                                                                                                (5, 'QF7890', 'Airbus A380', 500, 1),
                                                                                                (6, 'EF3978', 'Boeing 777', 350, 2),
                                                                                                (7, 'FR4979', 'Airbus A380', 520, 1),
                                                                                                (8, 'AF7456', 'Airbus A320', 215, 1);

DROP TABLE IF EXISTS `compagnies`;
CREATE TABLE IF NOT EXISTS `compagnies` (
                                            `id_compagnie` int NOT NULL AUTO_INCREMENT,
                                            `nom` varchar(100) NOT NULL,
                                            `pays` varchar(50) DEFAULT NULL,
                                            PRIMARY KEY (`id_compagnie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `compagnies` (`id_compagnie`, `nom`, `pays`) VALUES
                                                             (1, 'Air France', 'France'),
                                                             (2, 'Delta Airlines', 'États-Unis'),
                                                             (3, 'Lufthansa', 'Allemagne'),
                                                             (4, 'Emirates', 'Émirats Arabes Unis'),
                                                             (5, 'Qantas', 'Australie');

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
                                        `id_conge` int NOT NULL AUTO_INCREMENT,
                                        `ref_pilote` int NOT NULL,
                                        `date_debut` date NOT NULL,
                                        `date_fin` date NOT NULL,
                                        PRIMARY KEY (`id_conge`),
                                        KEY `ref_pilote` (`ref_pilote`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `conges` (`id_conge`, `ref_pilote`, `date_debut`, `date_fin`) VALUES
    (1, 3, '2025-05-07', '2025-05-24');

DROP TABLE IF EXISTS `pilotes`;
CREATE TABLE IF NOT EXISTS `pilotes` (
                                         `id_pilote` int NOT NULL AUTO_INCREMENT,
                                         `ref_utilisateur` int NOT NULL,
                                         `ref_avion` int DEFAULT NULL,
                                         `disponible` enum('Disponible','En vol','En congé','Indisponible') DEFAULT 'Disponible',
                                         PRIMARY KEY (`id_pilote`),
                                         UNIQUE KEY `ref_utilisateur` (`ref_utilisateur`),
                                         KEY `ref_avion` (`ref_avion`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `pilotes` (`id_pilote`, `ref_utilisateur`, `ref_avion`, `disponible`) VALUES
                                                                                      (1, 1, 4, 'En vol'),
                                                                                      (3, 2, 8, 'Indisponible');

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE IF NOT EXISTS `reservations` (
                                              `id_reservation` int NOT NULL AUTO_INCREMENT,
                                              `ref_utilisateur` int NOT NULL,
                                              `ref_vol` int NOT NULL,
                                              `classe` enum('Économique','Affaires','Première') DEFAULT 'Économique',
                                              `statut` enum('confirmé','annulé','en attente') DEFAULT 'confirmé',
                                              `date_reservation` datetime DEFAULT CURRENT_TIMESTAMP,
                                              PRIMARY KEY (`id_reservation`),
                                              KEY `ref_utilisateur` (`ref_utilisateur`),
                                              KEY `ref_vol` (`ref_vol`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `reservations` (`id_reservation`, `ref_utilisateur`, `ref_vol`, `classe`, `statut`, `date_reservation`) VALUES
                                                                                                                        (6, 1, 1, 'Affaires', 'confirmé', '2025-05-08 19:33:00'),
                                                                                                                        (8, 5, 1, 'Économique', 'confirmé', '2025-05-07 18:06:00');

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
                                              `id_utilisateur` int NOT NULL AUTO_INCREMENT,
                                              `prenom` varchar(50) NOT NULL,
                                              `nom` varchar(50) NOT NULL,
                                              `telephone` varchar(13) NOT NULL,
                                              `email` varchar(100) NOT NULL,
                                              `mot_de_passe` varchar(255) NOT NULL,
                                              `date_naissance` date NOT NULL,
                                              `ville_residence` varchar(50) NOT NULL,
                                              `inscription` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                              PRIMARY KEY (`id_utilisateur`),
                                              UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `utilisateurs` (`id_utilisateur`, `prenom`, `nom`, `telephone`, `email`, `mot_de_passe`, `date_naissance`, `ville_residence`, `inscription`) VALUES
                                                                                                                                                             (1, 'Augustin', 'd\'Erceville', '0782706356', 'a.erceville2000@gmail.com', '$2y$10$Z3m6PKE7LxMtS39PN8Xce.M4wx8l.Obp.q05szWqnP34ck9Ff4TmS', '2000-09-22', 'Paris', '2025-05-07 09:12:07'),
                                                                                                                                                             (2, 'Marc', 'Jodoin', '0141330655', 'MarcJodoin@jourrapide.com', '$2y$10$UV0d27KFrSjvMN4BmJZRI.My73l1LgvcBneUqtJqD7ZebF4QoKGkS', '1992-07-29', 'Paris', '2025-05-08 16:37:10'),
                                                                                                                                                             (3, 'Lucas', 'Martin', '0612345678', 'lucas.martin@example.com', '$2y$10$abcdefghijklmnopqrstuv', '1995-03-15', 'Paris', '2025-05-08 16:52:23'),
                                                                                                                                                             (4, 'Emma', 'Durand', '0623456789', 'emma.durand@example.com', '$2y$10$abcdefghijklmnopqrstuv', '1998-07-22', 'Lyon', '2025-05-08 16:52:23'),
                                                                                                                                                             (5, 'Nathan', 'Bernard', '0634567890', 'nathan.bernard@example.com', '$2y$10$abcdefghijklmnopqrstuv', '1992-11-05', 'Marseille', '2025-05-08 16:52:23'),
                                                                                                                                                             (6, 'Chloé', 'Petit', '0645678901', 'chloe.petit@example.com', '$2y$10$abcdefghijklmnopqrstuv', '2000-01-30', 'Toulouse', '2025-05-08 16:52:23');

DROP TABLE IF EXISTS `vols`;
CREATE TABLE IF NOT EXISTS `vols` (
                                      `id_vol` int NOT NULL AUTO_INCREMENT,
                                      `numero_vol` varchar(10) NOT NULL,
                                      `ref_compagnie` int NOT NULL,
                                      `ref_avion` int NOT NULL,
                                      `aeroport_depart` varchar(100) NOT NULL,
                                      `aeroport_arrivee` varchar(100) NOT NULL,
                                      `date_depart` datetime NOT NULL,
                                      `date_arrivee` datetime NOT NULL,
                                      `prix` decimal(10,2) NOT NULL,
                                      `statut` enum('prévu','en cours','retardé','annulé','terminé') DEFAULT 'prévu',
                                      PRIMARY KEY (`id_vol`),
                                      KEY `ref_compagnie` (`ref_compagnie`),
                                      KEY `ref_avion` (`ref_avion`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `vols` (`id_vol`, `numero_vol`, `ref_compagnie`, `ref_avion`, `aeroport_depart`, `aeroport_arrivee`, `date_depart`, `date_arrivee`, `prix`, `statut`) VALUES
                                                                                                                                                                      (1, 'AF105', 1, 1, 'Paris CDG', 'New York JFK', '2025-06-01 10:00:00', '2025-06-01 13:00:00', 450.00, 'prévu'),
                                                                                                                                                                      (2, 'DL202', 2, 2, 'Atlanta ATL', 'Los Angeles LAX', '2025-06-02 15:00:00', '2025-06-02 17:30:00', 300.00, 'prévu'),
                                                                                                                                                                      (3, 'LH303', 3, 3, 'Francfort FRA', 'Tokyo HND', '2025-06-03 09:00:00', '2025-06-03 23:00:00', 800.00, 'prévu'),
                                                                                                                                                                      (4, 'EK404', 4, 4, 'Dubaï DXB', 'Sydney SYD', '2025-06-04 22:00:00', '2025-06-05 06:00:00', 1200.00, 'prévu'),
                                                                                                                                                                      (5, 'QF505', 3, 2, 'Sydney SYD', 'Singapour SIN', '2025-06-05 14:00:00', '2025-06-05 20:00:00', 600.00, 'prévu'),
                                                                                                                                                                      (7, 'RE547', 2, 2, 'Paris', 'Marseille', '2025-05-08 12:00:00', '2025-05-08 15:00:00', 29.00, 'prévu'),
                                                                                                                                                                      (8, 'DL875', 2, 2, 'Paris', 'Lille', '2025-05-15 19:00:00', '2025-05-15 21:00:00', 48.00, 'annulé');

COMMIT;

SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT;
SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS;
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION;
