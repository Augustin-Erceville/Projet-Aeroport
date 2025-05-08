<?php

require_once __DIR__ . '/../model/ReservationsModel.php';

class ReservationsRepository
{
    private PDO $connexion;

    public function __construct(PDO $connexion)
    {
        $this->connexion = $connexion;
    }

    public function getAll(): array
    {
        $stmt = $this->connexion->query("SELECT * FROM v_reservations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservations(): array
    {
        $stmt = $this->connexion->query("SELECT * FROM reservations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?ReservationsModel
    {
        $stmt = $this->connexion->prepare("SELECT * FROM reservations WHERE id_reservation = :id_reservation");
        $stmt->bindParam(':id_reservation', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new ReservationsModel($row);
        }

        return null;
    }

    public function add(ReservationsModel $reservation): bool
    {
        $stmt = $this->connexion->prepare(
            "INSERT INTO reservations (ref_utilisateur, ref_vol, classe, statut, date_reservation)
             VALUES (:ref_utilisateur, :ref_vol, :classe, :statut, :date_reservation)"
        );

        return $stmt->execute([
            ':ref_utilisateur' => $reservation->getRef_utilisateur(),
            ':ref_vol' => $reservation->getRef_vol(),
            ':classe' => $reservation->getClasse(),
            ':statut' => $reservation->getStatut(),
            ':date_reservation' => $reservation->getDate_reservation()
        ]);
    }

    public function update(ReservationsModel $reservation): bool
    {
        $stmt = $this->connexion->prepare(
            "UPDATE reservations
             SET ref_utilisateur = :ref_utilisateur,
                 ref_vol = :ref_vol,
                 classe = :classe,
                 statut = :statut,
                 date_reservation = :date_reservation
             WHERE id_reservation = :id_reservation"
        );

        return $stmt->execute([
            ':ref_utilisateur' => $reservation->getRef_utilisateur(),
            ':ref_vol' => $reservation->getRef_vol(),
            ':classe' => $reservation->getClasse(),
            ':statut' => $reservation->getStatut(),
            ':date_reservation' => $reservation->getDate_reservation(),
            ':id_reservation' => $reservation->getId_reservation()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connexion->prepare("DELETE FROM reservations WHERE id_reservation = :id_reservation");
        $stmt->bindParam(':id_reservation', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
