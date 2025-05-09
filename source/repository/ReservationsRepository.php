<?php
require_once __DIR__ . '/../bdd/config.php';
require_once __DIR__ . '/../model/ReservationsModel.php';

class ReservationsRepository
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }
    public function getAll(): array
    {
        $stmt = $this->bdd->query("SELECT * FROM v_reservations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReservations(): array
    {
        $stmt = $this->bdd->query("SELECT * FROM reservations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?ReservationsModel
    {
        $stmt = $this->bdd->prepare("SELECT * FROM reservations WHERE id_reservation = :id_reservation");
        $stmt->execute(['id_reservation' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new ReservationsModel($row) : null;
    }
     public function getAllReservations(): array {
          $stmt = $this->bdd->query("SELECT * FROM reservations");
          $reservations = [];

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $reservation = new ReservationsModel();
               $reservation->hydrate($row);
               $reservations[] = $reservation;
          }

          return $reservations;
     }
    public function getReservationsByUserId(int $idUser): array
    {
        $stmt = $this->bdd->prepare("SELECT * FROM reservations WHERE ref_utilisateur = :idUser");
        $stmt->execute(['idUser' => $idUser]);

        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = new ReservationsModel($row);
        }

        return $reservations;
    }

    public function add(ReservationsModel $reservation): bool
    {
        $stmt = $this->bdd->prepare(
            "INSERT INTO reservations (ref_utilisateur, ref_vol, classe, statut, date_reservation)
             VALUES (:ref_utilisateur, :ref_vol, :classe, :statut, :date_reservation)"
        );

        return $stmt->execute([
            'ref_utilisateur' => $reservation->getRef_utilisateur(),
            'ref_vol' => $reservation->getRefvol(),
            'classe' => $reservation->getClasse(),
            'statut' => $reservation->getStatut(),
            'date_reservation' => $reservation->getDate_reservation()
        ]);
    }

    public function creerReservationRapide(int $idUser, int $idVol, string $classe = 'Économique'): bool
    {
        $stmt = $this->bdd->prepare("
            INSERT INTO reservations (ref_utilisateur, ref_vol, classe, statut)
            VALUES (:utilisateur, :vol, :classe, 'confirmé')
        ");

        return $stmt->execute([
            'utilisateur' => $idUser,
            'vol' => $idVol,
            'classe' => $classe
        ]);
    }

    public function update(ReservationsModel $reservation): bool
    {
        $stmt = $this->bdd->prepare(
            "UPDATE reservations
             SET ref_utilisateur = :ref_utilisateur,
                 ref_vol = :ref_vol,
                 classe = :classe,
                 statut = :statut,
                 date_reservation = :date_reservation
             WHERE id_reservation = :id_reservation"
        );

        return $stmt->execute([
            'ref_utilisateur' => $reservation->getRef_utilisateur(),
            'ref_vol' => $reservation->getRefvol(),
            'classe' => $reservation->getClasse(),
            'statut' => $reservation->getStatut(),
            'date_reservation' => $reservation->getDate_reservation(),
            'id_reservation' => $reservation->getId_reservation()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->bdd->prepare("DELETE FROM reservations WHERE id_reservation = :id_reservation");
        return $stmt->execute(['id_reservation' => $id]);
    }
}