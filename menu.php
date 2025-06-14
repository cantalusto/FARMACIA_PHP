<?php require_once 'config/verificar_login.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body, html { height: 100%; } .main-container { display: flex; align-items: center; justify-content: center; height: 100%; text-align: center; }</style>
</head>
<body>
    <div class="main-container">
        <div class="container">
            <div class="position-absolute top-0 end-0 p-3"><a href="logout.php" class="btn btn-danger">Sair</a></div>
            <h1 class="display-4 mb-4">Sistema da Farmácia Pague Mais</h1>
            <p class="lead mb-5">Bem-vindo(a), <?= htmlspecialchars($_SESSION['admin_usuario']) ?>! (<?= htmlspecialchars($_SESSION['admin_tipo']) ?>)</p>
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="crud_clientes/" class="btn btn-primary btn-lg px-4">Consultar Clientes</a>
                <a href="crud_produtos/" class="btn btn-success btn-lg px-4">Consultar Produtos</a>
                <?php if ($_SESSION['admin_tipo'] === 'admin'): ?>
                    <a href="crud_usuarios/" class="btn btn-warning btn-lg px-4">Gerenciar Usuários</a>
                <?php endif; ?>
            </div>
            <footer class="mt-5 text-muted"><p>Nomes dos integrantes do grupo: [Lucas Cantarelli, Danilo Mendes e Thiago Duarte]</p></footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>