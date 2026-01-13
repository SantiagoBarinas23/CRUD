<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
    <!-- CSS BASE (siempre se carga) -->
    <link rel="stylesheet" href="css/base.css">
    
    <!-- CSS ESPECÍFICO POR PÁGINA -->
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    
    switch($current_page) {
        case 'login.php':
            echo '<link rel="stylesheet" href="css/login.css">';
            break;
            
        case 'index.php':
            echo '<link rel="stylesheet" href="css/dashboard.css">';
            break;
            
        case 'crear.php':
        case 'editar.php':
            echo '<link rel="stylesheet" href="css/forms.css">';
            break;
            
        case 'ver.php':
            echo '<link rel="stylesheet" href="css/details.css">';
            break;
            
        case 'eliminar.php':
            echo '<link rel="stylesheet" href="css/alerts.css">';
            break;
    }
    ?>
    
    <!-- CSS adicional si existe -->
    <?php if(file_exists('css/' . $current_page)): ?>
        <link rel="stylesheet" href="css/<?php echo $current_page; ?>">
    <?php endif; ?>
    
</head>
<body class="<?php echo $current_page == 'login.php' ? 'login-page' : ''; ?>">
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-users me-2"></i><?php echo SITE_NAME; ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">
                                <i class="fas fa-home"></i> Inicio
                            </a>
                        </li>
                        <?php if($_SESSION['user_role'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="crear.php">
                                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?php echo $_SESSION['user_name']; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">