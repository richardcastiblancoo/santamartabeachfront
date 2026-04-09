<?php
session_start();
include '../../auth/conexion_be.php';
require_once __DIR__ . '/../reserva-apartamento/reserva_mailer.php';

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

        $stmtReserva = $conn->prepare("
            SELECT r.id, r.estado, r.nombre_cliente, r.apellido_cliente, r.email_cliente, r.telefono,
                   r.fecha_checkin, r.fecha_checkout, r.precio_total, a.titulo AS nombre_apartamento
            FROM reservas r
            LEFT JOIN apartamentos a ON r.apartamento_id = a.id
            WHERE r.id = ?
            LIMIT 1
        ");

        if (!$stmtReserva) {
            echo json_encode(['success' => false, 'message' => 'No se pudo preparar la consulta de la reserva']);
            exit;
        }

        $stmtReserva->bind_param('i', $id);
        $stmtReserva->execute();
        $resultadoReserva = $stmtReserva->get_result();
        $reserva = $resultadoReserva ? $resultadoReserva->fetch_assoc() : null;
        $stmtReserva->close();

        if (!$reserva) {
            echo json_encode(['success' => false, 'message' => 'Reserva no encontrada']);
            exit;
        }

        if ($reserva['estado'] === $estado) {
            echo json_encode(['success' => true, 'message' => 'La reserva ya tenía ese estado']);
            exit;
        }

        $stmtUpdate = $conn->prepare("UPDATE reservas SET estado = ? WHERE id = ?");
        if (!$stmtUpdate) {
            echo json_encode(['success' => false, 'message' => 'No se pudo preparar la actualización']);
            exit;
        }

        $stmtUpdate->bind_param('si', $estado, $id);
        $actualizado = $stmtUpdate->execute();
        $stmtUpdate->close();

        if ($actualizado) {
            $correoEnviado = true;
            if (in_array($estado, ['confirmada', 'cancelada'], true)) {
                $correoEnviado = enviarCorreoEstadoReservaHuesped($reserva, $estado);
                if (!$correoEnviado) {
                    error_log('No se pudo enviar el correo de estado para la reserva #' . $id);
                }
            }

            $mensaje = $correoEnviado
                ? 'Estado actualizado'
                : 'Estado actualizado, pero no se pudo enviar el correo al huésped';

            echo json_encode(['success' => true, 'message' => $mensaje]);
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
