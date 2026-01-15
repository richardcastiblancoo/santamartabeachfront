<?php
include '../../auth/conexion_be.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM apartamentos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Apartamento no encontrado']);
    }
    $stmt->close();
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
$conn->close();
?>