<?php

class CompagniesRepository {
     private $pdo;

     public function __construct($pdo) {
          $this->pdo = $pdo;
     }

     public function createCompagnie(CompagnieModel $compagnie) {
          $query = "INSERT INTO compagnies (nom, pays, date_creation) VALUES (:nom, :pays, :date_creation)";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':nom' => $compagnie->getNom(),
               ':pays' => $compagnie->getPays(),
               ':date_creation' => $compagnie->getDateCreation(),
          ]);
          $compagnie->setId($this->pdo->lastInsertId());
          return $compagnie;
     }

     public function getCompagnie($nom) {
          $query = "SELECT * FROM compagnies WHERE nom = :nom";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':nom' => $nom]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new CompagnieModel($row['id'], $row['nom'], $row['pays'], $row['date_creation']);
          }
          return null;
     }

     public function getCompagnieById($id) {
          $query = "SELECT * FROM compagnies WHERE id = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new CompagnieModel($row['id'], $row['nom'], $row['pays'], $row['date_creation']);
          }
          return null;
     }

     public function updateCompagnie(CompagnieModel $compagnie) {
          $query = "UPDATE compagnies SET nom = :nom, pays = :pays, date_creation = :date_creation WHERE id = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':nom' => $compagnie->getNom(),
               ':pays' => $compagnie->getPays(),
               ':date_creation' => $compagnie->getDateCreation(),
               ':id' => $compagnie->getId(),
          ]);
     }

     public function deleteCompagnie($id) {
          $query = "DELETE FROM compagnies WHERE id = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
     }
}
