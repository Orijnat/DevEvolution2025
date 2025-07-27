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

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    if ($produto->criar($nome, $preco, $estoque)) {
        $mensagem = 'Produto cadastrado com sucesso.';
    } else {
        $mensagem = 'Erro ao cadastrar produto.';
    }
}

$lista = $produto->listar();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Cadastro de Produtos</h2>

<?php if ($mensagem): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
<?php endif; ?>

<form method="POST" class="w-50 mb-4">
    <div class="mb-3">
        <label>Nome:</label>
        <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Estoque:</label>
        <input type="number" name="estoque" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Cadastrar Produto</button>
</form>

<h4>Lista de Produtos</h4>
<table class="table table-striped w-75">
    <thead>
    <tr>
        <th>Nome</th>
        <th>Preço</th>
        <th>Estoque</th>
        <th>Ação</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($lista as $p): ?>
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

<p class="mt-4"><a href="../dashboard.php" class="btn btn-secondary">Voltar ao painel</a></p>
</body>
</html>
