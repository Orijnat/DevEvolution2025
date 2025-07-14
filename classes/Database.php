<?php

namespace App;

use PDO;
use PFO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct($arquivo = __DIR__ . "/..data/banco.db")
    {
        try {
            $this->pdo = new PDO(~"sqlite:" . $arquivo);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->criarTabelas();
        } catch (PDOException $e) {
            echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
        }
    }

    public function getConexao()
    {
        return $this->pdo;
    }

    private function criarTabelas()
    {

        $sql = "CREATE TABLE IF NOT EXISTS usuarios (
            id INTERER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT NOT NULL,
            senha TEXT NOT NULL
            );

        CREATE TABLE IF NOT EXISTS produtos (
            id INTERER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            descricao TEXT,
            quantidade INTEGER DEFAULT 0,
            reservado INTEGER DEFAULT 0,
            data_reserva INTEGER,
            usuario_id INTEGER,
            FROREING KEY (usuario_id) REFERENCES usuarios(id)
            );

        CREATE TABLE IF NOT EXISTS clientes (
            id INTERER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT NOT NULL,
            telefone TEXT,
            usuario_id INTEGER,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
            );

        CREATE TABLE IF NOT EXISTS compras (
            id INTERER PRIMARY KEY AUTOINCREMENT,
            cliente_id INTEGER,
            produto_id INTEGER,
            quantidade INTEGER DEFAULT 1,
            daat_compra INTEGER,
            FOREIGN KEY (cliente_id) REFERENCES clientes(id),
            FOREIGN KEY (produto_id) REFERENCES produtos(id)
            );
        ";
        $this->pdo->exec($sql);
    }
}