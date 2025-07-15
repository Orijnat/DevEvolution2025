<?php

namespace App;

use PDO;
use PDOException;
use Exception;

class Database
{
    private $pdo = null;

    public function __construct()
    {
        $caminho = __DIR__ . '/../database/banco.db';

        // Cria a pasta se não existir
        $pasta = dirname($caminho);
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        try {
            $this->pdo = new PDO("sqlite:" . $caminho);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->criarTabelas();
        } catch (PDOException $e) {
            throw new Exception("Erro na conexão com o banco: " . $e->getMessage());
        }
    }

    public function getConexao(): PDO
    {
        if (!$this->pdo) {
            throw new Exception("Banco de dados não conectado.");
        }
        return $this->pdo;
    }

    private function criarTabelas()
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL UNIQUE,
                senha TEXT NOT NULL
            );

            CREATE TABLE IF NOT EXISTS clientes (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                email TEXT NOT NULL,
                telefone TEXT
            );

            CREATE TABLE IF NOT EXISTS produtos (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome TEXT NOT NULL,
                descricao TEXT,
                quantidade INTEGER DEFAULT 0,
                reservado INTEGER DEFAULT 0,
                data_reserva INTEGER,
                usuario_id INTEGER,
                FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
            );

            CREATE TABLE IF NOT EXISTS compras (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                cliente_id INTEGER,
                produto_id INTEGER,
                quantidade INTEGER DEFAULT 1,
                data_compra INTEGER,
                FOREIGN KEY (cliente_id) REFERENCES clientes(id),
                FOREIGN KEY (produto_id) REFERENCES produtos(id)
            );
        ");
    }
}
