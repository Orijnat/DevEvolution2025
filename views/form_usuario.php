<?php
require_once __DIR__ . '/../classes/Database.php';
require_once __DIR__ . '/../classes/Usuario.php';

use App\Database;
use App\Usuario;

$db = new Database();
$pdo = $db->getConnection();
$usuario = new Usuario($pdo);

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if ($usuario->cadastrar($nome, $email, $senha)) {
        $mensagem = 'Usuário cadastrado com sucesso.';
    } else {
        $mensagem = 'Erro ao cadastrar usuário.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2>Cadastro de Usuário</h2>

<?php if ($mensagem): ?>
    <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
<?php endif; ?>

<form method="POST" class="w-50">
    <div class="mb-3">
        <label>Nome:</label>
        <input type="text" name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Senha:</label>
        <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

<p class="mt-3"><a href="../login.php">Voltar ao login</a></p>
</body>
</html>
