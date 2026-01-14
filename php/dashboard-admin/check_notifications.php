<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'admin')) {
    echo json_encode(['success' => false]);
    exit();
}

// Contar PQRs pendientes (Nuevas)
$sql_count = "SELECT COUNT(*) as count FROM pqr WHERE estado = 'Pendiente'";
$res_count = mysqli_query($conn, $sql_count);
$count = mysqli_fetch_assoc($res_count)['count'];

// Obtener las últimas 5 PQRs pendientes para el dropdown
$sql_latest = "SELECT pqr.*, usuarios.nombre, usuarios.apellido, usuarios.imagen, usuarios.email 
               FROM pqr 
               JOIN usuarios ON pqr.usuario_id = usuarios.id 
               WHERE pqr.estado = 'Pendiente' 
               ORDER BY pqr.fecha_creacion DESC 
               LIMIT 5";
$res_latest = mysqli_query($conn, $sql_latest);

$notifications = [];
while ($row = mysqli_fetch_assoc($res_latest)) {
    $notifications[] = $row;
}

echo json_encode([
    'success' => true,
    'count' => $count,
    'notifications' => $notifications
]);
?>