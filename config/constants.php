<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Configuración básica
define('SITE_NAME', 'Sistema CRUD');
define('ROLE_ADMIN', 'admin');
define('ROLE_USER', 'usuario');

// Función para verificar login
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }
}

// Función para verificar admin
function checkAdmin() {
    checkLogin();
    if ($_SESSION['user_role'] != ROLE_ADMIN) {
        header('Location: index.php');
        exit();
    }
}
?>