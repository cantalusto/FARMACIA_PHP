<?php
require_once 'config/conexao.php';
$usuario = 'admin';
$senha_texto = 'admin123';
$senha_hash = password_hash($senha_texto, PASSWORD_DEFAULT);

$sql = "INSERT INTO administradores (usuario, senha, tipo) VALUES (:usuario, :senha, 'admin')";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criação de Administrador - Farmácia Pague Mais</title>
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
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" opacity="0.05"><path d="M30,10 Q50,5 70,10 T90,30 Q95,50 90,70 T70,90 Q50,95 30,90 T10,70 Q5,50 10,30 T30,10 Z" fill="%23005f73"/></svg>');
            background-size: 120px;
            z-index: -1;
        }
        
        .admin-container {
            width: 100%;
            max-width: 600px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            padding: 2.5rem;
            text-align: center;
        }
        
        .admin-header {
            margin-bottom: 2rem;
        }
        
        .admin-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .result-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--primary-color);
        }
        
        .success-result {
            border-left-color: var(--secondary-color);
        }
        
        .error-result {
            border-left-color: var(--danger-color);
        }
        
        .credentials-box {
            background: rgba(0, 95, 115, 0.05);
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border: 1px dashed var(--primary-color);
        }
        
        .warning-box {
            background: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            padding: 1.5rem;
            margin-top: 2rem;
            border-left: 5px solid var(--danger-color);
            text-align: left;
        }
        
        .btn-return {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 1.5rem;
            transition: all 0.3s;
        }
        
        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(10, 147, 150, 0.4);
            color: white;
        }
        
        .credential-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .credential-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <h1 style="color: var(--primary-color);">Configuração de Administrador</h1>
            <p class="text-muted">Farmácia Pague Mais</p>
        </div>
        
        <?php
        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':usuario' => $usuario, ':senha' => $senha_hash]);
        ?>
            <div class="result-card success-result">
                <i class="fas fa-check-circle fa-3x mb-3" style="color: var(--secondary-color);"></i>
                <h2 class="h4 mb-3">Administrador 'master' criado com sucesso!</h2>
                
                <div class="credentials-box">
                    <div class="credential-item">
                        <span><i class="fas fa-user me-2"></i> <strong>Usuário:</strong></span>
                        <span><?= htmlspecialchars($usuario) ?></span>
                    </div>
                    <div class="credential-item">
                        <span><i class="fas fa-key me-2"></i> <strong>Senha (texto):</strong></span>
                        <span><?= htmlspecialchars($senha_texto) ?></span>
                    </div>
                    <div class="credential-item">
                        <span><i class="fas fa-user-tag me-2"></i> <strong>Tipo:</strong></span>
                        <span>admin</span>
                    </div>
                </div>
                
                <div class="warning-box">
                    <h3 class="h5" style="color: var(--danger-color);">
                        <i class="fas fa-exclamation-triangle me-2"></i> Importante!
                    </h3>
                    <p class="mb-0">Por questões de segurança, apague o arquivo <code>criar_admin.php</code> do seu servidor imediatamente após a criação deste usuário.</p>
                </div>
                
                <a href="login.php" class="btn btn-return">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para o Login
                </a>
            </div>
        <?php
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
        ?>
            <div class="result-card error-result">
                <i class="fas fa-exclamation-circle fa-3x mb-3" style="color: var(--danger-color);"></i>
                <h2 class="h4 mb-3">Usuário já existe</h2>
                <p>O usuário <strong><?= htmlspecialchars($usuario) ?></strong> já está cadastrado no sistema.</p>
                
                <a href="login.php" class="btn btn-return">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para o Login
                </a>
            </div>
        <?php
            } else {
        ?>
            <div class="result-card error-result">
                <i class="fas fa-times-circle fa-3x mb-3" style="color: var(--danger-color);"></i>
                <h2 class="h4 mb-3">Erro ao criar administrador</h2>
                <p><?= htmlspecialchars($e->getMessage()) ?></p>
                
                <a href="login.php" class="btn btn-return">
                    <i class="fas fa-arrow-left me-2"></i> Voltar para o Login
                </a>
            </div>
        <?php
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>