<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;

session_start();

if (!isset($_SESSION['usuario_id'])) {
    exit("Você precisa estar logado para cadastrar um produto.");
}

$nome = $_POST["nome"] ?? '';
$descricao = $_POST["descricao"] ?? '';
$quantidade = (int)($_POST["quantidade"] ?? 0);
$usuarioId = $_SESSION["usuario_id"];

if (!$nome) {
    exit('Preencha o nome do produto.');
}

try {
    $db = new Database();
    $pdo = $db->getPdo();

    $stmt = $pdo->prepare("
        INSERT INTO produtos (nome, descricao, quantidade, usuario_id, data_reserva)
        VALUES (:nome, :descricao, :quantidade, :usuario_id, :data_reserva)
    ");

    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':quantidade' => $quantidade,
        ':usuario_id' => $usuarioId,
        ':data_reserva' => time()
    ]);

    echo "Produto cadastrado com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao cadastrar o produto: " . $e->getMessage();
}
