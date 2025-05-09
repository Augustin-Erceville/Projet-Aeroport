<?php
require_once __DIR__ . '/../model/CongesModel.php';
class CongesRepository
{
    private \PDO $bdd;

    public function __construct(\PDO $bdd)
    {
        $this->bdd = $bdd;
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    public function createConge(CongesModel $conge): void
    {
        $query = $this->bdd->prepare(
            "INSERT INTO conges (ref_pilote, date_debut, date_fin) 
             VALUES (:ref_pilote, :date_debut, :date_fin)"
        );

        $query->execute([
            'ref_pilote' => $conge->getRefPilote(),
            'date_debut' => $conge->getDateDebut(),
            'date_fin'   => $conge->getDateFin(),
        ]);
    }
    public function getConges(): array
    {
        $query = $this->bdd->query("SELECT * FROM V_conges");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
     public function getAllConges(): array {
          $stmt = $this->bdd->query("SELECT * FROM conges");
          $conges = [];

          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $conge = new CongesModel();
               $conge->hydrate($row);
               $conges[] = $conge;
          }

          return $conges;
     }
    public function getCongeById(int $id): ?CongesModel
    {
        $query = $this->bdd->prepare("SELECT * FROM conges WHERE id_conge = :id");
        $query->execute(['id' => $id]);
        $data = $query->fetch(\PDO::FETCH_ASSOC);

        return $data ? new CongesModel($data) : null;
    }
    public function updateConge(CongesModel $conge): bool
    {
        $query = $this->bdd->prepare(
            "UPDATE conges 
             SET ref_pilote = :ref_pilote, date_debut = :date_debut, date_fin = :date_fin 
             WHERE id_conge = :id_conge"
        );

        return $query->execute([
            'id_conge'    => $conge->getIdConge(),
            'ref_pilote'  => $conge->getRefPilote(),
            'date_debut'  => $conge->getDateDebut(),
            'date_fin'    => $conge->getDateFin(),
        ]);
    }
    public function deleteConge(int $id): bool
    {
        $query = $this->bdd->prepare("DELETE FROM conges WHERE id_conge = :id");
        return $query->execute(['id' => $id]);
    }
}
