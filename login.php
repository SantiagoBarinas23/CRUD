<?php
require_once 'config/constants.php';
require_once 'includes/User.php';

// Si ya está logueado, redirigir al index
if(isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user = new User();
$error = '';

// Procesar formulario
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['usuario'] ?? '';
    $password = $_POST['clave'] ?? '';
    
    if(empty($username) || empty($password)) {
        $error = 'Usuario y contraseña son requeridos';
    } else {
        $userData = $user->login($username, $password);
        
        if($userData) {
            // Guardar datos en sesión
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_name'] = $userData['nombre'] . ' ' . $userData['apellido'];
            $_SESSION['user_email'] = $userData['email'];
            $_SESSION['user_role'] = $userData['rol'];
            
            $_SESSION['success'] = '¡Bienvenido ' . $_SESSION['user_name'] . '!';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Usuario o contraseña incorrectos';
        }
    }
}
?>
<?php include 'includes/header.php'; ?>

<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario o Email</label>
                        <input type="text" class="form-control" id="usuario" name="usuario" 
                               placeholder="admin" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="clave" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="clave" name="clave" 
                               placeholder="admin123" required>
                        <small class="text-muted">Prueba con: admin / admin123</small>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Ingresar
                        </button>
                    </div>
                </form>
                
                <div class="mt-3 text-center">
                    <small class="text-muted">Sistema de Gestión de Usuarios</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>