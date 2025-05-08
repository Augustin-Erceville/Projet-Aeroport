<?php
require_once __DIR__ . '/../model/UtilisateursModel.php';
class UtilisateursRepository
{
    private $bdd;

    public function __construct(\PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    public function getUsers(): array {
        try {
            $query = $this->bdd->prepare("SELECT * FROM utilisateurs");
            $query->execute();
            $users = [];

            while ($data = $query->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = new \UtilisateursModel($data);
            }
            return $users;
        } catch (\PDOException $e) {
            return [];
        }
    }
    public function getUserById(int $id): ?\UtilisateursModel
    {
        try {
            $query = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE id_utilisateur = :id_utilisateur");
            $query->execute(['id_utilisateur' => $id]);
            $data = $query->fetch(\PDO::FETCH_ASSOC);

            return $data ? new \UtilisateursModel($data) : null;
        } catch (\PDOException $e) {
            return null;
        }
    }

    public function getUserByEmail(string $email): ?\UtilisateursModel
    {
        $query = $this->bdd->prepare("SELECT * FROM utilisateurs WHERE email = :email");
        $query->execute(['email' => $email]);
        $data = $query->fetch(\PDO::FETCH_ASSOC);
        return $data ? new \UtilisateursModel($data) : null;
    }

    public function ajouterUtilisateur(\UtilisateursModel $utilisateur): void
    {
        $query = $this->bdd->prepare("INSERT INTO utilisateurs (nom, prenom, telephone, email, mot_de_passe, date_naissance, ville_residence) 
                                VALUES (:nom, :prenom, :telephone, :email, :mot_de_passe, :date_naissance, :ville_residence)");

        $query->execute([
            'nom' => $utilisateur->getNom(),
            'prenom' => $utilisateur->getPrenom(),
            'telephone' => $utilisateur->getTelephone(),
            'email' => $utilisateur->getEmail(),
            'mot_de_passe' => $utilisateur->getMotDePasse(),
            'date_naissance' => $utilisateur->getDateNaissance(),
            'ville_residence' => $utilisateur->getVilleResidence()
        ]);
    }

    public function connexion($email, $password): ?\UtilisateursModel
    {
        try {
            $sql = "SELECT * FROM utilisateurs WHERE email = :email";
            $stmt = $this->bdd->prepare($sql);
            $stmt->execute(['email' => $email]);
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!empty($data) && password_verify($password, $data['mot_de_passe'])) {
                return new \UtilisateursModel($data);
            }

            return null;
        } catch (\PDOException $e) {
            error_log("Erreur PDO : " . $e->getMessage());
            return null;
        }
    }

    public function updateUser(\UtilisateursModel $user): bool
    {
        try {
            $req = $this->bdd->prepare(
                'UPDATE utilisateurs 
                 SET prenom = :prenom, nom = :nom, telephone = :telephone, email = :email, mot_de_passe = :mot_de_passe, date_naissance = :date_naissance, ville_residence = :ville_residence
                 WHERE id_utilisateur = :id_utilisateur'
            );

            return $req->execute([
                'id_utilisateur' => $user->getIdUser(),
                'prenom' => $user->getPrenom(),
                'nom' => $user->getNom(),
                'telephone' => $user->getTelephone(),
                'email' => $user->getEmail(),
                'mot_de_passe' => password_hash($user->getMotDePasse(), PASSWORD_BCRYPT),
                'date_naissance' => $user->getDateNaissance(),
                'ville_residence' => $user->getVilleResidence()
            ]);
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function deleteUser(int $id): bool
    {
        try {
            $checkReq = $this->bdd->prepare('SELECT id_utilisateur FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
            $checkReq->execute(['id_utilisateur' => $id]);

            if ($checkReq->rowCount() == 0) {
                return false;
            }

            $req = $this->bdd->prepare('DELETE FROM utilisateurs WHERE id_utilisateur = :id_utilisateur');
            return $req->execute(['id_utilisateur' => $id]);
        } catch (\PDOException $e) {
            return false;
        }
    }
}
