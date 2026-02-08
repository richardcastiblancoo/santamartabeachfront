<?php
include 'auth/conexion_be.php';

echo "Columns in 'resenas' table:\n";
$result = $conn->query("SHOW COLUMNS FROM resenas");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Error: " . $conn->error;
}
?>
