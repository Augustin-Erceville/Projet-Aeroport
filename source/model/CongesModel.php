<?php

class CongeModel {
     private $id;
     private $employeId;
     private $dateDebut;
     private $dateFin;
     private $statut;

     public function __construct($id = null, $employeId = 0, $dateDebut = "", $dateFin = "", $statut = "En attente") {
          $this->id = $id;
          $this->employeId = $employeId;
          $this->dateDebut = $dateDebut;
          $this->dateFin = $dateFin;
          $this->statut = $statut;
     }

     public function hydrate($data) {
          if (isset($data['id'])) {
               $this->id = $data['id'];
          }
          if (isset($data['employeId'])) {
               $this->employeId = $data['employeId'];
          }
          if (isset($data['dateDebut'])) {
               $this->dateDebut = $data['dateDebut'];
          }
          if (isset($data['dateFin'])) {
               $this->dateFin = $data['dateFin'];
          }
          if (isset($data['statut'])) {
               $this->statut = $data['statut'];
          }
     }

     public function getId() {
          return $this->id;
     }

     public function getEmployeId() {
          return $this->employeId;
     }

     public function getDateDebut() {
          return $this->dateDebut;
     }

     public function getDateFin() {
          return $this->dateFin;
     }

     public function getStatut() {
          return $this->statut;
     }

     public function setId($id) {
          $this->id = $id;
     }

     public function setEmployeId($employeId) {
          $this->employeId = $employeId;
     }

     public function setDateDebut($dateDebut) {
          $this->dateDebut = $dateDebut;
     }

     public function setDateFin($dateFin) {
          $this->dateFin = $dateFin;
     }

     public function setStatut($statut) {
          $this->statut = $statut;
     }
}
