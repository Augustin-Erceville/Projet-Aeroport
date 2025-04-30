<?php

class AvionsRepository {
     private $bdd;

     public function __construct($bdd) {
          $this->bdd = $bdd;
     }

     public function createAvion(AvionModel $avion) {
          $sql = "INSERT INTO avions (immatriculation, modele, capacite, ref_compagnie) VALUES (:immatriculation, :modele, :capacite, :ref_compagnie)";

          $stmt = $this->bdd->prepare($sql);

          $immatriculation = $avion->getImmatriculation();
          $modele = $avion->getModele();
          $capacite = $avion->getCapacite();
          $ref_compagnie = $avion->getRefCompagnie();

          $stmt->bindParam(':immatriculation', $immatriculation);
          $stmt->bindParam(':modele', $modele);
          $stmt->bindParam(':capacite', $capacite, PDO::PARAM_INT);
          $stmt->bindParam(':ref_compagnie', $ref_compagnie);

          return $stmt->execute();
     }

     public function getAvions() {
          $sql = "SELECT * FROM avions";
          $stmt = $this->bdd->prepare($sql);
          $stmt->execute();
          return $stmt->fetchAll(PDO::FETCH_OBJ);
     }

     public function getAvionById($id) {
          $sql = "SELECT * FROM avions WHERE id_avion = :id_avion";
          $stmt = $this->bdd->prepare($sql);
          $stmt->bindParam(':id_avion', $id, PDO::PARAM_INT);
          $stmt->execute();
          return $stmt->fetch(PDO::FETCH_OBJ);
     }

     public function updateAvion(AvionModel $avion) {
          $sql = "UPDATE avions SET immatriculation = :immatriculation, modele = :modele, capacite = :capacite, ref_compagnie = :ref_compagnie WHERE id_avion = :id_avion";
          $stmt = $this->bdd->prepare($sql);

          $id_avion = $avion->getIdAvion();
          $immatriculation = $avion->getImmatriculation();
          $modele = $avion->getModele();
          $capacite = $avion->getCapacite();
          $ref_compagnie = $avion->getRefCompagnie();

          $stmt->bindParam(':id_avion', $id_avion, PDO::PARAM_INT);
          $stmt->bindParam(':immatriculation', $immatriculation);
          $stmt->bindParam(':modele', $modele);
          $stmt->bindParam(':capacite', $capacite, PDO::PARAM_INT);
          $stmt->bindParam(':ref_compagnie', $ref_compagnie);

          return $stmt->execute();
     }

     public function deleteAvion($id) {
          $sql = "DELETE FROM avions WHERE id_avion = :id_avion";
          $stmt = $this->bdd->prepare($sql);
          $stmt->bindParam(':id_avion', $id, PDO::PARAM_INT);
          return $stmt->execute();
     }
}
