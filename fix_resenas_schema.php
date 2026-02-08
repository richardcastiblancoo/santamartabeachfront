<?php
include 'auth/conexion_be.php';

echo "Adding missing columns to 'resenas' table...\n";

$queries = [
    "ALTER TABLE resenas ADD COLUMN usuario_id INT(6) UNSIGNED NOT NULL AFTER apartamento_id",
    "ALTER TABLE resenas ADD COLUMN fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
    "ALTER TABLE resenas ADD CONSTRAINT fk_resenas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE",
    "ALTER TABLE resenas ADD CONSTRAINT fk_resenas_apartamento FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE"
];

foreach ($queries as $sql) {
    try {
        if ($conn->query($sql) === TRUE) {
            echo "Success: $sql\n";
        } else {
            echo "Error: " . $conn->error . " | Query: $sql\n";
        }
    } catch (Exception $e) {
        echo "Exception: " . $e->getMessage() . " | Query: $sql\n";
    }
}

$conn->close();
?>
