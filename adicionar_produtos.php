<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Produto.php';

use App\Database;
use App\Produto;

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$pdo = $db->getConnection();
$produto = new Produto($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    if ($produto->criar($nome, $preco, $estoque)) {
        header('Location:dashboard.php');
        exit;
    } else {
        $mensagem = 'Erro ao cadastrar produto.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Adicionar Produto</h2>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($mensagem) ?></div>
<?php endif; ?>

<form method="POST" class="w-50">
    <div class="mb-3">
        <label>Nome:</label>
        <input type="text" name="nome" class="form-control" required autofocus>
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

<p class="mt-3"><a href="dashboard.php">Voltar ao painel</a></p>
</body>
</html>
