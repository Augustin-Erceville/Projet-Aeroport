<?php
class UtilisateursModel
{
     private ?int $id_utilisateur = null;
     private ?string $prenom = null;
     private ?string $nom = null;
     private ?string $telephone = null;
     private ?string $email = null;
     private ?string $mot_de_passe = null;
     private ?string $date_naissance = null;
     private ?string $ville_residence = null;
     private ?DateTime $inscription = null;
    private ?string $role = null;

    public function __construct(array $donnees = [])
     {
          $this->hydrate($donnees);
     }

     public function hydrate($data) {
          if (isset($data['id_utilisateur'])) {
               $this->id_utilisateur = $data['id_utilisateur'];
          }
          if (isset($data['prenom'])) {
               $this->prenom = $data['prenom'];
          }
          if (isset($data['nom'])) {
               $this->nom = $data['nom'];
          }
          if (isset($data['telephone'])) {
               $this->telephone = $data['telephone'];
          }
          if (isset($data['email'])) {
               $this->email = $data['email'];
          }
          if (isset($data['mot_de_passe'])) {
               $this->mot_de_passe = $data['mot_de_passe'];
          }
          if (isset($data['date_naissance'])) {
               $this->date_naissance = $data['date_naissance'];
          }
          if (isset($data['ville_residence'])) {
               $this->ville_residence = $data['ville_residence'];
          }
          if (isset($data['inscription'])) {
               $this->inscription = new DateTime($data['inscription']);
          }
         if (isset($data['role'])) {
             $this->role = $data['role'];
         }

     }

     public function getIdUser()
     {
          return $this->id_utilisateur;
     }

     public function setIdUser($id_utilisateur)
     {
          $this->id_utilisateur = $id_utilisateur;
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
    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): void
    {
        $this->role = $role;
    }
}
