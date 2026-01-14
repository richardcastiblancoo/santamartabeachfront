<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'admin')) {
    echo json_encode(['success' => false, 'message' => 'No autorizado']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $pqr_id = $data['pqr_id'];
    $estado = $data['estado'];
    
    if (empty($pqr_id) || empty($estado)) {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
        exit();
    }

    $sql_update = "UPDATE pqr SET estado = '$estado' WHERE id = '$pqr_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar estado: ' . mysqli_error($conn)]);
    }
    
    mysqli_close($conn);
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>