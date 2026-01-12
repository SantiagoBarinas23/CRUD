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
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/messages.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user me-2"></i>Detalles del Usuario
                    </h4>
                    <div>
                        <a href="index.php" class="btn btn-sm btn-light">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; font-size: 2rem;">
                        <?php echo strtoupper(substr($usuario['nombre'], 0, 1) . substr($usuario['apellido'], 0, 1)); ?>
                    </div>
                    <h4 class="mt-3"><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($usuario['email']); ?></p>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuario['usuario']); ?></p>
                        <p><strong>Rol:</strong> 
                            <span class="badge bg-<?php echo $usuario['rol'] == 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo $usuario['rol']; ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Estado:</strong> 
                            <?php if($usuario['activo']): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php endif; ?>
                        </p>
                        <p><strong>Registro:</strong> <?php echo date('d/m/Y', strtotime($usuario['creado'])); ?></p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="editar.php?id=<?php echo $usuario['id']; ?>" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                    <?php if($_SESSION['user_role'] == 'admin' && $_SESSION['user_id'] != $usuario['id']): ?>
                    <a href="eliminar.php?id=<?php echo $usuario['id']; ?>" 
                       class="btn btn-danger btn-delete">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>