<?php

session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Compra.php';

use App\Database;
use App\Compra;

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$db = new Database();
$pdo = $db->getConnection();

$compra = new Compra($pdo);

$id_usuario = $_SESSION['id'];
$compras = $compra->listarPorUsuario($id_usuario);

// 👉 Calcular o total
$totalGeral = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Minhas Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Minhas Compras</h2>

<?php if (empty($compras)): ?>
    <p>Você ainda não realizou nenhuma compra.</p>
<?php else: ?>
    <table class="table table-bordered w-75">
        <thead>
        <tr>
            <th>Produto</th>
            <th>Preço Unitário</th>
            <th>Quantidade</th>
            <th>Data da Compra</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($compras as $c):
            $subtotal = $c['preco'] * $c['quantidade'];
            $totalGeral += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($c['nome_produto']) ?></td>
                <td>R$ <?= number_format($c['preco'], 2, ',', '.') ?></td>
                <td><?= $c['quantidade'] ?></td>
                <td><?= date('d/m/Y H:i', strtotime($c['data_compra'])) ?></td>
                <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
        <tr>
            <th colspan="4" class="text-end">Total já Gasto:</th>
            <th>R$ <?= number_format($totalGeral, 2, ',', '.') ?></th>
        </tr>
        </tfoot>
    </table>
<?php endif; ?>

<p><a href="/../DevEvolution2025/menu_cliente.php" class="btn btn-secondary">Voltar ao Painel</a></p>
</body>
</html>
