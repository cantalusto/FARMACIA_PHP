<?php
require_once 'config/conexao.php';
$usuario = 'admin';
$senha_texto = 'admin123';
$senha_hash = password_hash($senha_texto, PASSWORD_DEFAULT);

// Adicionamos a coluna 'tipo' e o valor 'admin'
$sql = "INSERT INTO administradores (usuario, senha, tipo) VALUES (:usuario, :senha, 'admin')";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario' => $usuario, ':senha' => $senha_hash]);
    echo "<h1>Administrador 'master' criado com sucesso!</h1>";
    echo "<p><b>Usuário:</b> " . htmlspecialchars($usuario) . " | <b>Tipo:</b> admin</p>";
    echo "<p style='color:red; font-weight: bold;'>AVISO: Apague o arquivo criar_admin.php do seu projeto agora por segurança!</p>";
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "<h1>Erro</h1><p>O usuário '<b>" . htmlspecialchars($usuario) . "</b>' já existe.</p>";
    } else {
        echo "<h1>Erro ao criar administrador</h1><p>" . $e->getMessage() . "</p>";
    }
}
?>