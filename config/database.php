<?php
class Database {
    // CONFIGURACIÓN PARA XAMPP (POR DEFECTO)
    private $host = "localhost";
    private $db_name = "sistema_usuarios";
    private $username = "root";    // Así viene XAMPP
    private $password = "";        // Sin contraseña por defecto
    private $conn;

    public function getConnection() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // Mensaje simple de error
            echo "ERROR DE CONEXIÓN: " . $e->getMessage();
            echo "<br>Verifica que:<br>";
            echo "1. MySQL esté corriendo en XAMPP<br>";
            echo "2. La base de datos 'sistema_usuarios' exista<br>";
            die();
        }
        return $this->conn;
    }
}
?>