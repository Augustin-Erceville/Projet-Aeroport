<?php

class PiloteModel
{
     private $id_pilote;
     private $ref_utilisateur;
     private $ref_avion;
     private $disponible;

     public function __construct(array $data = [])
     {
          if (!empty($data)) {
               $this->hydrate($data);
          }
     }

     public function hydrate(array $data): void
     {
          $this->id_pilote = $data['id_pilote'] ?? null;
          $this->ref_utilisateur = $data['ref_utilisateur'] ?? null;
          $this->ref_avion = $data['ref_avion'] ?? null;
          $this->disponible = $data['disponible'] ?? 'Disponible';
     }

     public function getIdPilote(): ?int
     {
          return $this->id_pilote;
     }

     public function getRefUtilisateur(): ?int
     {
          return $this->ref_utilisateur;
     }

     public function getRefAvion(): ?int
     {
          return $this->ref_avion;
     }

     public function getDisponible(): ?string
     {
          return $this->disponible;
     }

     public function setIdPilote(?int $id_pilote): void
     {
          $this->id_pilote = $id_pilote;
     }

     public function setRefUtilisateur(?int $ref_utilisateur): void
     {
          $this->ref_utilisateur = $ref_utilisateur;
     }

     public function setRefAvion(?int $ref_avion): void
     {
          $this->ref_avion = $ref_avion;
     }

     public function setDisponible(?string $disponible): void
     {
          $this->disponible = $disponible;
     }
}
