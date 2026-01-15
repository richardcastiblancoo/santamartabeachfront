<?php
include 'auth/conexion_be.php';

// Array de columnas a añadir
$columns = [
    "ADD COLUMN nombre_cliente VARCHAR(100) AFTER apartamento_id",
    "ADD COLUMN apellido_cliente VARCHAR(100) AFTER nombre_cliente",
    "ADD COLUMN email_cliente VARCHAR(100) AFTER apellido_cliente",
    "ADD COLUMN telefono_cliente VARCHAR(50) AFTER email_cliente",
    "ADD COLUMN adultos INT DEFAULT 1 AFTER fecha_fin",
    "ADD COLUMN ninos INT DEFAULT 0 AFTER adultos",
    "ADD COLUMN bebes INT DEFAULT 0 AFTER ninos",
    "ADD COLUMN perro_guia TINYINT(1) DEFAULT 0 AFTER bebes",
    "ADD COLUMN nombres_huespedes TEXT AFTER perro_guia",
    "MODIFY COLUMN usuario_id INT(6) UNSIGNED NULL" // Asegurar que usuario_id pueda ser NULL
];

foreach ($columns as $col) {
    try {
        $sql = "ALTER TABLE reservas $col";
        if ($conn->query($sql) === TRUE) {
            echo "Columna añadida/modificada correctamente: $col<br>";
        } else {
            // Ignorar error si es porque la columna ya existe (Duplicate column name)
            if (strpos($conn->error, 'Duplicate column name') === false) {
                 echo "Error alterando tabla: " . $conn->error . "<br>";
            } else {
                 echo "La columna ya existe: $col<br>";
            }
        }
    } catch (Exception $e) {
        echo "Excepción: " . $e->getMessage() . "<br>";
    }
}

echo "Actualización de esquema completada.";
?>