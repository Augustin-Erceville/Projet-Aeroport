<?php

class PiloteModel {
     private $id;
     private $nom;
     private $prenom;
     private $licence;
     private $compagnieId;

     public function __construct($id = null, $nom = "", $prenom = "", $licence = "", $compagnieId = 0) {
          $this->id = $id;
          $this->nom = $nom;
          $this->prenom = $prenom;
          $this->licence = $licence;
          $this->compagnieId = $compagnieId;
     }

     public function hydrate($data) {
          if (isset($data['id'])) {
               $this->id = $data['id'];
          }
          if (isset($data['nom'])) {
               $this->nom = $data['nom'];
          }
          if (isset($data['prenom'])) {
               $this->prenom = $data['prenom'];
          }
          if (isset($data['licence'])) {
               $this->licence = $data['licence'];
          }
          if (isset($data['compagnieId'])) {
               $this->compagnieId = $data['compagnieId'];
          }
     }

     public function getId() {
          return $this->id;
     }

     public function getNom() {
          return $this->nom;
     }

     public function getPrenom() {
          return $this->prenom;
     }

     public function getLicence() {
          return $this->licence;
     }

     public function getCompagnieId() {
          return $this->compagnieId;
     }

     public function setId($id) {
          $this->id = $id;
     }

     public function setNom($nom) {
          $this->nom = $nom;
     }

     public function setPrenom($prenom) {
          $this->prenom = $prenom;
     }

     public function setLicence($licence) {
          $this->licence = $licence;
     }

     public function setCompagnieId($compagnieId) {
          $this->compagnieId = $compagnieId;
     }
}
