<?php 
require_once '../config/verificar_login.php'; 
if ($_SESSION['admin_tipo'] !== 'admin') { 
    header('Location: ../menu.php?error=acesso_negado'); 
    exit(); 
}

require_once '../config/conexao.php';

$id = $_GET['id'] ?? null;
$confirmado = $_GET['confirmado'] ?? false;

// Verificar se o produto existe
if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Processar exclusão se confirmado
if ($id && $confirmado && $produto) {
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    header("Location: index.php?excluido=1");
    exit;
}

// Redirecionar se ID inválido ou produto não encontrado
if (!$id || !$produto) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Produto - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #005f73;
            --secondary-color: #0a9396;
            --accent-color: #94d2bd;
            --light-color: #e9d8a6;
            --dark-color: #001219;
            --danger-color: #dc3545;
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
        
        .delete-panel {
            max-width: 600px;
            margin: 2rem auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .delete-header {
            background: linear-gradient(135deg, var(--danger-color) 0%, #c82333 100%);
            color: white;
            padding: 1.5rem;
            position: relative;
            text-align: center;
        }
        
        .delete-header::after {
            content: "";
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23c82333"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23c82333"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23FFFFFF"></path></svg>');
            background-size: cover;
            background-repeat: no-repeat;
        }
        
        .delete-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: white;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .delete-body {
            padding: 2rem;
            text-align: center;
        }
        
        .product-card {
            background-color: rgba(220, 53, 69, 0.05);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--danger-color);
            text-align: left;
        }
        
        .warning-message {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid var(--warning-color);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
            margin-bottom: 2rem;
            text-align: left;
        }
        
        .btn-delete {
            background: linear-gradient(to right, var(--danger-color), #c82333);
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
            margin-right: 1rem;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        
        .btn-cancel {
            background: white;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background-color: rgba(0, 95, 115, 0.1);
        }
        
        .price-badge {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="delete-panel">
        <div class="delete-header">
            <div class="delete-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="h4 mb-0">Confirmar Exclusão</h1>
            <p class="mb-0 small opacity-75">Farmácia Pague Mais - Sistema Administrativo</p>
        </div>
        
        <div class="delete-body">
            <?php if ($produto): ?>
                <div class="product-card">
                    <div class="mb-3">
                        <small class="text-muted">Produto a ser excluído</small>
                        <h4 class="mb-1"><?= htmlspecialchars($produto['nome']) ?></h4>
                        <p class="mb-0 text-muted"><?= htmlspecialchars($produto['fabricante']) ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <small class="text-muted">Preço</small>
                            <div class="price-badge">
                                R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">Estoque</small>
                            <h5 class="mb-0"><?= htmlspecialchars($produto['quantidade_estoque']) ?> unidades</h5>
                        </div>
                    </div>
                </div>
                
                <div class="warning-message">
                    <h5 class="h6 mb-2"><i class="fas fa-exclamation-triangle me-2"></i>Atenção!</h5>
                    <p class="mb-0">Esta ação é irreversível. O produto será permanentemente removido do sistema e do estoque.</p>
                </div>
                
                <div class="d-flex justify-content-center">
                    <a href="excluir.php?id=<?= $id ?>&confirmado=1" class="btn btn-delete text-white">
                        <i class="fas fa-trash-alt me-2"></i> Confirmar Exclusão
                    </a>
                    <a href="index.php" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i> Cancelar
                    </a>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> Produto não encontrado
                </div>
                <a href="index.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i> Voltar
                </a>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>