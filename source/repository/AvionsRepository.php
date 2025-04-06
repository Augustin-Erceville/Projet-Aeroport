<?php

class AvionsRepository {
     private $pdo;

     public function __construct($pdo) {
          $this->pdo = $pdo;
     }

     public function createAvion(AvionModel $avion) {
          $query = "INSERT INTO avions (nom, type, capacite) VALUES (:nom, :type, :capacite)";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':nom' => $avion->getNom(),
               ':type' => $avion->getType(),
               ':capacite' => $avion->getCapacite(),
          ]);
          $avion->setId($this->pdo->lastInsertId());
          return $avion;
     }

     public function getAvion($nom) {
          $query = "SELECT * FROM avions WHERE nom = :nom";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':nom' => $nom]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new AvionModel($row['id'], $row['nom'], $row['type'], $row['capacite']);
          }
          return null;
     }

     public function getAvionById($id) {
          $query = "SELECT * FROM avions WHERE id = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new AvionModel($row['id'], $row['nom'], $row['type'], $row['capacite']);
          }
          return null;
     }

     public function updateAvion(AvionModel $avion) {
          $query = "UPDATE avions SET nom = :nom, type = :type, capacite = :capacite WHERE id = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':nom' => $avion->getNom(),
               ':type' => $avion->getType(),
               ':capacite' => $avion->getCapacite(),
               ':id' => $avion->getId(),
          ]);
     }

     public function deleteAvion($id) {
          $query = "DELETE FROM avions WHERE id = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
     }
}