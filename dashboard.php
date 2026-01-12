<?php
// dashboard.php
require_once 'config/constants.php';
checkAdmin();

require_once 'includes/User.php';

$user = new User();
$total_users = $user->countAll();

// Obtener estadísticas
$query = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN activo = 1 THEN 1 ELSE 0 END) as activos,
            SUM(CASE WHEN rol = 'admin' THEN 1 ELSE 0 END) as admins,
            SUM(CASE WHEN rol = 'moderador' THEN 1 ELSE 0 END) as mods,
            SUM(CASE WHEN rol = 'usuario' THEN 1 ELSE 0 END) as usuarios,
            DATE(creado) as fecha
          FROM usuarios 
          GROUP BY DATE(creado)
          ORDER BY fecha DESC
          LIMIT 7";
?>
<?php include 'includes/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-12">
        <h2>
            <i class="fas fa-chart-bar me-2"></i>Dashboard
        </h2>
        <p class="text-muted">Estadísticas y análisis del sistema</p>
    </div>
</div>

<!-- Tarjetas de estadísticas -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Total Usuarios</h6>
                        <h3 class="mb-0"><?php echo $total_users; ?></h3>
                    </div>
                    <div class="avatar-sm rounded-circle bg-primary d-flex align-items-center justify-content-center">
                        <i class="fas fa-users text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Usuarios Activos</h6>
                        <h3 class="mb-0">
                            <?php 
                            $stmt = $userconn->query("SELECT COUNT(*) as total FROM usuarios WHERE activo = 1");
                            echo $stmt->fetch()['total'];
                            ?>
                        </h3>
                    </div>
                    <div class="avatar-sm rounded-circle bg-success d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-check text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Administradores</h6>
                        <h3 class="mb-0">
                            <?php 
                            $stmt = $userconn->query("SELECT COUNT(*) as total FROM usuarios WHERE rol = 'admin'");
                            echo $stmt->fetch()['total'];
                            ?>
                        </h3>
                    </div>
                    <div class="avatar-sm rounded-circle bg-warning d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-shield text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Registros Hoy</h6>
                        <h3 class="mb-0">
                            <?php 
                            $stmt = $userconn->query("SELECT COUNT(*) as total FROM usuarios WHERE DATE(creado) = CURDATE()");
                            echo $stmt->fetch()['total'];
                            ?>
                        </h3>
                    </div>
                    <div class="avatar-sm rounded-circle bg-info d-flex align-items-center justify-content-center">
                        <i class="fas fa-calendar-day text-white fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos y más información -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>Registros por Día (Últimos 7 días)
                </h5>
            </div>
            <div class="card-body">
                <?php
                $stmt = $userconn->query($query);
                $registros = $stmt->fetchAll();
                ?>
                
                <?php if(count($registros) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Total Registros</th>
                                    <th>Activos</th>
                                    <th>Administradores</th>
                                    <th>Moderadores</th>
                                    <th>Usuarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($registros as $registro): ?>
                                <tr>
                                    <td><?php echo date('d/m/Y', strtotime($registro['fecha'])); ?></td>
                                    <td><?php echo $registro['total']; ?></td>
                                    <td>
                                        <span class="badge bg-success"><?php echo $registro['activos']; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger"><?php echo $registro['admins']; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning"><?php echo $registro['mods']; ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo $registro['usuarios']; ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No hay datos suficientes para mostrar</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>Acciones Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="crear.php" class="btn btn-primary">
                        <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                    </a>
                    <a href="index.php" class="btn btn-outline-primary">
                        <i class="fas fa-list me-2"></i>Ver Todos los Usuarios
                    </a>
                    <a href="#" class="btn btn-outline-secondary">
                        <i class="fas fa-file-export me-2"></i>Exportar Datos
                    </a>
                </div>
                
                <hr>
                
                <h6 class="mb-3">
                    <i class="fas fa-info-circle me-2"></i>Información del Sistema
                </h6>
                <div class="list-group">
                    <div class="list-group-item">
                        <small class="text-muted">Versión del Sistema</small><br>
                        <strong>1.0.0</strong>
                    </div>
                    <div class="list-group-item">
                        <small class="text-muted">Última Actualización</small><br>
                        <strong><?php echo date('d/m/Y'); ?></strong>
                    </div>
                    <div class="list-group-item">
                        <small class="text-muted">Sesión Activa</small><br>
                        <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>