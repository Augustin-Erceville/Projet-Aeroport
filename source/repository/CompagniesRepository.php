<?php
namespace repository;

use PDO;
use model\CompagnieModel;

class CompagniesRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    public function createCompagnie(CompagnieModel $compagnie): CompagnieModel {
        $sql = "INSERT INTO compagnies (nom, pays)
                VALUES (:nom, :pays)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom'  => $compagnie->getNom(),
            ':pays' => $compagnie->getPays(),
        ]);
        $compagnie->setId((int)$this->pdo->lastInsertId());
        return $compagnie;
    }
    public function getCompagnies(): array {
        $sql  = "SELECT id_compagnie, nom, pays FROM compagnies";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($rows as $row) {
            $result[] = new CompagnieModel(
                (int)$row['id_compagnie'],
                $row['nom'],
                $row['pays']
            );
        }
        return $result;
    }
    public function getCompagnieById(int $id): ?CompagnieModel {
        $sql  = "SELECT id_compagnie, nom, pays 
                 FROM compagnies 
                 WHERE id_compagnie = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new CompagnieModel(
                (int)$row['id_compagnie'],
                $row['nom'],
                $row['pays'],
                ''
            );
        }
        return null;
    }
    public function updateCompagnie(CompagnieModel $compagnie): bool {
        $sql = "UPDATE compagnies
                SET nom = :nom, pays = :pays
                WHERE id_compagnie = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom'  => $compagnie->getNom(),
            ':pays' => $compagnie->getPays(),
            ':id'   => $compagnie->getId(),
        ]);
    }
    public function deleteCompagnie(int $id): bool {
        $sql = "DELETE FROM compagnies WHERE id_compagnie = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
