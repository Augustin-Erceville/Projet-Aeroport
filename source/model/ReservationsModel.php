<?php

class ReservationsModel
{
    private $id_reservation;
    private $ref_utilisateur;
    private $ref_vol;
    private string $destination;
    private string $dateDepart;
    private $classe;
    private $statut;
    private $date_reservation;

    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->hydrate($data);
        }
    }

    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
            if (isset($data['ref_vol'])) {
                $this->ref_vol = (int) $data['ref_vol'];
            }
            if (isset($data['Destination'])) {
                $this->destination = $data['Destination'];
            } else {
                $this->destination = 'Non renseignée';
            }
            if (isset($data['DateDepart'])) {
                $this->dateDepart = $data['DateDepart'];
            }

        }
    }

    public function getId_reservation(): int
    {
        return $this->id_reservation;
    }

    public function getRef_utilisateur(): int
    {
        return $this->ref_utilisateur;
    }

    public function getRefvol(): int
    {
        return $this->ref_vol;
    }
    public function getDestination(): string {
        return $this->destination;
    }

    public function getClasse(): string
    {
        return $this->classe;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function getDate_reservation(): string
    {
        return $this->date_reservation;
    }

    public function setId_reservation(int $id_reservation): void
    {
        $this->id_reservation = $id_reservation;
    }

    public function setRef_utilisateur(int $ref_utilisateur): void
    {
        $this->ref_utilisateur = $ref_utilisateur;
    }

    public function setRef_vol(int $ref_vol): void
    {
        $this->ref_vol = $ref_vol;
    }

    public function setClasse(string $classe): void
    {
        $this->classe = $classe;
    }

    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
    public function setDate_reservation(string $date_reservation): void
    {
        $this->date_reservation = $date_reservation;
    }
    public function getDateDepart(): string
    {
        return $this->dateDepart ?? 'Non précisée';
    }

    public function setDateDepart(string $dateDepart): void
    {
        $this->dateDepart = $dateDepart;
    }
}
