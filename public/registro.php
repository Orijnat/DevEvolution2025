<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Método inválido.');
}

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!$nome || !$email || !$senha) {
    exit("Preencha todos os campos obrigatórios.");
}

try {
    $db = new Database();
    $pdo = $db->getPdo();

    $stmt = $pdo->prepare("SELECT id FROM clientes WHERE email = :email");
    $stmt->execute([':email' => $email]);

    if ($stmt->fetch()) {
        exit("E-mail já está cadastrado.");
    }

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO clientes (nome, email, senha) VALUES (:nome, :email, :senha)");
    $ok = $stmt->execute([
        ':nome' => $nome,
        ':email' => $email,
        ':senha' => $senhaHash
    ]);

    if ($ok) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        $erro = $stmt->errorInfo();
        echo "Erro ao cadastrar: " . implode(" | ", $erro);
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
