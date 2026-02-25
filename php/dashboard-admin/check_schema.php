<?php
include __DIR__ . '/../../auth/conexion_be.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("DESCRIBE apartamentos");
if ($result) {
    while($row = $result->fetch_assoc()) {
        print_r($row);
    }
} else {
    echo "Error describing table: " . $conn->error;
}
?>