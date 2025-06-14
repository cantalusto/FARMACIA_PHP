<?php
require_once '../config/verificar_login.php';
if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php'); exit(); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/conexao.php';
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $stmt_check = $pdo->prepare("SELECT id FROM administradores WHERE usuario = :usuario");
    $stmt_check->execute([':usuario' => $usuario]);
    if ($stmt_check->fetch()) {
        $error = 'Este nome de usuário já existe.';
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO administradores (usuario, senha, tipo) VALUES (:usuario, :senha, :tipo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':usuario' => $usuario, ':senha' => $senha_hash, ':tipo' => $tipo]);
        header("Location: index.php"); exit;
    }
}
?>
<!DOCTYPE html><html><head><title>Adicionar Usuário</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
    <div class="container mt-5">
        <h2>Adicionar Novo Usuário</h2>
        <?php if (isset($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST" class="mt-4">
            <div class="mb-3"><label class="form-label">Usuário</label><input type="text" class="form-control" name="usuario" required></div>
            <div class="mb-3"><label class="form-label">Senha</label><input type="password" class="form-control" name="senha" required></div>
            <div class="mb-3"><label class="form-label">Tipo</label><select name="tipo" class="form-select" required><option value="funcionario">Funcionário</option><option value="admin">Admin</option></select></div>
            <button type="submit" class="btn btn-primary">Salvar</button><a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body></html>