<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Produto.php';
require_once __DIR__ . '/classes/Compra.php';

use App\Database;
use App\Produto;
use App\Compra;

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$db = new Database();
$pdo = $db->getConnection();

$produto = new Produto($pdo);
$compra = new Compra($pdo);

$id_usuario = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_produto'], $_POST['quantidade'])) {
    $id_produto = (int)$_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    // Buscar o produto
    $dadosProduto = $produto->buscarPorId($id_produto);

    if (!$dadosProduto) {
        die('Produto não encontrado.');
    }

    if ($dadosProduto['estoque'] < $quantidade) {
        die('Estoque insuficiente.');
    }

    // Registrar compra
    $compra->registrar($id_usuario, $id_produto, $quantidade);

    // Atualizar estoque
    $novoEstoque = $dadosProduto['estoque'] - $quantidade;
    $produto->atualizarEstoque($id_produto, $novoEstoque);

    header('Location: /views/lista_compras.php');
    exit;
} else {
    die('Requisição inválida.');
}
