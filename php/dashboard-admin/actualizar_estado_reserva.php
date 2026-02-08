<?php
session_start();
include '../../auth/conexion_be.php';

// 1. Verificar si es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    // Forzamos el estado a minúsculas para que coincida con el ENUM de la base de datos
    $estado = isset($_POST['estado']) ? strtolower($conn->real_escape_string($_POST['estado'])) : '';

    if ($id > 0 && !empty($estado)) {
        // 2. Ajustar los estados válidos EXACTAMENTE como están en tu tabla SQL
        // Nota: He incluido 'finalizada' asumiendo que harás el ALTER TABLE que te sugerí.
        $estados_validos = ['pendiente', 'confirmada', 'cancelada', 'finalizada'];
        
        if (!in_array($estado, $estados_validos)) {
            echo json_encode(['success' => false, 'message' => 'Estado inválido: ' . $estado]);
            exit;
        }

        $query = "UPDATE reservas SET estado = '$estado' WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => true, 'message' => 'Estado actualizado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error SQL: ' . mysqli_error($conn)]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>