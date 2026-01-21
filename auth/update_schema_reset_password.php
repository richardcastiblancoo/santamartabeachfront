<?php
require_once 'conexion_be.php';

// Add columns for password reset if they don't exist
$sql = "SHOW COLUMNS FROM usuarios LIKE 'reset_token_hash'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    $sql = "ALTER TABLE usuarios 
            ADD COLUMN reset_token_hash VARCHAR(64) NULL DEFAULT NULL AFTER rol,
            ADD COLUMN reset_token_expires_at DATETIME NULL DEFAULT NULL AFTER reset_token_hash";
    
    if ($conn->query($sql) === TRUE) {
        echo "Columnas para restablecimiento de contraseña agregadas exitosamente.";
    } else {
        echo "Error agregando columnas: " . $conn->error;
    }
} else {
    echo "Las columnas ya existen.";
}

$conn->close();
?>