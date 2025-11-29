<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class category
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM categories ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM categories WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($name)
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['name' => $name]); 
    }

    public function update($id, $name)
    {
        $sql = "UPDATE categories SET name = :name WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'name' => $name]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
