<?php

class VolsRepository {
     private $pdo;

     public function __construct($pdo) {
          $this->pdo = $pdo;
     }

     public function createVol(VolModel $vol) {
          $query = "INSERT INTO vols (numero_vol, ref_compagnie, ref_avion, date_depart, date_arrivee, statut) 
                  VALUES (:numero_vol, :compagnie_id, :avion_id, :pilote_id, :date_depart, :date_arrivee, :statut)";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':numero_vol' => $vol->getNumeroVol(),
               ':compagnie_id' => $vol->getCompagnieId(),
               ':avion_id' => $vol->getAvionId(),
               ':pilote_id' => $vol->getPiloteId(),
               ':date_depart' => $vol->getDateDepart(),
               ':date_arrivee' => $vol->getDateArrivee(),
               ':statut' => $vol->getStatut(),
          ]);
          $vol->setId($this->pdo->lastInsertId());
          return $vol;
     }

    public function getVols() {
        $query = "SELECT * FROM vols";
        $stmt = $this->pdo->query($query);
        $vols = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vols[] = new VolModel(
                $row['id_vol'],
                $row['numero_vol'],
                $row['compagnie_id'],
                $row['avion_id'],
                $row['pilote_id'],
                $row['date_depart'],
                $row['date_arrivee'],
                $row['statut']
            );
        }

        return $vols;
    }

     public function getVolById($id) {
          $query = "SELECT * FROM vols WHERE id_vol = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new VolModel(
                    $row['id'],
                    $row['numero_vol'],
                    $row['compagnie_id'],
                    $row['avion_id'],
                    $row['pilote_id'],
                    $row['date_depart'],
                    $row['date_arrivee'],
                    $row['statut']
               );
          }
          return null;
     }

     public function updateVol(VolModel $vol) {
          $query = "UPDATE vols 
                  SET numero_vol = :numero_vol, compagnie_id = :compagnie_id, avion_id = :avion_id, 
                      pilote_id = :pilote_id, date_depart = :date_depart, date_arrivee = :date_arrivee, statut = :statut 
                  WHERE id_vol = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':numero_vol' => $vol->getNumeroVol(),
               ':compagnie_id' => $vol->getCompagnieId(),
               ':avion_id' => $vol->getAvionId(),
               ':pilote_id' => $vol->getPiloteId(),
               ':date_depart' => $vol->getDateDepart(),
               ':date_arrivee' => $vol->getDateArrivee(),
               ':statut' => $vol->getStatut(),
               ':id' => $vol->getId(),
          ]);
     }

     public function deleteVol($id) {
          $query = "DELETE FROM vols WHERE id_vol = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
     }
}
