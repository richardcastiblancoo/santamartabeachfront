<?php
include '../../auth/conexion_be.php';

$sql = "DESCRIBE galeria_apartamentos";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . "\n";
    }
} else {
    echo "Error: " . $conn->error;
}
?>
