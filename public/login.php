<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit('Método inválido.');
}

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

if (!$email || !$senha) {
    exit('Preencha e-mail e senha.');
}

try {
    $db = new Database();
    $pdo = $db->getPdo();

    $stmt = $pdo->prepare('SELECT * FROM clientes WHERE email = :email');
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: painel.php');
        exit;
    } else {
        exit('Usuário ou senha inválidos.');
    }
} catch (Exception $e) {
    exit('Erro: ' . $e->getMessage());
}
