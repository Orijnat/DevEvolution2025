<?php
namespace App;

use PDO;
use PDOException;

class Database {
    private PDO $pdo;

    public function __construct() {
        $databaseDir = __DIR__ . '/../database';
        $databaseFile = $databaseDir . '/banco.db';

        if (!is_dir($databaseDir)) {
            mkdir($databaseDir, 0755, true);
        }

        try {
            $this->pdo = new PDO("sqlite:" . $databaseFile);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro ao conectar ao banco: " . $e->getMessage());
        }
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }
}
