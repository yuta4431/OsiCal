<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class MemoTemplate
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM memo_templates ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByCategory($category_id)
    {
        $sql = "SELECT * FROM memo_templates WHERE category_id = :category_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['category_id' => $category_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function create($category_id, $template)
    {
        $sql = "INSERT INTO memo_templates (category_id, template) VALUES (:category_id, :template)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['category_id' => $category_id, 'template' => $template]);
    }

    public function update($id, $category_id, $template)
    {
        $sql = "UPDATE memo_templates SET category_id = :category_id, template = :template WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id, 'category_id' => $category_id, 'template' => $template]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM memo_templates WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}