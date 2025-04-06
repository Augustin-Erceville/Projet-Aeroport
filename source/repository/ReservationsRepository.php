<?php

class ReservationsRepository {
     private $pdo;

     public function __construct($pdo) {
          $this->pdo = $pdo;
     }

     public function createReservation(ReservationsModel $reservation) {
          $query = "INSERT INTO reservations (ref_utilisateur, ref_vol, classe, statut, date_reservation) 
                  VALUES (:ref_utilisateur, :ref_vol, :classe, :statut, :date_reservation)";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':ref_utilisateur' => $reservation->getRefUtilisateur(),
               ':ref_vol' => $reservation->getRefVol(),
               ':classe' => $reservation->getClasse(),
               ':statut' => $reservation->getStatut(),
               ':date_reservation' => $reservation->getDateReservation(),
          ]);
          $reservation->setId($this->pdo->lastInsertId());
          return $reservation;
     }

     public function getReservation($id) {
          $query = "SELECT * FROM reservations WHERE id_reservation = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               return new ReservationsModel(
                    $row['id_reservation'],
                    $row['ref_utilisateur'],
                    $row['ref_vol'],
                    $row['classe'],
                    $row['statut'],
                    $row['date_reservation']
               );
          }
          return null;
     }

     public function getReservationsByUser($userId) {
          $query = "SELECT * FROM reservations WHERE ref_utilisateur = :ref_utilisateur";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':ref_utilisateur' => $userId]);
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          $reservations = [];
          foreach ($rows as $row) {
               $reservations[] = new ReservationsModel(
                    $row['id_reservation'],
                    $row['ref_utilisateur'],
                    $row['ref_vol'],
                    $row['classe'],
                    $row['statut'],
                    $row['date_reservation']
               );
          }
          return $reservations;
     }

     public function updateReservation(ReservationsModel $reservation) {
          $query = "UPDATE reservations 
                  SET ref_utilisateur = :ref_utilisateur, ref_vol = :ref_vol, classe = :classe, statut = :statut, 
                      date_reservation = :date_reservation 
                  WHERE id_reservation = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([
               ':ref_utilisateur' => $reservation->getRefUtilisateur(),
               ':ref_vol' => $reservation->getRefVol(),
               ':classe' => $reservation->getClasse(),
               ':statut' => $reservation->getStatut(),
               ':date_reservation' => $reservation->getDateReservation(),
               ':id' => $reservation->getId(),
          ]);
     }

     public function deleteReservation($id) {
          $query = "DELETE FROM reservations WHERE id_reservation = :id";
          $stmt = $this->pdo->prepare($query);
          $stmt->execute([':id' => $id]);
     }
}
