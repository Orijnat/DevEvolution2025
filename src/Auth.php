<?php

namespace App;

use PDO;

class Auth {

    private $pdo;

    public function __construct(Database $db) {
        $this->pdo = $db->getPdo();
    }

    private function startSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(string $email, string $senha) {
        $sql = "SELECT * FROM clientes WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $this->startSession();

            // Salva na sessão com chaves consistentes
            $_SESSION['usuario'] = [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ];

            return true;
        }

        return false;
    }

    public function logout() {
        $this->startSession();
        session_destroy();
    }

    public function check() {
        $this->startSession();
        return isset($_SESSION['usuario']);
    }

    public function user() {
        $this->startSession();
        return $_SESSION['usuario'] ?? null;
    }
}
