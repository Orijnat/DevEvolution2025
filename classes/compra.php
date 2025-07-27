<?php
namespace App;

use PDO;

class Compra {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function registrar($id_usuario, $id_produto, $quantidade) {
        $stmt = $this->pdo->prepare("INSERT INTO compras (id_usuario, id_produto, quantidade, data_compra) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$id_usuario, $id_produto, $quantidade, date('Y-m-d H:i:s')]);
    }



    public function listarPorUsuario($id_usuario)
    {
        $stmt = $this->pdo->prepare("
            SELECT compras.*, produtos.nome AS nome_produto, produtos.preco 
            FROM compras 
            INNER JOIN produtos ON compras.id_produto = produtos.id
            WHERE compras.id_usuario = ?
            ORDER BY compras.data_compra DESC
        ");
        $stmt->execute([$id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarTodosComUsuarios()
    {
        $stmt = $this->pdo->query("
        SELECT c.*, p.nome AS nome_produto, p.preco, u.nome AS nome_usuario
        FROM compras c
        JOIN produtos p ON c.id_produto = p.id
        JOIN usuarios u ON c.id_usuario = u.id
        ORDER BY c.data_compra DESC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
