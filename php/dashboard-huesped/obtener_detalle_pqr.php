<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['error' => 'No autorizado']);
    exit();
}

if (isset($_GET['id'])) {
    $pqr_id = intval($_GET['id']);
    $usuario_id = $_SESSION['id'];

    // Verificar que la PQR pertenece al usuario
    $sql_pqr = "SELECT * FROM pqr WHERE id = $pqr_id AND usuario_id = $usuario_id";
    $result_pqr = mysqli_query($conn, $sql_pqr);

    if (mysqli_num_rows($result_pqr) > 0) {
        $pqr = mysqli_fetch_assoc($result_pqr);
        
        // Obtener respuestas
        $sql_respuestas = "SELECT r.*, u.nombre, u.apellido, u.imagen 
                           FROM respuestas_pqr r 
                           JOIN usuarios u ON r.admin_id = u.id 
                           WHERE r.pqr_id = $pqr_id 
                           ORDER BY r.fecha_respuesta ASC";
        $result_respuestas = mysqli_query($conn, $sql_respuestas);
        
        $respuestas = [];
        while ($row = mysqli_fetch_assoc($result_respuestas)) {
            $respuestas[] = $row;
        }

        echo json_encode([
            'pqr' => $pqr,
            'respuestas' => $respuestas
        ]);
    } else {
        echo json_encode(['error' => 'PQR no encontrada o acceso denegado']);
    }
} else {
    echo json_encode(['error' => 'ID no proporcionado']);
}
?>