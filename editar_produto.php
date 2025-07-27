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
$produtoObj = new Produto($pdo);

if (!isset($_GET['id'])) {
    die("ID do produto não especificado.");
}

$id = $_GET['id'];
$produto = $produtoObj->buscarPorId($id);

if (!$produto) {
    die("Produto não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $estoque = $_POST['estoque'] ?? 0;

    if ($produtoObj->editar($id, $nome, $preco, $estoque)) {
        header('Location: dashboard.php');
        exit;
    } else {
        $erro = "Erro ao atualizar o produto.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Editar Produto</h2>

<?php if (isset($erro)): ?>
    <div class="alert alert-danger"><?= $erro ?></div>
<?php endif; ?>

<form method="POST" class="w-50">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($produto['nome']) ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="preco" class="form-label">Preço:</label>
        <input type="number" step="0.01" name="preco" id="preco" value="<?= $produto['preco'] ?>" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="estoque" class="form-label">Estoque:</label>
        <input type="number" name="estoque" id="estoque" value="<?= $produto['estoque'] ?>" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancelar</a>
</form>
</body>
</html>
