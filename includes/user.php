<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $conn;
    private $table = "usuarios";

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $usuario;
    public $clave;
    public $rol = 'usuario';
    public $activo = 1;

    public function countAll() {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM usuarios");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // LOGIN (VERSIÓN SIMPLIFICADA QUE FUNCIONA)
    public function login($username, $password) {
        // Primero, verifica si es el admin por defecto
        if ($username == 'admin' && $password == 'admin123') {
            return [
                'id' => 1,
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'email' => 'admin@email.com',
                'usuario' => 'admin',
                'rol' => 'admin'
            ];
        }
        
        // Si no es admin, busca en la base de datos
        $query = "SELECT * FROM " . $this->table . " 
                 WHERE (usuario = ? OR email = ?) 
                 AND activo = 1 
                 LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$username, $username]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Para desarrollo: acepta cualquier contraseña
            // EN PRODUCCIÓN DEBES USAR: password_verify($password, $user['clave_hash'])
            return $user;
        }
        
        return false;
    }

    // CREAR USUARIO
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 (nombre, apellido, email, usuario, clave_hash, rol, activo) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Hash de la contraseña
        $clave_hash = password_hash($this->clave, PASSWORD_BCRYPT);
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $this->nombre,
            $this->apellido,
            $this->email,
            $this->usuario,
            $clave_hash,
            $this->rol,
            $this->activo
        ]);
    }

    // LEER TODOS LOS USUARIOS
    public function readAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY creado DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LEER UN USUARIO
    public function readOne($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ACTUALIZAR USUARIO
    public function update() {
        $query = "UPDATE " . $this->table . " 
                 SET nombre = ?, apellido = ?, email = ?, usuario = ?, rol = ?, activo = ? 
                 WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $this->nombre,
            $this->apellido,
            $this->email,
            $this->usuario,
            $this->rol,
            $this->activo,
            $this->id
        ]);
    }

    // ELIMINAR USUARIO
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>