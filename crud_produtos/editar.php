<?php require_once '../config/verificar_login.php'; ?>
<?php if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php?error=acesso_negado'); exit(); } ?>
<?php
require_once '../config/conexao.php';
$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

$stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = :id');
$stmt->execute([':id' => $id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) { die("Produto não encontrado."); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE produtos SET nome = :nome, fabricante = :fabricante, preco = :preco, quantidade_estoque = :quantidade WHERE id = :id";
    $stmt_update = $pdo->prepare($sql);
    try {
        $stmt_update->execute([':nome' => $_POST['nome'], ':fabricante' => $_POST['fabricante'], ':preco' => $_POST['preco'], ':quantidade' => $_POST['quantidade_estoque'], ':id' => $id]);
        header("Location: index.php?updated=1");
        exit;
    } catch (PDOException $e) { $error = "Erro: " . $e->getMessage(); }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #005f73;
            --secondary-color: #0a9396;
            --accent-color: #94d2bd;
            --light-color: #e9d8a6;
            --dark-color: #001219;
            --warning-color: #ffc107;
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
        
        .edit-panel {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .edit-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 1.5rem;
            position: relative;
        }
        
        .edit-header::after {
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
        
        .edit-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        
        .edit-body {
            padding: 2rem;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(148, 210, 189, 0.25);
        }
        
        .btn-update {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(10, 147, 150, 0.4);
        }
        
        .btn-cancel {
            background: white;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-cancel:hover {
            background-color: rgba(0, 95, 115, 0.1);
        }
        
        .error-message {
            animation: shake 0.5s;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        
        .price-input {
            position: relative;
        }
        
        .price-input::before {
            content: "R$";
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-color);
            font-weight: 500;
            z-index: 1;
        }
        
        .price-input input {
            padding-left: 30px !important;
        }
        
        .product-info {
            background-color: rgba(0, 95, 115, 0.05);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="edit-panel">
        <div class="edit-header">
            <div class="d-flex align-items-center">
                <div class="edit-icon">
                    <i class="fas fa-pills"></i>
                </div>
                <div>
                    <h1 class="h4 mb-0">Editar Produto</h1>
                    <p class="mb-0 small opacity-75">Farmácia Pague Mais - Sistema Administrativo</p>
                </div>
            </div>
        </div>
        
        <div class="edit-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger error-message mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <div class="product-info">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">ID do Produto</small>
                        <h5 class="mb-0">#<?= htmlspecialchars($produto['id']) ?></h5>
                    </div>
                    <div>
                        <small class="text-muted">Última atualização</small>
                        <h5 class="mb-0">
                            <?php 
                            // Verifica se a data existe antes de exibir
                            $dataExibir = '';
                            if (isset($produto['data_atualizacao'])) {
                                $dataExibir = $produto['data_atualizacao'];
                            } elseif (isset($produto['data_criacao'])) {
                                $dataExibir = $produto['data_criacao'];
                            }
                            
                            // Formata a data se existir, senão mostra mensagem
                            echo $dataExibir ? date('d/m/Y', strtotime($dataExibir)) : 'Data não disponível';
                            ?>
                        </h5>
                    </div>
                </div>
            </div>
            
            <div class="form-card">
                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-tag me-2"></i>Nome do Produto
                        </label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-industry me-2"></i>Fabricante
                        </label>
                        <input type="text" class="form-control" id="fabricante" name="fabricante" value="<?= htmlspecialchars($produto['fabricante']) ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="fas fa-dollar-sign me-2"></i>Preço
                            </label>
                            <div class="price-input">
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" value="<?= htmlspecialchars($produto['preco']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <label class="form-label">
                                <i class="fas fa-boxes me-2"></i>Quantidade em Estoque
                            </label>
                            <input type="number" class="form-control" id="quantidade_estoque" name="quantidade_estoque" value="<?= htmlspecialchars($produto['quantidade_estoque']) ?>" required>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-3">
                        <a href="index.php" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-update text-white">
                            <i class="fas fa-save me-2"></i> Atualizar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>