<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Método inválido.');
}

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

if (!$nome || !$email || !$senha) {
    exit("Preencha todos os campos");
}

try {
    $db = new Database();
    $pdo = $db->getConexao();

    // Verifica se email já existe
    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE email = :email");
    $stmt->execute(['email' => $email]);

    if ($stmt->fetch()) {
        exit("E-mail já cadastrado");
    }

    // Hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir CLIENTE
    $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, senha) VALUES (:nome, :email, :senha)");

    $ok = $stmt->execute([
        'nome' => $nome,
        'email' => $email,
        'senha' => $senhaHash
    ]);

    if ($ok) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "Erro ao cadastrar: " . implode(' | ', $errorInfo);
    }

} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
header("login.html");
