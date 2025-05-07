<?php

require_once __DIR__ . '/../model/PilotesModel.php';

class PilotesRepository
{
     private $bdd;

     public function __construct($bdd)
     {
          $this->bdd = $bdd;
     }

     public function createPilote(PiloteModel $pilote): void
     {
          $query = "INSERT INTO pilotes (ref_utilisateur, ref_avion, disponible)
                  VALUES (:ref_utilisateur, :ref_avion, :disponible)";
          $stmt = $this->bdd->prepare($query);
          $stmt->execute([
               ':ref_utilisateur' => $pilote->getRefUtilisateur(),
               ':ref_avion' => $pilote->getRefAvion(),
               ':disponible' => $pilote->getDisponible()
          ]);
          $pilote->setIdPilote($this->bdd->lastInsertId());
     }

     public function getPilotes(): array
     {
          $query = "SELECT * FROM pilotes";
          $stmt = $this->bdd->query($query);

          $pilotes = [];
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $pilote = new PiloteModel();
               $pilote->hydrate($row);
               $pilotes[] = $pilote;
          }

          return $pilotes;
     }
     public function getPiloteById(int $id): ?PiloteModel
     {
          $query = "SELECT * FROM pilotes WHERE id_pilote = :id_pilote";
          $stmt = $this->bdd->prepare($query);
          $stmt->execute([':id_pilote' => $id]);

          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if ($row) {
               $pilote = new PiloteModel();
               $pilote->hydrate($row);
               return $pilote;
          }

          return null;
     }

     public function updatePilote(PiloteModel $pilote): void
     {
          $query = "UPDATE pilotes 
                  SET ref_utilisateur = :ref_utilisateur, ref_avion = :ref_avion, disponible = :disponible
                  WHERE id_pilote = :id_pilote";
          $stmt = $this->bdd->prepare($query);
          $stmt->execute([
               ':ref_utilisateur' => $pilote->getRefUtilisateur(),
               ':ref_avion' => $pilote->getRefAvion(),
               ':disponible' => $pilote->getDisponible(),
               ':id_pilote' => $pilote->getIdPilote()
          ]);
     }

     public function deletePilote(int $id): void
     {
          $query = "DELETE FROM pilotes WHERE id_pilote = :id_pilote";
          $stmt = $this->bdd->prepare($query);
          $stmt->execute([':id_pilote' => $id]);
     }
}
