-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 09 mai 2025 à 09:38
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projets_airport`
--

-- --------------------------------------------------------

--
-- Structure de la table `avions`
--

DROP TABLE IF EXISTS `avions`;
CREATE TABLE IF NOT EXISTS `avions` (
  `id_avion` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de l''avion',
  `immatriculation` varchar(20) NOT NULL COMMENT 'Immatriculation',
  `modele` varchar(50) NOT NULL COMMENT 'Modèle',
  `capacite` int NOT NULL COMMENT 'Capacité',
  `ref_compagnie` int DEFAULT NULL COMMENT 'Référence compagnie',
  PRIMARY KEY (`id_avion`),
  KEY `ref_compagnie` (`ref_compagnie`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `avions`
--

INSERT INTO `avions` (`id_avion`, `immatriculation`, `modele`, `capacite`, `ref_compagnie`) VALUES
(1, 'AF1234', 'Airbus A320', 180, 1),
(2, 'DL5678', 'Boeing 737', 160, 2),
(3, 'LH9012', 'Airbus A350', 300, 3),
(4, 'EK3456', 'Boeing 777', 350, 4),
(5, 'QF7890', 'Airbus A380', 500, 1),
(6, 'EF3978', 'Boeing 777', 350, 2),
(7, 'FR4979', 'Airbus A380', 520, 1),
(8, 'AF7456', 'Airbus A320', 215, 1);

-- --------------------------------------------------------

--
-- Structure de la table `compagnies`
--

DROP TABLE IF EXISTS `compagnies`;
CREATE TABLE IF NOT EXISTS `compagnies` (
  `id_compagnie` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique de la compagnie',
  `nom` varchar(100) NOT NULL COMMENT 'Nom de la compagnie',
  `pays` varchar(50) DEFAULT NULL COMMENT 'Pays',
  PRIMARY KEY (`id_compagnie`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `compagnies`
--

INSERT INTO `compagnies` (`id_compagnie`, `nom`, `pays`) VALUES
(1, 'Air France', 'France'),
(2, 'Delta Airlines', 'États-Unis'),
(3, 'Lufthansa', 'Allemagne'),
(4, 'Emirates', 'Émirats Arabes Unis'),
(5, 'Qantas', 'Australie');

-- --------------------------------------------------------

--
-- Structure de la table `conges`
--

DROP TABLE IF EXISTS `conges`;
CREATE TABLE IF NOT EXISTS `conges` (
  `id_conge` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du congé',
  `ref_pilote` int NOT NULL COMMENT 'Référence pilote',
  `date_debut` date NOT NULL COMMENT 'Début',
  `date_fin` date NOT NULL COMMENT 'Fin',
  PRIMARY KEY (`id_conge`),
  KEY `ref_pilote` (`ref_pilote`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `conges`
--

INSERT INTO `conges` (`id_conge`, `ref_pilote`, `date_debut`, `date_fin`) VALUES
(3, 7, '2025-05-19', '2025-06-20');

-- --------------------------------------------------------

--
-- Structure de la table `pilotes`
--

DROP TABLE IF EXISTS `pilotes`;
CREATE TABLE IF NOT EXISTS `pilotes` (
  `id_pilote` int NOT NULL AUTO_INCREMENT COMMENT 'Identifiant unique du pilote',
  `ref_utilisateur` int NOT NULL COMMENT 'Référence utilisateur',
  `ref_avion` int DEFAULT NULL COMMENT 'Référence avion',
  `disponible` enum('Disponible','En vol','En congé','Indisponible') DEFAULT 'Disponible' COMMENT 'Disponibilité',
  PRIMARY KEY (`id_pilote`),
  UNIQUE KEY `ref_utilisateur` (`ref_utilisateur`),
  KEY `ref_avion` (`ref_avion`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `pilotes`
--

INSERT INTO `pilotes` (`id_pilote`, `ref_utilisateur`, `ref_avion`, `disponible`) VALUES
(6, 5, 4, 'Disponible'),
(7, 3, 8, 'Indisponible'),
(8, 6, 4, 'Disponible');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `ref_utilisateur`, `ref_vol`, `classe`, `statut`, `date_reservation`) VALUES
(8, 5, 1, 'Économique', 'confirmé', '2025-05-07 18:06:00'),
(9, 15, 7, 'Affaires', 'confirmé', '2025-05-09 04:13:45'),
(10, 15, 8, 'Affaires', 'confirmé', '2025-05-09 04:13:49'),
(11, 15, 8, 'Affaires', 'confirmé', '2025-05-09 04:14:12'),
(12, 15, 5, 'Première', 'confirmé', '2025-05-09 04:30:05'),
(14, 17, 8, 'Affaires', 'confirmé', '2025-05-09 11:05:33');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

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
  `role` enum('Client','Administrateur') NOT NULL DEFAULT 'Client' COMMENT 'Rôle de l''utilisateur',
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `prenom`, `nom`, `telephone`, `email`, `mot_de_passe`, `date_naissance`, `ville_residence`, `inscription`, `role`) VALUES
(3, 'Lucas', 'Martin', '0612345678', 'lucas.martin@example.com', '$2y$10$abcdefghijklmnopqrstuv', '1995-03-15', 'Paris', '2025-05-08 16:52:23', 'Client'),
(4, 'Emma', 'Durand', '0623456789', 'emma.durand@example.com', '$2y$10$abcdefghijklmnopqrstuv', '1998-07-22', 'Lyon', '2025-05-08 16:52:23', 'Client'),
(5, 'Nathan', 'Bernard', '0634567890', 'nathan.bernard@example.com', '$2y$10$abcdefghijklmnopqrstuv', '1992-11-05', 'Marseille', '2025-05-08 16:52:23', 'Client'),
(6, 'Chloé', 'Petit', '0645678901', 'chloe.petit@example.com', '$2y$10$abcdefghijklmnopqrstuv', '2000-01-30', 'Toulouse', '2025-05-08 16:52:23', 'Client'),
(15, 'Augustin', 'Erceville', '0782706356', 'a.erceville2000@gmail.com', '$2y$10$6/plG7s8RmdLhZATFKeRkeEwOj4wypBVnVQQrQBeygxfLCDJpnJka', '2000-09-22', 'Villemomble', '2025-05-09 03:39:28', 'Administrateur'),
(17, 'Marc', 'Jodoin', '0141330655', 'MarcJodoin@jourrapide.com', '$2y$10$qEaWhfamLoW5gikjloIiDev53CimT3qfZ1wZUEl16oXzKebP6bvYa', '1992-07-29', 'Paris', '2025-05-09 10:39:57', 'Client');

-- --------------------------------------------------------

--
-- Structure de la table `vols`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `vols`
--

INSERT INTO `vols` (`id_vol`, `numero_vol`, `ref_compagnie`, `ref_avion`, `aeroport_depart`, `aeroport_arrivee`, `date_depart`, `date_arrivee`, `prix`, `statut`) VALUES
(1, 'AF105', 1, 1, 'Paris CDG', 'New York JFK', '2025-06-01 10:00:00', '2025-06-01 13:00:00', 450.00, 'prévu'),
(2, 'DL202', 2, 2, 'Atlanta ATL', 'Los Angeles LAX', '2025-06-02 15:00:00', '2025-06-02 17:30:00', 300.00, 'prévu'),
(3, 'LH303', 3, 3, 'Francfort FRA', 'Tokyo HND', '2025-06-03 09:00:00', '2025-06-03 23:00:00', 800.00, 'prévu'),
(4, 'EK404', 4, 4, 'Dubaï DXB', 'Sydney SYD', '2025-06-04 22:00:00', '2025-06-05 06:00:00', 1200.00, 'prévu'),
(5, 'QF505', 3, 2, 'Sydney SYD', 'Singapour SIN', '2025-06-05 14:00:00', '2025-06-05 20:00:00', 600.00, 'prévu'),
(7, 'RE547', 2, 2, 'Paris', 'Marseille', '2025-05-08 12:00:00', '2025-05-08 15:00:00', 29.00, 'prévu'),
(8, 'DL875', 2, 2, 'Paris', 'Lille', '2025-05-15 19:00:00', '2025-05-15 21:00:00', 48.00, 'annulé');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_avions`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_avions`;
CREATE TABLE IF NOT EXISTS `v_avions` (
`Capacité` int
,`Compagnie` varchar(100)
,`ID` int
,`Immatriculation` varchar(20)
,`Modèle` varchar(50)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_conges`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_conges`;
CREATE TABLE IF NOT EXISTS `v_conges` (
`Date Début` date
,`Date Fin` date
,`ID` int
,`Pilote` varchar(101)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_pilote`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_pilote`;
CREATE TABLE IF NOT EXISTS `v_pilote` (
`Disponibilité` enum('Disponible','En vol','En congé','Indisponible')
,`ID` int
,`Immatriculation` varchar(20)
,`Nom` varchar(101)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_reservations`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_reservations`;
CREATE TABLE IF NOT EXISTS `v_reservations` (
`Classe` enum('Économique','Affaires','Première')
,`Date` datetime
,`DateDepart` datetime
,`Destination` varchar(100)
,`ID` int
,`Statut` enum('confirmé','annulé','en attente')
,`Utilisateur` varchar(101)
,`Vol` varchar(10)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `v_vols`
-- (Voir ci-dessous la vue réelle)
--
DROP VIEW IF EXISTS `v_vols`;
CREATE TABLE IF NOT EXISTS `v_vols` (
`Avion` varchar(20)
,`Aéroport arrivée` varchar(100)
,`Aéroport départ` varchar(100)
,`Compagnie` varchar(100)
,`Date arrivée` datetime
,`Date départ` datetime
,`ID` int
,`Numéro vol` varchar(10)
,`Prix` decimal(10,2)
,`Statut` enum('prévu','en cours','retardé','annulé','terminé')
);

-- --------------------------------------------------------

--
-- Structure de la vue `v_avions`
--
DROP TABLE IF EXISTS `v_avions`;

DROP VIEW IF EXISTS `v_avions`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_avions`  AS SELECT `avions`.`id_avion` AS `ID`, `avions`.`immatriculation` AS `Immatriculation`, `avions`.`modele` AS `Modèle`, `avions`.`capacite` AS `Capacité`, `compagnies`.`nom` AS `Compagnie` FROM (`avions` left join `compagnies` on((`avions`.`ref_compagnie` = `compagnies`.`id_compagnie`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_conges`
--
DROP TABLE IF EXISTS `v_conges`;

DROP VIEW IF EXISTS `v_conges`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_conges`  AS SELECT `c`.`id_conge` AS `ID`, concat(`u`.`prenom`,' ',`u`.`nom`) AS `Pilote`, `c`.`date_debut` AS `Date Début`, `c`.`date_fin` AS `Date Fin` FROM ((`conges` `c` join `pilotes` `p` on((`c`.`ref_pilote` = `p`.`id_pilote`))) join `utilisateurs` `u` on((`p`.`ref_utilisateur` = `u`.`id_utilisateur`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_pilote`
--
DROP TABLE IF EXISTS `v_pilote`;

DROP VIEW IF EXISTS `v_pilote`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_pilote`  AS SELECT `pilotes`.`id_pilote` AS `ID`, concat(`utilisateurs`.`prenom`,' ',`utilisateurs`.`nom`) AS `Nom`, `avions`.`immatriculation` AS `Immatriculation`, `pilotes`.`disponible` AS `Disponibilité` FROM ((`pilotes` left join `utilisateurs` on((`pilotes`.`ref_utilisateur` = `utilisateurs`.`id_utilisateur`))) left join `avions` on((`pilotes`.`ref_avion` = `avions`.`id_avion`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_reservations`
--
DROP TABLE IF EXISTS `v_reservations`;

DROP VIEW IF EXISTS `v_reservations`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_reservations`  AS SELECT `r`.`id_reservation` AS `ID`, concat(`u`.`prenom`,' ',`u`.`nom`) AS `Utilisateur`, `v`.`numero_vol` AS `Vol`, `v`.`aeroport_arrivee` AS `Destination`, `v`.`date_depart` AS `DateDepart`, `r`.`classe` AS `Classe`, `r`.`statut` AS `Statut`, `r`.`date_reservation` AS `Date` FROM ((`reservations` `r` join `utilisateurs` `u` on((`r`.`ref_utilisateur` = `u`.`id_utilisateur`))) join `vols` `v` on((`r`.`ref_vol` = `v`.`id_vol`))) ;

-- --------------------------------------------------------

--
-- Structure de la vue `v_vols`
--
DROP TABLE IF EXISTS `v_vols`;

DROP VIEW IF EXISTS `v_vols`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_vols`  AS SELECT `vols`.`id_vol` AS `ID`, `vols`.`numero_vol` AS `Numéro vol`, `compagnies`.`nom` AS `Compagnie`, `avions`.`immatriculation` AS `Avion`, `vols`.`aeroport_depart` AS `Aéroport départ`, `vols`.`aeroport_arrivee` AS `Aéroport arrivée`, `vols`.`date_depart` AS `Date départ`, `vols`.`date_arrivee` AS `Date arrivée`, `vols`.`prix` AS `Prix`, `vols`.`statut` AS `Statut` FROM ((`vols` left join `compagnies` on((`vols`.`ref_compagnie` = `compagnies`.`id_compagnie`))) left join `avions` on((`avions`.`ref_compagnie` = `compagnies`.`id_compagnie`))) ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `avions`
--
ALTER TABLE `avions`
  ADD CONSTRAINT `fk_avions_compagnie` FOREIGN KEY (`ref_compagnie`) REFERENCES `compagnies` (`id_compagnie`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `conges`
--
ALTER TABLE `conges`
  ADD CONSTRAINT `fk_conges_pilote` FOREIGN KEY (`ref_pilote`) REFERENCES `pilotes` (`id_pilote`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `pilotes`
--
ALTER TABLE `pilotes`
  ADD CONSTRAINT `fk_pilotes_avion` FOREIGN KEY (`ref_avion`) REFERENCES `avions` (`id_avion`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pilotes_utilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_utilisateur` FOREIGN KEY (`ref_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservations_vol` FOREIGN KEY (`ref_vol`) REFERENCES `vols` (`id_vol`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vols`
--
ALTER TABLE `vols`
  ADD CONSTRAINT `fk_vols_avion` FOREIGN KEY (`ref_avion`) REFERENCES `avions` (`id_avion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_vols_compagnie` FOREIGN KEY (`ref_compagnie`) REFERENCES `compagnies` (`id_compagnie`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
