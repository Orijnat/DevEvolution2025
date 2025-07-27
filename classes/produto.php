<?php
namespace App;

use PDO;

class Produto {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function criar($nome, $preco, $estoque) {
        $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, preco, estoque) VALUES (?, ?, ?)");
        return $stmt->execute([$nome, $preco, $estoque]);
    }

    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM produtos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editar($id, $nome, $preco, $estoque) {
        $stmt = $this->pdo->prepare("UPDATE produtos SET nome = ?, preco = ?, estoque = ? WHERE id = ?");
        return $stmt->execute([$nome, $preco, $estoque, $id]);
    }
    public function excluir($id) {
        $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = ?");
        return $stmt->execute([$id]);
    }
    public function atualizarEstoque($id, $novaQuantidade)
    {
        $stmt = $this->pdo->prepare("UPDATE produtos SET estoque = :estoque WHERE id = :id");
        $stmt->execute([
            ':estoque' => $novaQuantidade,
            ':id' => $id
        ]);
    }

    public function buscarPorId($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function liberarReservasExpiradas() {
        $agora = time();
        $stmt = $this->pdo->query("SELECT * FROM reservas");

        foreach ($stmt as $reserva) {
            $tempo = strtotime($reserva['data_reserva']);
            if (($agora - $tempo) > 120) {
                $this->pdo->prepare("DELETE FROM reservas WHERE id = ?")->execute([$reserva['id']]);
            }
        }
    }
}