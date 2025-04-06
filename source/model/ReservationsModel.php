<?php

class ReservationModel {
     private $id;
     private $passagerId;
     private $volId;
     private $dateReservation;
     private $statut;

     public function __construct($id = null, $passagerId = 0, $volId = 0, $dateReservation = "", $statut = "En attente") {
          $this->id = $id;
          $this->passagerId = $passagerId;
          $this->volId = $volId;
          $this->dateReservation = $dateReservation;
          $this->statut = $statut;
     }

     public function hydrate($data) {
          if (isset($data['id'])) {
               $this->id = $data['id'];
          }
          if (isset($data['passagerId'])) {
               $this->passagerId = $data['passagerId'];
          }
          if (isset($data['volId'])) {
               $this->volId = $data['volId'];
          }
          if (isset($data['dateReservation'])) {
               $this->dateReservation = $data['dateReservation'];
          }
          if (isset($data['statut'])) {
               $this->statut = $data['statut'];
          }
     }

     public function getId() {
          return $this->id;
     }

     public function getPassagerId() {
          return $this->passagerId;
     }

     public function getVolId() {
          return $this->volId;
     }

     public function getDateReservation() {
          return $this->dateReservation;
     }

     public function getStatut() {
          return $this->statut;
     }

     public function setId($id) {
          $this->id = $id;
     }

     public function setPassagerId($passagerId) {
          $this->passagerId = $passagerId;
     }

     public function setVolId($volId) {
          $this->volId = $volId;
     }

     public function setDateReservation($dateReservation) {
          $this->dateReservation = $dateReservation;
     }

     public function setStatut($statut) {
          $this->statut = $statut;
     }
}