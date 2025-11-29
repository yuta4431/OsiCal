<?php

namespace App\Models;

use App\Core\Database;
use PDO;

class Event
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM events ORDER BY date ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM events WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($title, $date, $memo, $oshi_id, $category_id)
    {
        $sql = "INSERT INTO events (title, date, memo, oshi_id, category_id)
                VALUES (:title, :date, :memo, :oshi_id, :category_id)";
        
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'title' => $title,
            'date' => $date,
            'memo' => $memo,
            'oshi_id' => $oshi_id,
            'category_id' => $category_id
        ]);
    }

    public function update($id, $title, $date, $memo, $oshi_id, $category_id)
    {
        $sql = "UPDATE events
                SET title = :title,
                    date = :date,
                    memo = :memo,
                    oshi_id = :oshi_id,
                    category_id = :category_id
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'date' => $date,
            'memo' => $memo,
            'oshi_id' => $oshi_id,
            'category_id' => $category_id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
