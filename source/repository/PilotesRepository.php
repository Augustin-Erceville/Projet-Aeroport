<?php

class PilotesRepository {
     private $pdo;

     public function __construct($pdo) {
          $this->pdo = $pdo;
     }

     public function createPilote(PilotesModel $pilote) {
          $query = "INSERT INTO pilotes (ref_utilisateur, ref_avion, disponible) 
                  VALUES (:ref_utilisateur, :ref_avion, :disponible)";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':ref_utilisateur' => $pilote->getRefUtilisateur(),
               ':ref_avion' => $pilote->getRefAvion(),
               ':disponible' => $pilote->getDisponible(),
          ]);
          $pilote->setId($this->pdo->lastInsertId());
          return $pilote;
     }

     public function getPilote($id) {
          $query = "SELECT * FROM pilotes WHERE id_pilote = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new PilotesModel(
                    $row['id_pilote'],
                    $row['ref_utilisateur'],
                    $row['ref_avion'],
                    $row['disponible']
               );
          }
          return null;
     }

     public function getPilotes() {
          $query = "SELECT * FROM pilotes";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute();
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $pilotes = [];
          foreach ($rows as $row) {
               $pilotes[] = new PilotesModel(
                    $row['id_pilote'],
                    $row['ref_utilisateur'],
                    $row['ref_avion'],
                    $row['disponible']
               );
          }
          return $pilotes;
     }

     public function updatePilote(PilotesModel $pilote) {
          $query = "UPDATE pilotes 
                  SET ref_utilisateur = :ref_utilisateur, ref_avion = :ref_avion, disponible = :disponible 
                  WHERE id_pilote = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':ref_utilisateur' => $pilote->getRefUtilisateur(),
               ':ref_avion' => $pilote->getRefAvion(),
               ':disponible' => $pilote->getDisponible(),
               ':id' => $pilote->getId(),
          ]);
     }

     public function deletePilote($id) {
          $query = "DELETE FROM pilotes WHERE id_pilote = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
     }
}