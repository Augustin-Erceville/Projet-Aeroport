<?php

class CongesRepository {
     private $pdo;

     public function __construct($pdo) {
          $this->pdo = $pdo;
     }

     public function createConge(CongesModel $conge) {
          $query = "INSERT INTO conges (ref_pilote, date_debut, date_fin) 
                  VALUES (:ref_pilote, :date_debut, :date_fin)";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':ref_pilote' => $conge->getRefPilote(),
               ':date_debut' => $conge->getDateDebut(),
               ':date_fin' => $conge->getDateFin(),
          ]);
          $conge->setId($this->pdo->lastInsertId());
          return $conge;
     }

     public function getConge($id) {
          $query = "SELECT * FROM conges WHERE id_conge = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new CongesModel(
                    $row['id_conge'],
                    $row['ref_pilote'],
                    $row['date_debut'],
                    $row['date_fin']
               );
          }
          return null;
     }

     public function getCongesByPilote($piloteId) {
          $query = "SELECT * FROM conges WHERE ref_pilote = :ref_pilote";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':ref_pilote' => $piloteId]);
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $conges = [];
          foreach ($rows as $row) {
               $conges[] = new CongesModel(
                    $row['id_conge'],
                    $row['ref_pilote'],
                    $row['date_debut'],
                    $row['date_fin']
               );
          }
          return $conges;
     }

     public function updateConge(CongesModel $conge) {
          $query = "UPDATE conges 
                  SET ref_pilote = :ref_pilote, date_debut = :date_debut, date_fin = :date_fin 
                  WHERE id_conge = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':ref_pilote' => $conge->getRefPilote(),
               ':date_debut' => $conge->getDateDebut(),
               ':date_fin' => $conge->getDateFin(),
               ':id' => $conge->getId(),
          ]);
     }

     public function deleteConge($id) {
          $query = "DELETE FROM conges WHERE id_conge = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
     }
}
