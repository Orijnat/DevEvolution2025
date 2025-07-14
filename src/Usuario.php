<?php

class Usuario
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

public function login($email, $senha)
{
    $sql = "SELECT * FROM usuarios WHERE email= ?";
    $stmt= $this->pdo->prepare($sql);
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if($usuario && password_verify($senha, $usuario['senha'])){
        return $usuario;
    }
    return false;
}
}