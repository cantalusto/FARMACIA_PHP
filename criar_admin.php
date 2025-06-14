<?php
require_once 'config/conexao.php';

$usuario = 'admin';
$senha_texto = 'admin123';
$senha_hash = password_hash($senha_texto, PASSWORD_DEFAULT);

$sql = "INSERT INTO administradores (usuario, senha) VALUES (:usuario, :senha)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':usuario' => $usuario, ':senha' => $senha_hash]);

    echo "Administrador criado com sucesso!<br>";
    echo "<b>Usuário:</b> " . htmlspecialchars($usuario) . "<br>";
    echo "<b>Senha:</b> " . htmlspecialchars($senha_texto) . "<br>";
    echo "<p style='color:red;'>AVISO: Apague o arquivo criar_admin.php do seu projeto agora!</p>";

} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        echo "Erro: O usuário '<b>" . htmlspecialchars($usuario) . "</b>' já existe.";
    } else {
        echo "Erro ao criar administrador: " . $e->getMessage();
    }
}
?>