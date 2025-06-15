<?php require_once 'config/verificar_login.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Principal - Farmácia Pague Mais</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #005f73;
            --secondary-color: #0a9396;
            --accent-color: #94d2bd;
            --light-color: #e9d8a6;
            --dark-color: #001219;
        }
        
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
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
        
        .main-container {
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .pharmacy-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }
        
        .pharmacy-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 3rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .welcome-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
        }
        
        .user-badge {
            background: linear-gradient(135deg, var(--light-color) 0%, var(--accent-color) 100%);
            color: var(--dark-color);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            margin-top: 1rem;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .menu-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid rgba(0, 0, 0, 0.03);
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* ADICIONADO PARA REMOVER O SUBLINHADO */
            text-decoration: none; 
            color: inherit;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .menu-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
            background: linear-gradient(135deg, rgba(0, 95, 115, 0.1) 0%, rgba(10, 147, 150, 0.1) 100%);
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-logout {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            background: linear-gradient(to right, #dc3545, #c82333);
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1.25rem;
            color: white;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
            transition: all 0.3s;
            z-index: 1000;
        }
        
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        
        .footer {
            margin-top: 4rem;
            text-align: center;
            color: var(--dark-color);
            opacity: 0.7;
            font-size: 0.9rem;
            padding: 1.5rem;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .footer p {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <a href="logout.php" class="btn-logout">
        <i class="fas fa-sign-out-alt me-2"></i> Sair
    </a>

    <div class="main-container">
        <div class="pharmacy-header">
            <div class="pharmacy-icon">
                <i class="fas fa-prescription-bottle-alt"></i>
            </div>
            <h1 class="display-4 fw-bold" style="color: var(--primary-color);">Sistema Farmacêutico</h1>
            <p class="lead">Farmácia Pague Mais</p>
        </div>
        
        <div class="welcome-card text-center">
            <h2 class="h3 mb-3">Bem-vindo(a) ao Painel Administrativo</h2>
            <div class="user-badge">
                <i class="fas fa-user-circle me-2"></i>
                <?= htmlspecialchars($_SESSION['admin_usuario']) ?> 
                <span class="badge bg-primary ms-2"><?= htmlspecialchars($_SESSION['admin_tipo']) ?></span>
            </div>
        </div>
        
        <div class="menu-grid">
            <a href="crud_clientes/" class="menu-card">
                <div class="menu-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>Clientes</h3>
                <p class="text-muted">Gerencie o cadastro de clientes</p>
                <div class="mt-3 btn btn-outline-primary">Acessar</div>
            </a>
            
            <a href="crud_produtos/" class="menu-card">
                <div class="menu-icon">
                    <i class="fas fa-pills"></i>
                </div>
                <h3>Produtos</h3>
                <p class="text-muted">Controle seu estoque de medicamentos</p>
                <div class="mt-3 btn btn-outline-success">Acessar</div>
            </a>
            
            <?php if ($_SESSION['admin_tipo'] === 'admin'): ?>
            <a href="crud_usuarios/" class="menu-card">
                <div class="menu-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3>Usuários</h3>
                <p class="text-muted">Gerencie os acessos ao sistema</p>
                <div class="mt-3 btn btn-outline-warning">Acessar</div>
            </a>
            <?php endif; ?>
        </div>
        
        <div class="footer">
            <p>© 2025 Farmácia Pague Mais | Desenvolvido por: Lucas Cantarelli, Danilo Mendes e Thiago Duarte</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>