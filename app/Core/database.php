<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $pdo;

    public static function getConnection()
    {
        if (!self::$pdo) {

            $config = require __DIR__ . '/../../config/config.php';

            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";

            try {
                self::$pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                ]);
            } catch (PDOException $e) {
                die('DB Connection failed: ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}