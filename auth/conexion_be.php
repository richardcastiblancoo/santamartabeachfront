<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "santamarta_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // echo "Base de datos creada exitosamente o ya existe";
} else {
    echo "Error creando base de datos: " . $conn->error;
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear tabla de usuarios si no existe
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol VARCHAR(20) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creando tabla: " . $conn->error;
}

// Verificar si existe el usuario admin por defecto
$usuario_admin = "admin";
$email_admin = "admin@santamarta.com";
$check_admin = "SELECT * FROM usuarios WHERE usuario = '$usuario_admin' OR email = '$email_admin'";
$result = $conn->query($check_admin);

if ($result->num_rows == 0) {
    // Crear usuario admin por defecto
    $password_admin = password_hash("123456", PASSWORD_DEFAULT);
    $sql_admin = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, rol)
    VALUES ('Admin', 'Sistema', '$usuario_admin', '$email_admin', '$password_admin', 'Admin')";

    if ($conn->query($sql_admin) !== TRUE) {
        echo "Error creando usuario admin: " . $conn->error;
    }
} else {
    // Si el admin existe pero no tiene usuario (caso migración), actualizarlo
    $row = $result->fetch_assoc();
    if (empty($row['usuario'])) {
        $id_admin = $row['id'];
        $conn->query("UPDATE usuarios SET usuario = 'admin' WHERE id = $id_admin");
    }
}
?>
