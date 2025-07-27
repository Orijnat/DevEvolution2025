<?php
session_start();

require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Cliente.php';

use App\Database;
use App\Cliente;

if (!isset($_SESSION['id'])) {
    header('Location: ../login.php');
    exit;
}

$id_usuario = $_SESSION['id'];

$db = new Database();
$pdo = $db->getConnection();
$cliente = new Cliente($pdo);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';

    if ($cliente->criar($nome, $id_usuario)) {
        $mensagem = 'Cliente cadastrado com sucesso.';
    } else {
        $mensagem = 'Erro ao cadastrar cliente.';
    }
}

$clientes = $cliente->listarDoUsuario($id_usuario);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Cadastro de Clientes</h2>

<?php if ($mensagem): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
<?php endif; ?>

<form method="POST" class="w-50 mb-4">
    <div class="mb-3">
        <label>Nome:</label>
        <input type="text" name="nome" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Cadastrar Cliente</button>
</form>

<h4>Seus Clientes</h4>
<ul class="list-group w-50">
    <?php foreach ($clientes as $c): ?>
        <li class="list-group-item"><?= htmlspecialchars($c['nome']) ?></li>
    <?php endforeach; ?>
</ul>

<p class="mt-4"><a href="../dashboard.php" class="btn btn-secondary">Voltar ao painel</a></p>
</body>
</html>
