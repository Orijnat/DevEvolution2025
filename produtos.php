<?php
session_start();

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Produto.php';
require_once __DIR__ . '/classes/Compra.php';
require_once __DIR__ . '/classes/Usuario.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
use App\Database;
use App\Produto;
use App\Compra;
use App\Usuario;

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$db = new Database();
$pdo = $db->getConnection();
$produto = new Produto($pdo);
$compra = new Compra($pdo);
$usuario = new Usuario($pdo);

// Exclusão de produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $idExcluir = (int) $_POST['excluir_id'];
    $produto->excluir($idExcluir);
    header('Location: produtos.php');
    exit;
}

$produtos = $produto->listar();

// Verifica se é admin
$ehAdmin = ($_SESSION['email'] === 'admin@email.com');
$compras = $ehAdmin ? $compra->listarTodosComUsuarios() : [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Gerenciar Produtos</h2>

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
                <form method="POST" style="display:inline;" onsubmit="return confirm('Confirma exclusão?');">
                    <input type="hidden" name="excluir_id" value="<?= $p['id'] ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                </form>
                <a href="editar_produto.php?id=<?= $p['id'] ?>" class="btn btn-warning btn-sm ms-1">Editar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (empty($produtos)): ?>
        <tr><td colspan="4">Nenhum produto cadastrado.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<?php if ($ehAdmin && !empty($compras)): ?>
    <h3 class="mt-5">Histórico de Compras</h3>
    <table class="table table-striped w-100">
        <thead>
        <tr>
            <th>Cliente</th>
            <th>Produto</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Total</th>
            <th>Data</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($compras as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c['nome_usuario']) ?></td>
                <td><?= htmlspecialchars($c['nome_produto']) ?></td>
                <td>R$ <?= number_format($c['preco'], 2, ',', '.') ?></td>
                <td><?= $c['quantidade'] ?></td>
                <td>R$ <?= number_format($c['preco'] * $c['quantidade'], 2, ',', '.') ?></td>
                <td><?= date('d/m/Y H:i', strtotime($c['data_compra'])) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<p><a href="dashboard.php" class="btn btn-secondary mt-4">Voltar ao Painel</a></p>
</body>
</html>
