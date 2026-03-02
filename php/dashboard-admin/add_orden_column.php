<?php
include '../../auth/conexion_be.php';

$sql = "ALTER TABLE galeria_apartamentos ADD COLUMN orden INT DEFAULT 0";

if ($conn->query($sql) === TRUE) {
    echo "Columna 'orden' agregada exitosamente";
} else {
    echo "Error al agregar columna: " . $conn->error;
}
?>
