<?php

class VolsModel {
     private ?int $id_vol = null;
     private string $numero_vol;
     private int $ref_compagnie;
     private int $ref_avion;
     private string $aeroport_depart;
     private string $aeroport_arrivee;
     private string $date_depart;
     private string $date_arrivee;
     private float $prix;
     private string $statut;
    private string $nom_compagnie;
     public function getIdVol(): ?int {
          return $this->id_vol;
     }

     public function setIdVol(int $id_vol): void {
          $this->id_vol = $id_vol;
     }

     public function getNumeroVol(): string {
          return $this->numero_vol;
     }

     public function setNumeroVol(string $numero_vol): void {
          $this->numero_vol = $numero_vol;
     }

     public function getRefCompagnie(): int {
          return $this->ref_compagnie;
     }

     public function setRefCompagnie(int $ref_compagnie): void {
          $this->ref_compagnie = $ref_compagnie;
     }

     public function getRefAvion(): int {
          return $this->ref_avion;
     }

     public function setRefAvion(int $ref_avion): void {
          $this->ref_avion = $ref_avion;
     }

     public function getAeroportDepart(): string {
          return $this->aeroport_depart;
     }

     public function setAeroportDepart(string $aeroport_depart): void {
          $this->aeroport_depart = $aeroport_depart;
     }

     public function getAeroportArrivee(): string {
          return $this->aeroport_arrivee;
     }

     public function setAeroportArrivee(string $aeroport_arrivee): void {
          $this->aeroport_arrivee = $aeroport_arrivee;
     }

     public function getDateDepart(): string {
          return $this->date_depart;
     }

     public function setDateDepart(string $date_depart): void {
          $this->date_depart = $date_depart;
     }

     public function getDateArrivee(): string {
          return $this->date_arrivee;
     }

     public function setDateArrivee(string $date_arrivee): void {
          $this->date_arrivee = $date_arrivee;
     }

     public function getPrix(): float {
          return $this->prix;
     }

     public function setPrix(float $prix): void {
          $this->prix = $prix;
     }

     public function getStatut(): string {
          return $this->statut;
     }

     public function setStatut(string $statut): void {
          $this->statut = $statut;
     }
    public function getNomCompagnie()
    {
        return $this->nom_compagnie;
    }

    public function setNomCompagnie($nom_compagnie)
    {
        $this->nom_compagnie = $nom_compagnie;
    }
     public function hydrate(array $data): void {
          $this->id_vol = $data['id_vol'] ?? null;
          $this->numero_vol = $data['numero_vol'];
          $this->ref_compagnie = $data['ref_compagnie'];
          $this->ref_avion = $data['ref_avion'];
          $this->aeroport_depart = $data['aeroport_depart'];
          $this->aeroport_arrivee = $data['aeroport_arrivee'];
          $this->date_depart = $data['date_depart'];
          $this->date_arrivee = $data['date_arrivee'];
          $this->prix = $data['prix'];
          $this->statut = $data['statut'];
     }
}
