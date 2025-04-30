<?php

class AvionModel
{
     private $id_avion;
     private $immatriculation;
     private $modele;
     private $capacite;
     private $ref_compagnie;

     public function __construct($id_avion = null, $immatriculation = '', $modele = '', $capacite = 0, $ref_compagnie = 0)
     {
          $this->id_avion = $id_avion;
          $this->immatriculation = $immatriculation;
          $this->modele = $modele;
          $this->capacite = (int)$capacite;
          $this->ref_compagnie = (int)$ref_compagnie;
     }

     public function hydrate(array $data)
     {
          if (isset($data['id_avion'])) $this->id_avion = $data['id_avion'];
          if (isset($data['immatriculation'])) $this->immatriculation = $data['immatriculation'];
          if (isset($data['modele'])) $this->modele = $data['modele'];
          if (isset($data['capacite'])) $this->capacite = (int)$data['capacite'];
          if (isset($data['ref_compagnie'])) $this->ref_compagnie = (int)$data['ref_compagnie'];
     }

     public function getIdAvion() { return $this->id_avion; }
     public function getImmatriculation() { return $this->immatriculation; }
     public function getModele() { return $this->modele; }
     public function getCapacite() { return $this->capacite; }
     public function getRefCompagnie() { return $this->ref_compagnie; }

     public function setIdAvion($id_avion) { $this->id_avion = $id_avion; }
     public function setImmatriculation($immatriculation) { $this->immatriculation = $immatriculation; }
     public function setModele($modele) { $this->modele = $modele; }
     public function setCapacite($capacite) { $this->capacite = (int)$capacite; }
     public function setRefCompagnie($ref_compagnie) { $this->ref_compagnie = (int)$ref_compagnie; }
}
