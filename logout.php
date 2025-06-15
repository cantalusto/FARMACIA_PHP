<?php
session_start();
$_SESSION = array();
session_destroy();

header("Refresh: 3; url=login.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saindo do Sistema - Farmácia Pague Mais</title>
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
        
        .logout-container {
            width: 100%;
            max-width: 500px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            padding: 3rem;
            position: relative;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pharmacy-icon {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(0, 95, 115, 0.2);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s linear infinite;
            margin: 2rem auto;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .redirect-message {
            color: var(--dark-color);
            opacity: 0.8;
            margin-top: 1.5rem;
            font-size: 0.9rem;
        }
        
        .goodbye-message {
            font-size: 1.2rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="pharmacy-icon">
            <i class="fas fa-prescription-bottle-alt"></i>
        </div>
        
        <h2 class="h4 mb-3" style="color: var(--primary-color);">Farmácia Pague Mais</h2>
        
        <div class="goodbye-message">
            <i class="fas fa-hand-wave me-2"></i> Até logo! Você está sendo desconectado...
        </div>
        
        <div class="loading-spinner"></div>
        
        <div class="redirect-message">
            Redirecionando para a página de login em 3 segundos
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>