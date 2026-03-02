<?php
include '../../auth/conexion_be.php';

$sql = "ALTER TABLE apartamentos MODIFY capacidad VARCHAR(50)";

if ($conn->query($sql) === TRUE) {
    echo "Columna 'capacidad' modificada exitosamente a VARCHAR(50)";
} else {
    echo "Error al modificar columna: " . $conn->error;
}
?>
