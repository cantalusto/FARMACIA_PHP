<?php require_once '../config/verificar_login.php'; ?>
<?php if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php?error=acesso_negado'); exit(); } ?>
<?php
require_once '../config/conexao.php';

$id = $_GET['id'] ?? null;
if (!$id) { header('Location: index.php'); exit; }

// Busca o cliente antes de deletar para mostrar na tela de confirmação
$stmt = $pdo->prepare('SELECT * FROM clientes WHERE id = :id');
$stmt->execute([':id' => $id]);
$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) { header('Location: index.php?error=cliente_nao_encontrado'); exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = "DELETE FROM clientes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        header("Location: index.php?deleted=1");
        exit;
    } catch (PDOException $e) {
        $error = "Erro ao excluir cliente: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #005f73;
            --secondary-color: #0a9396;
            --accent-color: #94d2bd;
            --light-color: #e9d8a6;
            --dark-color: #001219;
            --danger-color: #d00000;
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
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .delete-header {
            background: linear-gradient(135deg, var(--danger-color) 0%, #9d0208 100%);
            color: white;
            padding: 1.5rem;
            position: relative;
        }
        
        .delete-header::after {
            content: "";
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 40px;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%239d0208"></path><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%239d0208"></path><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23FFFFFF"></path></svg>');
            background-size: cover;
            background-repeat: no-repeat;
        }
        
        .delete-icon {
            font-size: 2rem;
            margin-right: 1rem;
        }
        
        .delete-body {
            padding: 2rem;
        }
        
        .confirmation-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            border-left: 4px solid var(--danger-color);
        }
        
        .client-info {
            background-color: rgba(208, 0, 0, 0.05);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .client-detail {
            margin-bottom: 0.5rem;
        }
        
        .client-label {
            font-weight: 600;
            color: var(--dark-color);
            display: inline-block;
            width: 100px;
        }
        
        .btn-delete {
            background: linear-gradient(to right, var(--danger-color), #9d0208);
            border: none;
            padding: 10px 20px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(157, 2, 8, 0.4);
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
        
        .warning-message {
            background-color: #fff3cd;
            color: #856404;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 0 4px 4px 0;
        }
    </style>
</head>
<body>
    <div class="delete-panel">
        <div class="delete-header">
            <div class="d-flex align-items-center">
                <div class="delete-icon">
                    <i class="fas fa-user-times"></i>
                </div>
                <div>
                    <h1 class="h4 mb-0">Excluir Cliente</h1>
                    <p class="mb-0 small opacity-75">Farmácia Pague Mais - Sistema Administrativo</p>
                </div>
            </div>
        </div>
        
        <div class="delete-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <div class="warning-message">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Atenção!</strong> Esta ação é irreversível. Todos os dados do cliente serão permanentemente removidos do sistema.
            </div>
            
            <div class="client-info">
                <div class="mb-3">
                    <small class="text-muted">ID do Cliente</small>
                    <h5 class="mb-0">#<?= htmlspecialchars($cliente['id']) ?></h5>
                </div>
                
                <div class="client-detail">
                    <span class="client-label">Nome:</span>
                    <?= htmlspecialchars($cliente['nome']) ?>
                </div>
                
                <div class="client-detail">
                    <span class="client-label">CPF:</span>
                    <?= htmlspecialchars($cliente['cpf']) ?>
                </div>
                
                <div class="client-detail">
                    <span class="client-label">Telefone:</span>
                    <?= htmlspecialchars($cliente['telefone']) ?>
                </div>
                
                <div class="client-detail">
                    <span class="client-label">Endereço:</span>
                    <?= htmlspecialchars($cliente['endereco']) ?>
                </div>
            </div>
            
            <div class="confirmation-card">
                <form method="POST">
                    <div class="mb-4">
                        <p class="mb-3">Você tem certeza que deseja excluir permanentemente este cliente?</p>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                            <label class="form-check-label" for="confirmDelete">
                                Sim, eu confirmo que desejo excluir este cliente
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-3">
                        <a href="index.php" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-delete text-white">
                            <i class="fas fa-trash-alt me-2"></i> Confirmar Exclusão
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>