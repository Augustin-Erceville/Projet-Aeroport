<?php

class AdministrationRepository {
     private PDO $bdd;

     public function __construct(PDO $bdd) {
          $this->bdd = $bdd;
     }

     public function getModeleAvions(): array {
          $stmt = $this->bdd->query("SELECT modele, COUNT(*) AS total FROM avions GROUP BY modele");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getDisponibilitePilotes(): array {
          $stmt = $this->bdd->query("SELECT disponible, COUNT(*) AS total FROM pilotes GROUP BY disponible");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getStatutsVols(): array {
          $stmt = $this->bdd->query("SELECT statut, COUNT(*) AS total FROM vols GROUP BY statut");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getCapaciteParAvion(): array {
          $stmt = $this->bdd->query("SELECT id_avion, capacite FROM avions");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getAvionsParCompagnie(): array {
          $stmt = $this->bdd->query("
            SELECT compagnies.nom AS compagnie, COUNT(avions.id_avion) AS total
            FROM avions
            JOIN compagnies ON avions.ref_compagnie = compagnies.id_compagnie
            GROUP BY compagnie
        ");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getCompagniesParPays(): array {
          $stmt = $this->bdd->query("SELECT pays, COUNT(*) AS total FROM compagnies GROUP BY pays");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getReservationsParVol(): array {
          $stmt = $this->bdd->query("SELECT ref_vol, COUNT(*) AS total FROM reservations GROUP BY ref_vol");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getReservationsParUtilisateur(): array {
          $stmt = $this->bdd->query("SELECT ref_utilisateur, COUNT(*) AS total FROM reservations GROUP BY ref_utilisateur");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getClasseParReservation(): array {
          $stmt = $this->bdd->query("SELECT classe, COUNT(*) AS total FROM reservations GROUP BY classe");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getStatutParReservation(): array {
          $stmt = $this->bdd->query("SELECT statut, COUNT(*) AS total FROM reservations GROUP BY statut");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getUtilisateursParVille(): array {
          $stmt = $this->bdd->query("SELECT ville_residence, COUNT(*) AS total FROM utilisateurs GROUP BY ville_residence");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getVolsParCompagnie(): array {
          $stmt = $this->bdd->query("
            SELECT compagnies.nom AS compagnie, COUNT(vols.id_vol) AS total
            FROM vols
            JOIN compagnies ON vols.ref_compagnie = compagnies.id_compagnie
            GROUP BY compagnie
        ");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }

     public function getVolsParDestination(): array {
          $stmt = $this->bdd->query("SELECT aeroport_arrivee AS destination, COUNT(*) AS total FROM vols GROUP BY aeroport_arrivee");
          return $stmt->fetchAll(PDO::FETCH_ASSOC);
     }
}
