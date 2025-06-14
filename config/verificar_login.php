<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    // O caminho deve ser absoluto a partir da raiz do site para evitar problemas com subpastas.
    // Ajuste '/farmacia_pague_mais/' se o nome da sua pasta for diferente.
    header('Location: /farmacia_pague_mais/login.php');
    exit();
}
?>