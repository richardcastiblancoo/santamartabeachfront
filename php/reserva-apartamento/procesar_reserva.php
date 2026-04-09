<?php

/**
 * Procesamiento de Reserva - Santamartabeachfront
 * Versión Completa: Múltiples documentos, Perros guía, Pagos y Correos Duales.
 */

session_start();
include '../../auth/conexion_be.php';

require_once __DIR__ . '/reserva_mailer.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// 1. Recibir y limpiar datos (RECUPERADOS TODOS LOS CAMPOS ORIGINALES)
$id_apartamento = intval($_POST['id_apartamento']);
$checkin         = $_POST['checkin'];
$checkout        = $_POST['checkout'];
$adults          = intval($_POST['adults']);
$children        = intval($_POST['children']);
$infants         = intval($_POST['infants']);
$guideDog        = intval($_POST['guideDog']); // Recuperado
$total_price     = floatval($_POST['total_price']);
$metodo_pago     = $_POST['metodo_pago'] ?? 'No especificado';
$isEmbed         = isset($_POST['embed']) && $_POST['embed'] === '1';

$nombre          = trim($_POST['nombre'] ?? '');
$apellido        = trim($_POST['apellido'] ?? ''); // Corregido el "apellido!" anterior
$email           = trim($_POST['email'] ?? '');
$telefono        = trim($_POST['telefono'] ?? '');
$identificacion  = trim($_POST['identificacion'] ?? ''); // Nuevo campo
$cuenta_banco    = trim($_POST['cuenta_devolucion'] ?? '');
$banco_detalle   = trim($_POST['banco_detalle'] ?? ''); // Nuevo campo

// 2. Procesar Lista de Huéspedes
$lista_huespedes = isset($_POST['huespedes']) ? $_POST['huespedes'] : [];
$huespedes_nombres = implode(", ", array_map('trim', $lista_huespedes));

// 3. Manejo de Múltiples Documentos (Fotos o PDFs)
$documentos_subidos = [];
$dir_subida = "../../uploads/documentos/";

if (!empty($_FILES['documento_id']['name'][0])) {
    if (!file_exists($dir_subida)) {
        mkdir($dir_subida, 0777, true);
    }

    foreach ($_FILES['documento_id']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['documento_id']['error'][$key] === UPLOAD_ERR_OK) {
            $extension = pathinfo($_FILES['documento_id']['name'][$key], PATHINFO_EXTENSION);
            $nuevo_nombre = "doc_" . time() . "_" . uniqid() . "." . $extension;
            if (move_uploaded_file($tmp_name, $dir_subida . $nuevo_nombre)) {
                $documentos_subidos[] = $nuevo_nombre;
            }
        }
    }
}
$documento_ruta_db = implode(",", $documentos_subidos);

// 4. Validación de Disponibilidad (Overlap) y Obtención del nombre del apartamento
$overlapStmt = $conn->prepare("SELECT COUNT(*) FROM reservas WHERE apartamento_id = ? AND estado <> 'cancelada' AND fecha_checkin < ? AND fecha_checkout > ?");
$overlapStmt->bind_param('iss', $id_apartamento, $checkout, $checkin);
$overlapStmt->execute();
$overlapStmt->bind_result($overlapCount);
$overlapStmt->fetch();
$overlapStmt->close();

if ($overlapCount > 0) {
    if ($isEmbed) {
        header("Location: ../dashboard-huesped/vista_reserva_express.php?id=$id_apartamento&error=fechas");
    } else {
        header("Location: reservar.php?id=$id_apartamento&error=fechas");
    }
    exit;
}

// Obtener nombre del apartamento
$stmtApto = $conn->prepare("SELECT titulo FROM apartamentos WHERE id = ?");
$stmtApto->bind_param("i", $id_apartamento);
$stmtApto->execute();
$resApto = $stmtApto->get_result();
$rowApto = $resApto->fetch_assoc();
$nombre_apartamento = $rowApto ? $rowApto['titulo'] : 'Apartamento';
$stmtApto->close();

// 5. Insertar en BD (19 parámetros)
$estado = 'pendiente';
$insertSql = "INSERT INTO reservas (apartamento_id, nombre_cliente, apellido_cliente, email_cliente, telefono, identificacion, huespedes_nombres, documento_ruta, cuenta_devolucion, banco_detalle, fecha_checkin, fecha_checkout, adultos, ninos, bebes, perro_guia, precio_total, estado, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertStmt = $conn->prepare($insertSql);

if ($insertStmt) {
    $insertStmt->bind_param(
        'isssssssssssiiiidss',
        $id_apartamento,
        $nombre,
        $apellido,
        $email,
        $telefono,
        $identificacion,
        $huespedes_nombres,
        $documento_ruta_db,
        $cuenta_banco,
        $banco_detalle,
        $checkin,
        $checkout,
        $adults,
        $children,
        $infants,
        $guideDog,
        $total_price,
        $estado,
        $metodo_pago
    );

    if ($insertStmt->execute()) {
        $id_reserva = $conn->insert_id;

        $datosReservaCorreo = [
            'id_reserva' => $id_reserva,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'telefono' => $telefono,
            'identificacion' => $identificacion,
            'huespedes_nombres' => $huespedes_nombres,
            'cuenta_banco' => $cuenta_banco,
            'banco_detalle' => $banco_detalle,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'guideDog' => $guideDog,
            'total_price' => $total_price,
            'metodo_pago' => $metodo_pago,
            'nombre_apartamento' => $nombre_apartamento,
        ];

        $rutasAdjuntas = array_map(
            static fn($archivo) => $dir_subida . $archivo,
            $documentos_subidos
        );

        if (!enviarCorreoNuevaReservaHuesped($datosReservaCorreo)) {
            error_log('No se pudo enviar el correo inicial al huésped de la reserva #' . $id_reserva);
        }

        if (!enviarCorreoNuevaReservaAdmin($datosReservaCorreo, $rutasAdjuntas)) {
            error_log('No se pudo enviar el correo al administrador de la reserva #' . $id_reserva);
        }

        $embedParam = $isEmbed ? '&embed=1' : '';
        header("Location: reserva_exitosa.php?id=$id_reserva$embedParam");
        exit;
    }
}
$conn->close();
