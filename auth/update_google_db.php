<?php
include 'conexion_be.php';

// Intentar añadir la columna 'google_id' si la tabla ya existía sin ella
try {
    // Verificamos si la columna existe
    $check = $conn->query("SHOW COLUMNS FROM usuarios LIKE 'google_id'");
    if($check->num_rows == 0) {
        $conn->query("ALTER TABLE usuarios ADD COLUMN google_id VARCHAR(255) DEFAULT NULL AFTER id");
        echo "Columna google_id agregada exitosamente.";
    } else {
        echo "La columna google_id ya existe.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
