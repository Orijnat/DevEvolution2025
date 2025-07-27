<?php
session_start();

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Produto.php';

use App\Database;
use App\Produto;

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit;
}

$db = new Database();
$pdo = $db->getConnection();
$produto = new Produto($pdo);

$produtos = $produto->listar();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Produtos Disponíveis</h2>

<table class="table table-bordered w-75">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Ações</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td><?= $p['estoque'] ?></td>
            <td>
                <a href="../reservar.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">Reservar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<p class="mt-3"><a href="../dashboard.php" class="btn btn-secondary">Voltar</a></p>
</body>
</html>
