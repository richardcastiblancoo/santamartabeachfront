<?php
include __DIR__ . '/../../auth/conexion_be.php';

// Add cama
$sql1 = "ALTER TABLE apartamentos ADD COLUMN cama INT(3) DEFAULT 0";
if ($conn->query($sql1) === TRUE) {
    echo "Column 'cama' added successfully\n";
} else {
    echo "Error adding column 'cama': " . $conn->error . "\n";
}

// Add pdf
$sql2 = "ALTER TABLE apartamentos ADD COLUMN pdf VARCHAR(255) DEFAULT NULL";
if ($conn->query($sql2) === TRUE) {
    echo "Column 'pdf' added successfully\n";
} else {
    echo "Error adding column 'pdf': " . $conn->error . "\n";
}

$conn->close();
?>