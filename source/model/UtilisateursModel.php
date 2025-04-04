<?php
class UtilisateursModel
{
     private ?int $id_user = null;
     private ?string $prenom = null;
     private ?string $nom = null;
     private ?string $telephone = null;
     private ?string $email = null;
     private ?string $mot_de_passe = null;
     private ?string $date_naissance = null;
     private ?string $ville_residence = null;
     private ?DateTime $inscription = null;

     public function __construct(array $donnees = [])
     {
          $this->hydrate($donnees);
     }

     private function hydrate(array $donnees): void
     {
          foreach ($donnees as $key => $value) {
               $method = 'set' . ucfirst($key);
               if (method_exists($this, $method)) {
                    $this->$method($value);
               }
          }
     }

     public function getIdUser()
     {
          return $this->id_user;
     }

     public function setIdUser($id_user)
     {
          $this->id_user = $id_user;
     }

     public function getPrenom()
     {
          return $this->prenom;
     }

     public function setPrenom($prenom)
     {
          $this->prenom = $prenom;
     }

     public function getNom()
     {
          return $this->nom;
     }

     public function setNom($nom)
     {
          $this->nom = $nom;
     }

     public function getTelephone()
     {
          return $this->telephone;
     }

     public function setTelephone($telephone)
     {
          $this->telephone = $telephone;
     }

     public function getEmail()
     {
          return $this->email;
     }

     public function setEmail($email)
     {
          $this->email = $email;
     }

     public function getMotDePasse()
     {
          return $this->mot_de_passe;
     }

     public function setMotDePasse($mot_de_passe)
     {
          $this->mot_de_passe = $mot_de_passe;
     }

     public function getDateNaissance()
     {
          return $this->date_naissance;
     }

     public function setDateNaissance($date_naissance)
     {
          $this->date_naissance = $date_naissance;
     }

     public function getVilleResidence()
     {
          return $this->ville_residence;
     }

     public function setVilleResidence($ville_residence)
     {
          $this->ville_residence = $ville_residence;
     }

     public function getInscription()
     {
          return $this->inscription;
     }

     public function setInscription($inscription)
     {
          if (is_string($inscription)) {
               $this->inscription = new DateTime($inscription);
          } elseif ($inscription instanceof DateTime) {
               $this->inscription = $inscription;
          } else {
               $this->inscription = null;
          }
     }
}
