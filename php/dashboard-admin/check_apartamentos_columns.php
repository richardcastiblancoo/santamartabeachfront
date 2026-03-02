<?php
include '../../auth/conexion_be.php';

$sql = "DESCRIBE apartamentos";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
