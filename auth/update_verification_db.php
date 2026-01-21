<?php
include 'conexion_be.php';

// Intentar añadir las columnas 'token' y 'is_verified'
try {
    // Verificamos si la columna 'token' existe
    $check_token = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'token'");
    if($check_token->num_rows == 0) {
        $conn->query("ALTER TABLE usuarios ADD COLUMN token VARCHAR(255) DEFAULT NULL");
        echo "Columna 'token' agregada.<br>";
    } else {
        echo "La columna 'token' ya existe.<br>";
    }

    // Verificamos si la columna 'is_verified' existe
    $check_verified = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'is_verified'");
    if($check_verified->num_rows == 0) {
        $conn->query("ALTER TABLE usuarios ADD COLUMN is_verified TINYINT(1) DEFAULT 0");
        echo "Columna 'is_verified' agregada.<br>";
    } else {
        echo "La columna 'is_verified' ya existe.<br>";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>