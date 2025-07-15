<?php
try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/database/banco.db");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão e criação do banco OK!";
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
