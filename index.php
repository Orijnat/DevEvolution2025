<?php
session_start();
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Usuario.php';


use App\Database;
use App\Usuario;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $pdo = $db->getConnection();

    $usuario = new Usuario($pdo);
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $usuarioLogado = $usuario->logar($email, $senha);

    if ($usuarioLogado) {
        $_SESSION['id'] = $usuarioLogado['id'];
        $_SESSION['nome'] = $usuarioLogado['nome'];
        $_SESSION['email'] = $usuarioLogado['email'];


        if ($_SESSION['email'] === 'admin@email.com') {
            header('Location: dashboard.php');
        } else {
            header('Location: menu_cliente.php');
        }
        exit;
    } else {
        $erro = 'E-mail ou senha inválidos!';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema de Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
<h2 class="mb-4">Login</h2>

<?php if ($erro): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
<?php endif; ?>

<form method="POST" class="w-50">
    <div class="mb-3">
        <label>Email:</label>
        <input type="email" name="email" class="form-control" required autofocus>
    </div>
    <div class="mb-3">
        <label>Senha:</label>
        <input type="password" name="senha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Entrar</button>
</form>

<p class="mt-3">Ainda não tem conta? <a href="cadastro_usuario.php">Cadastre-se</a></p>
</body>
</html>
