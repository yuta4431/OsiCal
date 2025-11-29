<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class oshi
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM oshis ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM oshis WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name)
    {
        $sql = "INSERT INTO oshis (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['name' => $name]);
    }

    public function update($id, $name)
    {
        $sql = "UPDATE oshis SET name = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM oshis WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
