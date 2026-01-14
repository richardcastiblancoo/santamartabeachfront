<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false]);
    exit();
}

$usuario_id = $_SESSION['id'];

// Contar Respuestas Nuevas (Podrías tener una columna 'leido' en respuestas_pqr o similar)
// Por simplicidad, vamos a buscar respuestas recientes que NO sean del usuario actual (asumiendo que admin responde)
// Y que pertenezcan a PQRs del usuario
// Una mejor aproximación si no tienes campo 'leido' es verificar por fecha reciente en la sesión actual, 
// o simplemente mostrar las últimas respuestas de los admins.

// Para este caso práctico, obtenemos las últimas respuestas de los administradores a las PQR del usuario
// Limitamos a las últimas 5
$sql = "SELECT r.*, u.nombre, u.apellido, u.imagen, p.asunto 
        FROM respuestas_pqr r 
        JOIN pqr p ON r.pqr_id = p.id 
        JOIN usuarios u ON r.admin_id = u.id 
        WHERE p.usuario_id = '$usuario_id' 
        AND r.admin_id != '$usuario_id' -- Asegurar que no sea respuesta propia si el usuario pudiera responder (futuro)
        ORDER BY r.fecha_respuesta DESC 
        LIMIT 5";

$result = mysqli_query($conn, $sql);

$notifications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}

echo json_encode([
    'success' => true,
    'count' => count($notifications), // Por ahora count total de recientes, idealmente filtrar por no leídas
    'notifications' => $notifications
]);
?>