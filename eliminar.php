<?php
require_once 'config/constants.php';
require_once 'includes/User.php';

checkAdmin();

$user = new User();
$id = $_GET['id'] ?? 0;

// No permitir eliminarse a sí mismo
if($id == $_SESSION['user_id']) {
    $_SESSION['error'] = 'No puedes eliminar tu propio usuario';
    header('Location: index.php');
    exit();
}

// Confirmar eliminación
if(isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    if($user->delete($id)) {
        $_SESSION['success'] = 'Usuario eliminado exitosamente';
    } else {
        $_SESSION['error'] = 'Error al eliminar el usuario';
    }
    header('Location: index.php');
    exit();
}

// Mostrar confirmación
?>
<?php include 'includes/header.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                </h4>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>¡Atención!</strong> Esta acción no se puede deshacer.
                </div>
                
                <p>¿Estás seguro de que quieres eliminar este usuario?</p>
                
                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </a>
                    <a href="eliminar.php?id=<?php echo $id; ?>&confirm=yes" 
                       class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Sí, Eliminar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>