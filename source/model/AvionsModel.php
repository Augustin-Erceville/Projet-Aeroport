<?php

class AvionModel
{
    private $id;
    private $nom;
    private $type;
    private $capacite;
    private $compagnie;

    public function __construct($id = null, $nom = '', $type = '', $capacite = 0, $compagnie = '')
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->type = $type;
        $this->capacite = $capacite;
        $this->compagnie = $compagnie;
    }
    public function hydrate(array $data)
    {
        if (isset($data['id'])) $this->id = $data['id'];
        if (isset($data['nom'])) $this->nom = $data['nom'];
        if (isset($data['type'])) $this->type = $data['type'];
        if (isset($data['capacite'])) $this->capacite = $data['capacite'];
        if (isset($data['compagnie'])) $this->compagnie = $data['compagnie'];
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getType() { return $this->type; }
    public function getCapacite() { return $this->capacite; }
    public function getCompagnie() { return $this->compagnie; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setType($type) { $this->type = $type; }
    public function setCapacite($capacite) { $this->capacite = $capacite; }
    public function setCompagnie($compagnie) { $this->compagnie = $compagnie; }
}
