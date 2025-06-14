<?php require_once '../config/verificar_login.php'; ?>
<?php
require_once '../config/conexao.php';
$stmt = $pdo->query('SELECT id, nome, fabricante, preco, quantidade_estoque FROM produtos ORDER BY nome');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gerenciar Produtos</h2>
            <a href="adicionar.php" class="btn btn-success">Adicionar Novo Produto</a>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr><th>Produto</th><th>Fabricante</th><th>Preço (R$)</th><th>Estoque</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                        <td><?= htmlspecialchars($produto['fabricante']) ?></td>
                        <td><?= number_format($produto['preco'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($produto['quantidade_estoque']) ?></td>
                        <td>
                            <a href="editar.php?id=<?= $produto['id'] ?>" class="btn btn-primary btn-sm">Editar</a>
                            <a href="excluir.php?id=<?= $produto['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </td>
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