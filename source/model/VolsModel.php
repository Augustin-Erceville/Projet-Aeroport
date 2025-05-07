<?php

class VolModel {
     private $id_Vol;
     private $numeroVol;
     private $ref_Compagnie;
     private $ref_Avion;
     private $aeroportDepart;
     private $aeroportArrivee;
     private $dateDepart;
     private $dateArrivee;
     private $prix;
     private $statut;



     public function __construct($id_Vol = null, $numeroVol = "", $ref_Compagnie = 0, $ref_Avion = 0, $aeroportDepart = "", $aeroportArrivee = "", $dateDepart = "", $dateArrivee = "", $prix = 0.00, $statut = "prévu") {
          $this->id_Vol = $id_Vol;
          $this->numeroVol = $numeroVol;
          $this->ref_Compagnie = $ref_Compagnie;
          $this->ref_Avion = $ref_Avion;
          $this->aeroportDepart = $aeroportDepart;
          $this->aeroportArrivee = $aeroportArrivee;
          $this->dateDepart = $dateDepart;
          $this->dateArrivee = $dateArrivee;
          $this->prix = $prix;
          $this->statut = $statut;
     }



     public function hydrate($data) {
          if (isset($data['id_vol'])) $this->id_Vol = $data['id_vol'];
          if (isset($data['numero_vol'])) $this->numeroVol = $data['numero_vol'];
          if (isset($data['ref_compagnie'])) $this->ref_Compagnie = $data['ref_compagnie'];
          if (isset($data['ref_avion'])) $this->ref_Avion = $data['ref_avion'];
          if (isset($data['aeroport_depart'])) $this->aeroportDepart = $data['aeroport_depart'];
          if (isset($data['aeroport_arrivee'])) $this->aeroportArrivee = $data['aeroport_arrivee'];
          if (isset($data['date_depart'])) $this->dateDepart = $data['date_depart'];
          if (isset($data['date_arrivee'])) $this->dateArrivee = $data['date_arrivee'];
          if (isset($data['prix'])) $this->prix = $data['prix'];
          if (isset($data['statut'])) $this->statut = $data['statut'];
     }



     public function getid_Vol() { return $this->id_Vol; }
     public function getNumeroVol() { return $this->numeroVol; }
     public function getref_Compagnie() { return $this->ref_Compagnie; }
     public function getRef_Avion() { return $this->ref_Avion; }
     public function getAeroportDepart() { return $this->aeroportDepart; }
     public function getAeroportArrivee() { return $this->aeroportArrivee; }
     public function getDateDepart() { return $this->dateDepart; }
     public function getDateArrivee() { return $this->dateArrivee; }
     public function getPrix() { return $this->prix; }
     public function getStatut() { return $this->statut; }



     public function setid_Vol($id_Vol) { $this->id_Vol = $id_Vol; }
     public function setNumeroVol($numeroVol) { $this->numeroVol = $numeroVol; }
     public function setref_Compagnie($ref_Compagnie) { $this->ref_Compagnie = $ref_Compagnie; }
     public function setRef_Avion($ref_Avion) { $this->ref_Avion = $ref_Avion; }
     public function setAeroportDepart($aeroportDepart) { $this->aeroportDepart = $aeroportDepart; }
     public function setAeroportArrivee($aeroportArrivee) { $this->aeroportArrivee = $aeroportArrivee; }
     public function setDateDepart($dateDepart) { $this->dateDepart = $dateDepart; }
     public function setDateArrivee($dateArrivee) { $this->dateArrivee = $dateArrivee; }
     public function setPrix($prix) { $this->prix = $prix; }
     public function setStatut($statut) { $this->statut = $statut; }
}
