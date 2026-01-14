<?php
include 'C:/xampp/htdocs/auth/conexion_be.php';

// Check if 'tipo' column exists
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM pqr LIKE 'tipo'");

if (mysqli_num_rows($check_col) == 0) {
    // Add 'tipo' column
    $sql = "ALTER TABLE pqr ADD COLUMN tipo VARCHAR(50) NOT NULL DEFAULT 'Petición' AFTER asunto";
    if (mysqli_query($conn, $sql)) {
        echo "Columna 'tipo' agregada exitosamente a la tabla 'pqr'.";
    } else {
        echo "Error al agregar la columna: " . mysqli_error($conn);
    }
} else {
    echo "La columna 'tipo' ya existe.";
}

mysqli_close($conn);
?>