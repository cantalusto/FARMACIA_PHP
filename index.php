<?php
session_start();

if (isset($_SESSION['admin_id'])) {
    header('Location: menu.php');
} else {
    header('Location: login.php');
}
exit();
?>