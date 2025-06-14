<?php require_once '../config/verificar_login.php'; ?>
<?php if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php?error=acesso_negado'); exit(); } ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../config/conexao.php';
    $sql = "INSERT INTO produtos (nome, fabricante, preco, quantidade_estoque) VALUES (:nome, :fabricante, :preco, :quantidade)";
    $stmt = $pdo->prepare($sql);
    try {
        $stmt->execute([':nome' => $_POST['nome'], ':fabricante' => $_POST['fabricante'], ':preco' => $_POST['preco'], ':quantidade' => $_POST['quantidade_estoque']]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) { $error = "Erro: " . $e->getMessage(); }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Produto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Adicionar Novo Produto</h2>
        <?php if (isset($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST" class="mt-4">
            <div class="mb-3"><label for="nome" class="form-label">Nome do Produto</label><input type="text" class="form-control" id="nome" name="nome" required></div>
            <div class="mb-3"><label for="fabricante" class="form-label">Fabricante</label><input type="text" class="form-control" id="fabricante" name="fabricante" required></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label for="preco" class="form-label">Preço (R$)</label><input type="number" step="0.01" class="form-control" id="preco" name="preco" required></div>
                <div class="col-md-6 mb-3"><label for="quantidade_estoque" class="form-label">Estoque</label><input type="number" class="form-control" id="quantidade_estoque" name="quantidade_estoque" required></div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>