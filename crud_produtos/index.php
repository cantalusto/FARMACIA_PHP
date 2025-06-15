<?php
require_once '../config/verificar_login.php';
require_once '../config/conexao.php';
$stmt = $pdo->query('SELECT id, nome, fabricante, preco, quantidade_estoque FROM produtos ORDER BY nome');
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$is_admin = ($_SESSION['admin_tipo'] === 'admin');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Produtos - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #005f73;
            --secondary-color: #0a9396;
            --accent-color: #94d2bd;
            --light-color: #e9d8a6;
            --dark-color: #001219;
            --success-color: #28a745;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.03"><path d="M30,10 Q50,5 70,10 T90,30 Q95,50 90,70 T70,90 Q50,95 30,90 T10,70 Q5,50 10,30 T30,10 Z" fill="%23005f73"/></svg>');
            background-size: 120px;
            z-index: -1;
        }
        
        .products-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .products-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1.5rem;
            position: relative;
        }
        
        .products-header::after {
            content: "";
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%230a9396"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%230a9396"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23FFFFFF"></path></svg>');
            background-size: cover;
            background-repeat: no-repeat;
        }
        
        .products-title {
            display: flex;
            align-items: center;
        }
        
        .products-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        
        .products-body {
            padding: 2rem;
        }
        
        .table-products {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .table-products thead {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
        }
        
        .table-products th {
            font-weight: 600;
            padding: 1rem;
        }
        
        .table-products td {
            vertical-align: middle;
            padding: 1rem;
        }
        
        .btn-add {
            background: linear-gradient(to right, var(--success-color), #218838);
            border: none;
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        
        .btn-edit {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border: none;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-edit:hover {
            background-color: rgba(13, 110, 253, 0.2);
        }
        
        .btn-delete {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            border: none;
            padding: 0.35rem 0.75rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-delete:hover {
            background-color: rgba(220, 53, 69, 0.2);
        }
        
        .btn-back {
            background: white;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background-color: rgba(0, 95, 115, 0.1);
        }
        
        .stock-low {
            color: #dc3545;
            font-weight: 600;
        }
        
        .stock-ok {
            color: #28a745;
            font-weight: 600;
        }
        
        .actions-cell {
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="products-container">
        <div class="products-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="products-title">
                    <div class="products-icon">
                        <i class="fas fa-pills"></i>
                    </div>
                    <div>
                        <h1 class="h4 mb-0">Gestão de Produtos</h1>
                        <p class="mb-0 small opacity-75">Farmácia Pague Mais - Sistema Administrativo</p>
                    </div>
                </div>
                <?php if ($is_admin): ?>
                    <a href="adicionar.php" class="btn btn-add text-white">
                        <i class="fas fa-plus-circle me-2"></i> Novo Produto
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="products-body">
            <div class="table-responsive">
                <table class="table table-products">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Fabricante</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <?php if ($is_admin): ?>
                                <th>Ações</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td><?= htmlspecialchars($produto['fabricante']) ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td class="<?= $produto['quantidade_estoque'] < 10 ? 'stock-low' : 'stock-ok' ?>">
                                <?= htmlspecialchars($produto['quantidade_estoque']) ?>
                                <small>unidades</small>
                            </td>
                            <?php if ($is_admin): ?>
                            <td class="actions-cell">
                                <a href="editar.php?id=<?= $produto['id'] ?>" class="btn btn-edit btn-sm">
                                    <i class="fas fa-edit me-1"></i> Editar
                                </a>
                                <a href="excluir.php?id=<?= $produto['id'] ?>" class="btn btn-delete btn-sm" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                    <i class="fas fa-trash-alt me-1"></i> Excluir
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-4">
                <a href="../menu.php" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Voltar ao Menu
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>