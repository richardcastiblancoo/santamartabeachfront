<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'admin')) {
    echo json_encode([]);
    exit();
}

if (!isset($_GET['pqr_id'])) {
    echo json_encode([]);
    exit();
}

$pqr_id = mysqli_real_escape_string($conn, $_GET['pqr_id']);

$sql = "SELECT r.*, u.nombre, u.apellido, u.imagen 
        FROM respuestas_pqr r 
        LEFT JOIN usuarios u ON r.admin_id = u.id 
        WHERE r.pqr_id = '$pqr_id' 
        ORDER BY r.fecha_respuesta ASC";

$result = mysqli_query($conn, $sql);
$respuestas = [];

while($row = mysqli_fetch_assoc($result)) {
    $respuestas[] = $row;
}

echo json_encode($respuestas);
?>