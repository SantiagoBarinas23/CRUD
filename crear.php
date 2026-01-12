<?php
require_once 'config/constants.php';
require_once 'includes/User.php';

// Solo administradores pueden crear usuarios
checkAdmin();

$user = new User();
$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->nombre = $_POST['nombre'];
    $user->apellido = $_POST['apellido'];
    $user->email = $_POST['email'];
    $user->usuario = $_POST['usuario'];
    $user->clave = $_POST['clave'];
    $user->rol = $_POST['rol'];
    $user->activo = isset($_POST['activo']) ? 1 : 0;
    
    if($user->create()) {
        $_SESSION['success'] = 'Usuario creado exitosamente';
        header('Location: index.php');
        exit();
    } else {
        $error = 'Error al crear el usuario';
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/messages.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-plus me-2"></i>Crear Nuevo Usuario
                </h4>
            </div>
            <div class="card-body">
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre *</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="apellido" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Usuario *</label>
                        <input type="text" name="usuario" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Contraseña *</label>
                        <input type="password" name="clave" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-control">
                            <option value="usuario">Usuario</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo" checked>
                            <label class="form-check-label" for="activo">
                                Usuario Activo
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>