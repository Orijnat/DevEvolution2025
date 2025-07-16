<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Database;
use App\Produto;

$db = new Database();
$pdo = $db->getConexao();
$produto = new Produto($pdo);

// Pegar dados do formulário
$nome = $_POST['nome'] ?? '';
$descricao = $_POST['descricao'] ?? '';
$quantidade = (int) ($_POST['quantidade'] ?? 0);

if ($nome && $quantidade > 0) {
    $produto->inserir($nome, $descricao, $quantidade);
    echo " Produto salvo com sucesso!<br>";
    echo "<a href='cadastro_produtos.html'>Voltar</a>";
} else {
    echo "⚠ Preencha todos os campos obrigatórios.";
}