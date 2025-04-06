<?php

class VolModel {
     private $id;
     private $numeroVol;
     private $compagnieId;
     private $avionId;
     private $piloteId;
     private $dateDepart;
     private $dateArrivee;
     private $statut;

     public function __construct($id = null, $numeroVol = "", $compagnieId = 0, $avionId = 0, $piloteId = 0, $dateDepart = "", $dateArrivee = "", $statut = "Prévu") {
          $this->id = $id;
          $this->numeroVol = $numeroVol;
          $this->compagnieId = $compagnieId;
          $this->avionId = $avionId;
          $this->piloteId = $piloteId;
          $this->dateDepart = $dateDepart;
          $this->dateArrivee = $dateArrivee;
          $this->statut = $statut;
     }

     public function hydrate($data) {
          if (isset($data['id'])) {
               $this->id = $data['id'];
          }
          if (isset($data['numeroVol'])) {
               $this->numeroVol = $data['numeroVol'];
          }
          if (isset($data['compagnieId'])) {
               $this->compagnieId = $data['compagnieId'];
          }
          if (isset($data['avionId'])) {
               $this->avionId = $data['avionId'];
          }
          if (isset($data['piloteId'])) {
               $this->piloteId = $data['piloteId'];
          }
          if (isset($data['dateDepart'])) {
               $this->dateDepart = $data['dateDepart'];
          }
          if (isset($data['dateArrivee'])) {
               $this->dateArrivee = $data['dateArrivee'];
          }
          if (isset($data['statut'])) {
               $this->statut = $data['statut'];
          }
     }

     public function getId() {
          return $this->id;
     }

     public function getNumeroVol() {
          return $this->numeroVol;
     }

     public function getCompagnieId() {
          return $this->compagnieId;
     }

     public function getAvionId() {
          return $this->avionId;
     }

     public function getPiloteId() {
          return $this->piloteId;
     }

     public function getDateDepart() {
          return $this->dateDepart;
     }

     public function getDateArrivee() {
          return $this->dateArrivee;
     }

     public function getStatut() {
          return $this->statut;
     }

     public function setId($id) {
          $this->id = $id;
     }

     public function setNumeroVol($numeroVol) {
          $this->numeroVol = $numeroVol;
     }

     public function setCompagnieId($compagnieId) {
          $this->compagnieId = $compagnieId;
     }

     public function setAvionId($avionId) {
          $this->avionId = $avionId;
     }

     public function setPiloteId($piloteId) {
          $this->piloteId = $piloteId;
     }

     public function setDateDepart($dateDepart) {
          $this->dateDepart = $dateDepart;
     }

     public function setDateArrivee($dateArrivee) {
          $this->dateArrivee = $dateArrivee;
     }

     public function setStatut($statut) {
          $this->statut = $statut;
     }
}