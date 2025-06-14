<?php require_once '../config/verificar_login.php'; ?>
<?php if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php?error=acesso_negado'); exit(); } ?>
<?php
require_once '../config/conexao.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}
header("Location: index.php");
exit;
?>