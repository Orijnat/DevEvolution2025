<?php
namespace App;

use PDO;

class Cliente {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function criar($nome, $id_usuario) {
        $stmt = $this->pdo->prepare("INSERT INTO clientes (nome, id_usuario) VALUES (?, ?)");
        return $stmt->execute([$nome, $id_usuario]);
    }

    public function listarDoUsuario($id_usuario) {
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id_usuario = ?");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}

