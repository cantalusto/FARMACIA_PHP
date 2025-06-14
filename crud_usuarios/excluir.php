<?php
require_once '../config/verificar_login.php';
if ($_SESSION['admin_tipo'] !== 'admin') { header('Location: ../menu.php'); exit(); }
require_once '../config/conexao.php';
$id = $_GET['id'] ?? null;
if ($id && $id != $_SESSION['admin_id']) {
    $sql = "DELETE FROM administradores WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}
header("Location: index.php");
exit;
?>