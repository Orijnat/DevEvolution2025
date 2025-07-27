<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$nome = htmlspecialchars($_SESSION['nome']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Bem-vindo, <?= $nome ?>!</h2>

<div class="mt-4">
    <a href="produtos.php" class="btn btn-primary me-2">Gerenciar Produtos</a>
    <a href="adicionar_produtos.php" class="btn btn-success me-2">Adicionar Produtos</a>
    <a href="logout.php" class="btn btn-danger">Sair</a>
</div>
</body>
</html>
