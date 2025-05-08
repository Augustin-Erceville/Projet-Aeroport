<?php
require_once __DIR__ . '/../model/VolsModel.php';
class VolsRepository {
    private PDO $bdd;

    public function __construct(PDO $bdd) {
        $this->bdd = $bdd;
    }

    public function createVol(VolsModel $vol): VolsModel {
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
    public function getAllVols()
    {
        $sql = "SELECT v.*, c.nom AS nom_compagnie 
            FROM vols v
            JOIN compagnies c ON v.ref_compagnie = c.id_compagnie
            ORDER BY v.date_depart ASC";
        $stmt = $this->bdd->query($sql);

        $vols = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vol = new VolsModel();
            $vol->hydrate($row);
            $vol->setNomCompagnie($row['nom_compagnie']);
            $vols[] = $vol;
        }

        return $vols;
    }
    public function getVols() {
        $stmt = $this->bdd->query("SELECT * FROM v_vols");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getVolById(int $id): ?VolsModel {
        $query = "SELECT * FROM vols WHERE id_vol = :id";
        $stmt = $this->bdd->prepare($query);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $vol = new VolsModel();
            $vol->hydrate($row);
            return $vol;
        }
        return null;
    }

    public function updateVol(VolsModel $vol): void {
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
    public function getNextFiveVols()
    {
        $sql = "SELECT v.*, c.nom AS nom_compagnie 
            FROM vols v
            JOIN compagnies c ON v.ref_compagnie = c.id_compagnie
            WHERE v.date_depart > NOW()
            ORDER BY v.date_depart ASC
            LIMIT 5";
        $stmt = $this->bdd->query($sql);
        $vols = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vol = new VolsModel();
            $vol->hydrate($row);
            $vol->setNomCompagnie($row['nom_compagnie']); // Petit ajout
            $vols[] = $vol;
        }
        return $vols;
    }
}
