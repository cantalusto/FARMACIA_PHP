<?php
require_once '../config/verificar_login.php';
if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php'); exit(); }
require_once '../config/conexao.php';
$id = $_GET['id'] ?? null;
if ($id == $_SESSION['admin_id']) { die("Ação proibida: Você não pode editar sua própria conta."); }
if (!$id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM administradores WHERE id = :id");
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_usuario = $_POST['usuario'];
    $novo_tipo = $_POST['tipo'];
    if (!empty($_POST['senha'])) {
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql = "UPDATE administradores SET usuario = :usuario, tipo = :tipo, senha = :senha WHERE id = :id";
        $stmt_update = $pdo->prepare($sql);
        $stmt_update->execute([':usuario' => $novo_usuario, ':tipo' => $novo_tipo, ':senha' => $senha_hash, ':id' => $id]);
    } else {
        $sql = "UPDATE administradores SET usuario = :usuario, tipo = :tipo WHERE id = :id";
        $stmt_update = $pdo->prepare($sql);
        $stmt_update->execute([':usuario' => $novo_usuario, ':tipo' => $novo_tipo, ':id' => $id]);
    }
    header("Location: index.php"); exit;
}
?>
<!DOCTYPE html><html><head><title>Editar Usuário</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
    <div class="container mt-5">
        <h2>Editar Usuário</h2>
        <form method="POST" class="mt-4">
            <div class="mb-3"><label class="form-label">Usuário</label><input type="text" class="form-control" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required></div>
            <div class="mb-3"><label class="form-label">Nova Senha (deixe em branco para não alterar)</label><input type="password" class="form-control" name="senha"></div>
            <div class="mb-3"><label class="form-label">Tipo</label><select name="tipo" class="form-select" required><option value="funcionario" <?= $usuario['tipo'] == 'funcionario' ? 'selected' : '' ?>>Funcionário</option><option value="admin" <?= $usuario['tipo'] == 'admin' ? 'selected' : '' ?>>Admin</option></select></div>
            <button type="submit" class="btn btn-primary">Atualizar</button><a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body></html>