<?php require_once '../config/verificar_login.php'; ?>
<?php if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php?error=acesso_negado'); exit(); } ?>
<?php
require_once '../config/conexao.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT * FROM clientes WHERE id = :id');
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) { die("Cliente não encontrado."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE clientes SET nome = :nome, cpf = :cpf, telefone = :telefone, endereco = :endereco WHERE id = :id";
    $stmt_update = $pdo->prepare($sql);
    try {
        $stmt_update->execute([':nome' => $_POST['nome'], ':cpf' => $_POST['cpf'], ':telefone' => $_POST['telefone'], ':endereco' => $_POST['endereco'], ':id' => $id]);
        header("Location: index.php");
        exit;
    } catch (PDOException $e) { $error = "Erro: " . $e->getMessage(); }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Cliente</h2>
        <?php if (isset($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
        <form method="POST" class="mt-4">
            <div class="mb-3"><label for="nome" class="form-label">Nome Completo</label><input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required></div>
            <div class="mb-3"><label for="cpf" class="form-label">CPF</label><input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>" required></div>
            <div class="mb-3"><label for="telefone" class="form-label">Telefone</label><input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>" required></div>
            <div class="mb-3"><label for="endereco" class="form-label">Endereço</label><input type="text" class="form-control" id="endereco" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>"></div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>