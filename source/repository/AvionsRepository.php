<?php
require_once __DIR__ . '/../model/AvionsModel.php';

class AvionsRepository {
     private $bdd;

     public function __construct($bdd) {
          $this->bdd = $bdd;
     }

     public function createAvion(AvionsModel $avion) {
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

    public function getAvions(): array {
        $stmt = $this->bdd->query("SELECT * FROM avions");
        $avions = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $avion = new AvionsModel();
            $avion->hydrate($row);
            $avions[] = $avion;
        }

        return $avions;
    }

    public function getAvionById($id): ?AvionModel {
        $sql = "SELECT * FROM avions WHERE id_avion = :id_avion";
        $stmt = $this->bdd->prepare($sql);
        $stmt->bindParam(':id_avion', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $avion = new AvionModel();
            $avion->hydrate($row);
            return $avion;
        }
        return null;
    }


    public function updateAvion(AvionsModel $avion) {
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
