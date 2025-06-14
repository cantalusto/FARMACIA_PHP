<?php
require_once '../config/verificar_login.php';
require_once '../config/conexao.php';
$stmt = $pdo->query('SELECT id, nome, cpf, telefone FROM clientes ORDER BY nome');
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$is_admin = ($_SESSION['admin_tipo'] === 'admin');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Lista de Clientes</h2>
            <?php if ($is_admin): ?>
                <a href="adicionar.php" class="btn btn-success">Adicionar Novo Cliente</a>
            <?php endif; ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <?php if ($is_admin): ?>
                            <th>Ações</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['cpf']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                        <?php if ($is_admin): ?>
                        <td>
                            <a href="editar.php?id=<?= $cliente['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="excluir.php?id=<?= $cliente['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="../menu.php" class="btn btn-secondary mt-3">Voltar ao Menu</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>