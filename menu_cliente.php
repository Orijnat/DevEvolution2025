<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$nome = $_SESSION['nome'] ?? 'Cliente';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu do Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<div class="text-center">
    <h2>Bem-vindo, <?= htmlspecialchars($nome) ?>!</h2>
    <p class="lead">O que você deseja fazer?</p>

    <div class="d-grid gap-3 col-6 mx-auto mt-4">
        <a href="produtos_cliente.php" class="btn btn-primary btn-lg">🛍 Ver Produtos e Comprar</a>
        <a href="/views/lista_compras.php" class="btn btn-info btn-lg">📄 Minhas Compras</a>
        <!-- Futuro: <a href="editar_cliente.php" class="btn btn-warning btn-lg">⚙️ Editar Meus Dados</a> -->
        <a href="logout.php" class="btn btn-danger btn-lg">🚪 Sair</a>
    </div>
</div>
</body>
</html>
