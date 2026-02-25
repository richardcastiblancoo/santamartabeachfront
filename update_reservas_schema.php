<?php
include __DIR__ . '/auth/conexion_be.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add identificacion
try {
    $conn->query("ALTER TABLE reservas ADD COLUMN identificacion VARCHAR(50) DEFAULT NULL");
    echo "Column 'identificacion' added or already exists\n";
} catch (Exception $e) {
    echo "Error adding 'identificacion': " . $e->getMessage() . "\n";
}

// Add banco_detalle
try {
    $conn->query("ALTER TABLE reservas ADD COLUMN banco_detalle VARCHAR(100) DEFAULT NULL");
    echo "Column 'banco_detalle' added or already exists\n";
} catch (Exception $e) {
    echo "Error adding 'banco_detalle': " . $e->getMessage() . "\n";
}

$conn->close();
?>