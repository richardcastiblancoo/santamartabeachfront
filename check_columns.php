<?php
include 'auth/conexion_be.php';
$result = $conn->query("DESCRIBE apartamentos");
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
?>