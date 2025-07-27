<?php
session_start();

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Produto.php';

use App\Database;
use App\Produto;

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
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
    <title>Produtos para Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>🛒 Produtos Disponíveis</h2>

<table class="table table-bordered w-75">
    <thead class="table-light">
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nome']) ?></td>
            <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
            <td><?= $p['estoque'] ?></td>
            <td>
                <?php if ($p['estoque'] > 0): ?>
                    <form method="POST" action="comprar.php" class="d-flex gap-2 align-items-center">
                        <input type="hidden" name="id_produto" value="<?= $p['id'] ?>">
                        <input type="number" name="quantidade" value="1" min="1" max="<?= $p['estoque'] ?>" class="form-control form-control-sm" style="width: 80px;">
                        <button type="submit" class="btn btn-success btn-sm">Comprar</button>
                    </form>
                <?php else: ?>
                    <span class="text-danger">Indisponível</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($produtos)): ?>
        <tr><td colspan="4" class="text-center">Nenhum produto disponível no momento.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<a href="menu_cliente.php" class="btn btn-secondary mt-3">⬅ Voltar ao Menu</a>

</body>
</html>
