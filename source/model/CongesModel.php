<?php

class CongesModel
{
    private ?int $id_conge = null;
    private ?int $ref_pilote = null;
    private ?string $date_debut = null;
    private ?string $date_fin = null;

    public function __construct(array $donnees = [])
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $data): void
    {
        if (isset($data['id_conge'])) {
            $this->id_conge = (int) $data['id_conge'];
        }
        if (isset($data['ref_pilote'])) {
            $this->ref_pilote = (int) $data['ref_pilote'];
        }
        if (isset($data['date_debut'])) {
            $this->date_debut = $data['date_debut'];
        }
        if (isset($data['date_fin'])) {
            $this->date_fin = $data['date_fin'];
        }
    }

    // Getters
    public function getIdConge(): ?int
    {
        return $this->id_conge;
    }

    public function getRefPilote(): ?int
    {
        return $this->ref_pilote;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    // Setters
    public function setIdConge(?int $id_conge): void
    {
        $this->id_conge = $id_conge;
    }

    public function setRefPilote(?int $ref_pilote): void
    {
        $this->ref_pilote = $ref_pilote;
    }

    public function setDateDebut(?string $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    public function setDateFin(?string $date_fin): void
    {
        $this->date_fin = $date_fin;
    }
}
