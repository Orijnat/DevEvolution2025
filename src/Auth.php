<?php

namespace App;


use PDO;

class Auth{

    private $pdo;

    public function __construct(Database $db){
        $this->pdo = $db->getPdo();
    }

    public function login(string $email, string $senha) {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            session_start();
            $_SESSION ['usuario'] = $usuario ['nome'];
            return true;
        }
            return false;
    }

    public function logout(){
        session_start();
        session_destroy();
    }
    public function check(){
        session_start();
        return isset($_SESSION ['usuario']);
    }

    public function user() {
        session_start();
        return $_SESSION['usuario'];
    }
}