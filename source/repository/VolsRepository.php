<?php

class VolsRepository {
    private PDO $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function createVol(VolModel $vol): VolModel {
        $query = "INSERT INTO vols (numero_vol, ref_compagnie, ref_avion, aeroport_depart, aeroport_arrivee, date_depart, date_arrivee, prix, statut)
                  VALUES (:numero_vol, :ref_compagnie, :ref_avion, :aeroport_depart, :aeroport_arrivee, :date_depart, :date_arrivee, :prix, :statut)";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([
            ':numero_vol' => $vol->getNumeroVol(),
            ':ref_compagnie' => $vol->getRefCompagnie(),
            ':ref_avion' => $vol->getRefAvion(),
            ':aeroport_depart' => $vol->getAeroportDepart(),
            ':aeroport_arrivee' => $vol->getAeroportArrivee(),
            ':date_depart' => $vol->getDateDepart(),
            ':date_arrivee' => $vol->getDateArrivee(),
            ':prix' => $vol->getPrix(),
            ':statut' => $vol->getStatut()
        ]);

        $vol->setIdVol((int) $this->bdd->lastInsertId());
        return $vol;
    }

    public function getVols(): array {
        $query = "SELECT * FROM v_vols";
        $stmt = $this->bdd->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVolById(int $id): ?VolModel {
        $query = "SELECT * FROM vols WHERE id_vol = :id";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vol = new VolModel();
            $vol->hydrate($row);
            return $vol;
        }

        return null;
    }

    public function updateVol(VolModel $vol): void {
        $query = "UPDATE vols 
                  SET numero_vol = :numero_vol,
                      ref_compagnie = :ref_compagnie,
                      ref_avion = :ref_avion,
                      aeroport_depart = :aeroport_depart,
                      aeroport_arrivee = :aeroport_arrivee,
                      date_depart = :date_depart,
                      date_arrivee = :date_arrivee,
                      prix = :prix,
                      statut = :statut
                  WHERE id_vol = :id_vol";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([
            ':numero_vol' => $vol->getNumeroVol(),
            ':ref_compagnie' => $vol->getRefCompagnie(),
            ':ref_avion' => $vol->getRefAvion(),
            ':aeroport_depart' => $vol->getAeroportDepart(),
            ':aeroport_arrivee' => $vol->getAeroportArrivee(),
            ':date_depart' => $vol->getDateDepart(),
            ':date_arrivee' => $vol->getDateArrivee(),
            ':prix' => $vol->getPrix(),
            ':statut' => $vol->getStatut(),
            ':id_vol' => $vol->getIdVol()
        ]);
    }

    public function deleteVol(int $id): void {
        $query = "DELETE FROM vols WHERE id_vol = :id";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([':id' => $id]);
    }
}
