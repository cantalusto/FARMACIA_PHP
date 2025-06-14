<?php
session_start();
if (isset($_SESSION['admin_id'])) { header('Location: menu.php'); exit; }
require_once 'config/conexao.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    if (empty($usuario) || empty($senha)) {
        $error = 'Por favor, preencha todos os campos.';
    } else {
        $sql = "SELECT id, usuario, senha, tipo FROM administradores WHERE usuario = :usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($admin && password_verify($senha, $admin['senha'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_usuario'] = $admin['usuario'];
            $_SESSION['admin_tipo'] = $admin['tipo'];
            header('Location: menu.php');
            exit;
        } else {
            $error = 'Usuário ou senha inválidos.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>html, body { height: 100%; } body { display: flex; align-items: center; justify-content: center; background-color: #f8f9fa; } .form-signin { max-width: 400px; padding: 1rem; }</style>
</head>
<body class="text-center">
    <main class="form-signin w-100 m-auto">
        <form method="POST">
            <h1 class="h3 mb-3 fw-normal">Farmácia Pague Mais</h1>
            <h2 class="h5 mb-3 fw-normal">Faça seu login</h2>
            <?php if ($error): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
            <div class="form-floating mb-2"><input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuário" required><label for="usuario">Usuário</label></div>
            <div class="form-floating mb-3"><input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required><label for="senha">Senha</label></div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2025</p>
        </form>
    </main>
</body>
</html>