<?php

namespace repository;
class UtilisateursRepository
{
     private PDO $bdd;

     public function __construct(PDO $bdd)
     {
          $this->bdd = $bdd;
          $this->bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     }

     public function getUsers(): array
     {
          try {
               $query = $this->bdd->prepare("SELECT * FROM utilisateurs");
               $query->execute();
               $users = [];

               while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                    $users[] = new Users($data);
               }
               return $users;
          } catch (PDOException $e) {
               return [];
          }
     }

     public function getUserById(int $id): ?Users
     {
          try {
               $query = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur");
               $query->execute(['id' => $id]);
               $data = $query->fetch(PDO::FETCH_ASSOC);

               return $data ? new Users($data) : null;
          } catch (PDOException $e) {
               return null;
          }
     }

     public function inscription(Users $user): bool
     {
          try {
               $checkReq = $this->bdd->prepare('SELECT id_utilisateur FROM utilisateurs WHERE email = :email');
               $checkReq->execute(['email' => $user->getEmail()]);

               if ($checkReq->rowCount() > 0) {
                    return false;
               }

               $req = $this->bdd->prepare(
                    'INSERT INTO utilisateurs (prenom, nom, telephone, email, mot_de_passe, date_naissance, ville_residence) 
                     VALUES (:prenom, :nom, :telephone, :email, :mot_de_passe, :date_naissance, :ville_residence)'
               );

               return $req->execute([
                    'prenom' => $user->getPrenom(),
                    'nom' => $user->getNom(),
                    'telephone' => $user->getTelephone(),
                    'email' => $user->getEmail(),
                    'mot_de_passe' => password_hash($user->getMotDePasse(), PASSWORD_BCRYPT),
                    'date_naissance' => $user->getDateNaissance(),
                    'ville_residence' => $user->getVilleResidence()
               ]);
          } catch (PDOException $e) {
               return false;
          }
     }

     public function connexion($email, $password): ?Users
     {
          try {
               $sql = "SELECT * FROM utilisateurs WHERE email = :email";
               $stmt = $this->bdd->prepare($sql);
               $stmt->execute(['email' => $email]);
               $user = $stmt->fetch(PDO::FETCH_ASSOC);
               if (!empty($user) && password_verify($password, $user['mot_de_passe'])) {
                    $obj = new Users($user);
                    return $obj;
               }

               return null;
          } catch (PDOException $e) {
               error_log("Erreur PDO : " . $e->getMessage());
               return null;
          }
     }

     public function updateUser(Users $user): bool
     {
          try {
               $req = $this->bdd->prepare(
                    'UPDATE utilisateurs 
                     SET prenom = :prenom, nom = :nom, telephone = :telephone, email = :email, mot_de_passe = :mot_de_passe, date_naissance = :date_naissance, ville_residence = :ville_residence
                     WHERE id_utilisateur = :id_utilisateur'
               );

               return $req->execute([
                    'id_user' => $user->getIdUser(),
                    'prenom' => $user->getPrenom(),
                    'nom' => $user->getNom(),
                    'telephone' => $user->getTelephone(),
                    'email' => $user->getEmail(),
                    'mot_de_passe' => password_hash($user->getMotDePasse(), PASSWORD_BCRYPT),
                    'date_naissance' => $user->getDateNaissance(),
                    'ville_residence' => $user->getVilleResidence()
               ]);
          } catch (PDOException $e) {
               return false;
          }
     }

     public function deleteUser(int $id): bool
     {
          try {
               $checkReq = $this->bdd->prepare('SELECT id_utilisateur FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
               $checkReq->execute(['id' => $id]);

               if ($checkReq->rowCount() == 0) {
                    return false;
               }

               $req = $this->bdd->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
               return $req->execute(['id' => $id]);
          } catch (PDOException $e) {
               return false;
          }
     }
}

