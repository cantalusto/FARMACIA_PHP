<?php
require_once '../config/verificar_login.php';
if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php'); exit(); }
require_once '../config/conexao.php';
$id = $_GET['id'] ?? null;
if ($id == $_SESSION['admin_id']) { die("Ação proibida: Você não pode editar sua própria conta."); }
if (!$id) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM administradores WHERE id = :id");
$stmt->execute([':id' => $id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_usuario = $_POST['usuario'];
    $novo_tipo = $_POST['tipo'];
    if (!empty($_POST['senha'])) {
        $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $sql = "UPDATE administradores SET usuario = :usuario, tipo = :tipo, senha = :senha WHERE id = :id";
        $stmt_update = $pdo->prepare($sql);
        $stmt_update->execute([':usuario' => $novo_usuario, ':tipo' => $novo_tipo, ':senha' => $senha_hash, ':id' => $id]);
    } else {
        $sql = "UPDATE administradores SET usuario = :usuario, tipo = :tipo WHERE id = :id";
        $stmt_update = $pdo->prepare($sql);
        $stmt_update->execute([':usuario' => $novo_usuario, ':tipo' => $novo_tipo, ':id' => $id]);
    }
    header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário - Farmácia Pague Mais</title>
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
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
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
        
        .password-note {
            background-color: rgba(255, 193, 7, 0.1);
            border-left: 4px solid var(--warning-color);
            padding: 1rem;
            border-radius: 0 8px 8px 0;
            margin-bottom: 1.5rem;
        }
        
        .type-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
        }
        
        .badge-admin {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        .badge-funcionario {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }
        
        .user-info {
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
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h1 class="h4 mb-0">Editar Usuário</h1>
                    <p class="mb-0 small opacity-75">Farmácia Pague Mais - Sistema Administrativo</p>
                </div>
            </div>
        </div>
        
        <div class="edit-body">
            <div class="form-card">
                <form method="POST">
                    <div class="user-info mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted">ID do Usuário</small>
                                <h5 class="mb-0">#<?= htmlspecialchars($usuario['id']) ?></h5>
                            </div>
                            <div>
                                <small class="text-muted">Tipo Atual</small>
                                <div class="type-badge <?= $usuario['tipo'] === 'admin' ? 'badge-admin' : 'badge-funcionario' ?>">
                                    <i class="fas <?= $usuario['tipo'] === 'admin' ? 'fa-user-shield' : 'fa-user' ?> me-1"></i>
                                    <?= ucfirst(htmlspecialchars($usuario['tipo'])) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Nome de Usuário
                        </label>
                        <input type="text" class="form-control" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>
                    </div>
                    
                    <div class="password-note">
                        <h5 class="h6 mb-2"><i class="fas fa-exclamation-circle me-2"></i>Alteração de Senha</h5>
                        <p class="small mb-0">Preencha o campo abaixo apenas se desejar alterar a senha atual. Deixe em branco para manter a senha existente.</p>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-key me-2"></i>Nova Senha
                        </label>
                        <input type="password" class="form-control" name="senha" placeholder="Deixe em branco para não alterar">
                        <div class="form-text">A senha deve ter no mínimo 6 caracteres</div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="fas fa-user-tag me-2"></i>Tipo de Usuário
                        </label>
                        <select name="tipo" class="form-select" required>
                            <option value="funcionario" <?= $usuario['tipo'] == 'funcionario' ? 'selected' : '' ?>>Funcionário</option>
                            <option value="admin" <?= $usuario['tipo'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                        </select>
                        <div class="form-text mt-2">
                            <span class="type-badge badge-funcionario me-2"><i class="fas fa-user me-1"></i> Funcionário</span> - Acesso limitado
                            <br>
                            <span class="type-badge badge-admin mt-2"><i class="fas fa-user-shield me-1"></i> Administrador</span> - Acesso completo ao sistema
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between pt-3">
                        <a href="index.php" class="btn btn-cancel">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-update text-white">
                            <i class="fas fa-save me-2"></i> Atualizar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>