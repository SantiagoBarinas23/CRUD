<?php
require_once 'config/constants.php';
require_once 'includes/User.php';

// Verificar que el usuario esté logueado
checkLogin();

$user = new User();
$users = $user->readAll();
?>
<?php include 'includes/header.php'; ?>
<?php include 'includes/messages.php'; ?>

<div class="row mb-4">
    <div class="col-md-6">
        <h2><i class="fas fa-users me-2"></i>Lista de Usuarios</h2>
    </div>
    <div class="col-md-6 text-end">
        <?php if($_SESSION['user_role'] == 'admin'): ?>
            <a href="crear.php" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
            </a>
        <?php endif; ?>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $usuario): ?>
                    <tr>
                        <td><?php echo $usuario['id']; ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['usuario']); ?></td>
                        <td>
                            <span class="badge bg-<?php echo $usuario['rol'] == 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo $usuario['rol']; ?>
                            </span>
                        </td>
                        <td>
                            <?php if($usuario['activo']): ?>
                                <span class="badge bg-success">Activo</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactivo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="ver.php?id=<?php echo $usuario['id']; ?>" 
                               class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <?php if($_SESSION['user_role'] == 'admin' || $_SESSION['user_id'] == $usuario['id']): ?>
                            <a href="editar.php?id=<?php echo $usuario['id']; ?>" 
                               class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php endif; ?>
                            
                            <?php if($_SESSION['user_role'] == 'admin' && $_SESSION['user_id'] != $usuario['id']): ?>
                            <a href="eliminar.php?id=<?php echo $usuario['id']; ?>" 
                               class="btn btn-sm btn-danger btn-delete" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>