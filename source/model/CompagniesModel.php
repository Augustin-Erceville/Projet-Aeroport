<?php
namespace model; // Ajoutez cette ligne pour définir le namespace

class CompagnieModel {
    private $id;
    private $nom;
    private $pays;
    private $dateCreation;

    public function __construct($id = null, $nom = "", $pays = "", $dateCreation = "") {
        $this->id = $id;
        $this->nom = $nom;
        $this->pays = $pays;
        $this->dateCreation = $dateCreation;
    }

    public function hydrate($data) {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        if (isset($data['nom'])) {
            $this->nom = $data['nom'];
        }
        if (isset($data['pays'])) {
            $this->pays = $data['pays'];
        }
        if (isset($data['dateCreation'])) {
            $this->dateCreation = $data['dateCreation'];
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPays() {
        return $this->pays;
    }

    public function getDateCreation() {
        return $this->dateCreation;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPays($pays) {
        $this->pays = $pays;
    }

    public function setDateCreation($dateCreation) {
        $this->dateCreation = $dateCreation;
    }
}
