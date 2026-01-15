<?php
session_start();
include '../../auth/conexion_be.php';

// Verificar si es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $estado = isset($_POST['estado']) ? $conn->real_escape_string($_POST['estado']) : '';

    if ($id > 0 && !empty($estado)) {
        // Validar que el estado sea uno de los permitidos
        $estados_validos = ['Pendiente', 'Confirmada', 'Completada', 'Cancelada'];
        if (!in_array($estado, $estados_validos)) {
            echo json_encode(['success' => false, 'message' => 'Estado inválido']);
            exit;
        }

        $query = "UPDATE reservas SET estado = '$estado' WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>