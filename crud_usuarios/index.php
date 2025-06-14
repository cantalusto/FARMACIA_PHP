<?php
require_once '../config/verificar_login.php';
if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php'); exit(); }
require_once '../config/conexao.php';
$stmt = $pdo->query("SELECT id, usuario, tipo FROM administradores ORDER BY usuario");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html><html lang="pt-br"><head><meta charset="UTF-8"><title>Gerenciar Usuários</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3"><h2>Gerenciar Usuários</h2><a href="adicionar.php" class="btn btn-success">Adicionar Usuário</a></div>
        <table class="table table-striped table-hover">
            <thead class="table-dark"><tr><th>Usuário</th><th>Tipo</th><th>Ações</th></tr></thead>
            <tbody><?php foreach ($usuarios as $usuario): ?><tr>
                <td><?= htmlspecialchars($usuario['usuario']) ?></td><td><?= htmlspecialchars($usuario['tipo']) ?></td>
                <td><?php if ($_SESSION['admin_id'] != $usuario['id']): ?><a href="editar.php?id=<?= $usuario['id'] ?>" class="btn btn-primary btn-sm">Editar</a> <a href="excluir.php?id=<?= $usuario['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a><?php else: ?><span class="text-muted fst-italic">Ação não permitida</span><?php endif; ?></td>
            </tr><?php endforeach; ?></tbody>
        </table>
        <a href="../menu.php" class="btn btn-secondary mt-3">Voltar ao Menu</a>
    </div>
</body></html>