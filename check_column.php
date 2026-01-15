<?php
include 'auth/conexion_be.php';

$result = $conn->query("SHOW COLUMNS FROM apartamentos LIKE 'servicios'");
if ($result->num_rows == 0) {
    echo "Columna no existe. Creando...";
    $conn->query("ALTER TABLE apartamentos ADD COLUMN servicios TEXT DEFAULT NULL");
    echo "Creada.";
} else {
    echo "Columna ya existe.";
}
?>