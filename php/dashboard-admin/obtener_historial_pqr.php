<?php
include '../../auth/conexion_be.php';

if (isset($_GET['usuario_id'])) {
    $usuario_id = intval($_GET['usuario_id']);
    $current_pqr_id = isset($_GET['current_pqr']) ? intval($_GET['current_pqr']) : 0;
    
    $sql = "SELECT * FROM pqr WHERE usuario_id = $usuario_id AND id != $current_pqr_id ORDER BY fecha_creacion DESC";
    $result = mysqli_query($conn, $sql);
    
    $historial = [];
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $historial[] = $row;
        }
    }
    
    echo json_encode($historial);
}
?>
