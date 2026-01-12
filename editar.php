<?php
require_once 'config/constants.php';
require_once 'includes/User.php';

checkLogin();

$user = new User();
$id = $_GET['id'] ?? 0;

// Obtener datos del usuario
$usuario = $user->readOne($id);
if(!$usuario) {
    $_SESSION['error'] = 'Usuario no encontrado';
    header('Location: index.php');
    exit();
}

// Verificar permisos
if($_SESSION['user_role'] != 'admin' && $_SESSION['user_id'] != $id) {
    $_SESSION['error'] = 'No tienes permisos para editar este usuario';
    header('Location: index.php');
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user->id = $id;
    $user->nombre = $_POST['nombre'];
    $user->apellido = $_POST['apellido'];
    $user->email = $_POST['email'];
    $user->usuario = $_POST['usuario'];
    $user->rol = $_POST['rol'];
    $user->activo = isset($_POST['activo']) ? 1 : 0;
    
    if($user->update()) {
        $_SESSION['success'] = 'Usuario actualizado exitosamente';
        header('Location: index.php');
        exit();
    } else {
        $error = 'Error al actualizar el usuario';
    }
}
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/messages.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-edit me-2"></i>Editar Usuario
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
                            <input type="text" name="nombre" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido *</label>
                            <input type="text" name="apellido" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Usuario *</label>
                        <input type="text" name="usuario" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select name="rol" class="form-control" <?php echo ($_SESSION['user_role'] != 'admin') ? 'disabled' : ''; ?>>
                            <option value="usuario" <?php echo $usuario['rol'] == 'usuario' ? 'selected' : ''; ?>>Usuario</option>
                            <option value="admin" <?php echo $usuario['rol'] == 'admin' ? 'selected' : ''; ?>>Administrador</option>
                        </select>
                        <?php if($_SESSION['user_role'] != 'admin'): ?>
                            <input type="hidden" name="rol" value="<?php echo $usuario['rol']; ?>">
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activo" value="1" id="activo"
                                   <?php echo $usuario['activo'] ? 'checked' : ''; ?>
                                   <?php echo ($_SESSION['user_role'] != 'admin') ? 'disabled' : ''; ?>>
                            <label class="form-check-label" for="activo">
                                Usuario Activo
                            </label>
                        </div>
                        <?php if($_SESSION['user_role'] != 'admin'): ?>
                            <input type="hidden" name="activo" value="<?php echo $usuario['activo']; ?>">
                        <?php endif; ?>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="index.php" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>