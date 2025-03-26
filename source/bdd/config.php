<?php
class Config
{
     private $nomBDD = 'projets_airport';
     private $serveur = 'localhost';
     private $user= 'root';
     private $password = '';
     private $bdd;
     public function __construct()
     {
          $this->bdd = new PDO("mysql:dbname=".$this->nomBDD.";host=".$this->serveur, $this->user, $this->password);
     }

     public function connexion(){
          return $this->bdd;
     }
}