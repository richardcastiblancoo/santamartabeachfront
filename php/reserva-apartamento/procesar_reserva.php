<?php
session_start();
include '../../auth/conexion_be.php';

// --- NUEVA ADICIÓN PARA EL EMAIL ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Sube un nivel (sale de reserva-apartamento) y entra a PHPMailer
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
// -----------------------------------

// 1. Validar método de envío
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// 2. Recibir y limpiar datos básicos
$id_apartamento = intval($_POST['id_apartamento']);
$checkin         = $_POST['checkin'];
$checkout        = $_POST['checkout'];
$adults          = intval($_POST['adults']);
$children        = intval($_POST['children']);
$infants         = intval($_POST['infants']);
$guideDog        = intval($_POST['guideDog']);
$total_price     = floatval($_POST['total_price']);
$isEmbed         = isset($_POST['embed']) && $_POST['embed'] === '1';

$nombre          = trim($_POST['nombre'] ?? '');
$apellido        = trim($_POST['apellido'] ?? '');
$email           = trim($_POST['email'] ?? '');
$telefono        = trim($_POST['telefono'] ?? '');
$cuenta_banco    = trim($_POST['cuenta_devolucion'] ?? '');

// 3. Procesar Array de Huéspedes (Convertir lista a texto)
$lista_huespedes = isset($_POST['huespedes']) ? $_POST['huespedes'] : [];
$huespedes_nombres = implode(", ", array_map('trim', $lista_huespedes));

// 4. Manejo de la subida del Documento (ID/Pasaporte)
$documento_ruta = "";
if (isset($_FILES['documento_id']) && $_FILES['documento_id']['error'] === UPLOAD_ERR_OK) {
    $dir_subida = "../../uploads/documentos/";

    if (!file_exists($dir_subida)) {
        mkdir($dir_subida, 0777, true);
    }

    $extension = pathinfo($_FILES['documento_id']['name'], PATHINFO_EXTENSION);
    $nombre_archivo = "doc_" . time() . "_" . uniqid() . "." . $extension;
    $ruta_final = $dir_subida . $nombre_archivo;

    if (move_uploaded_file($_FILES['documento_id']['tmp_name'], $ruta_final)) {
        $documento_ruta = $nombre_archivo;
    }
}

// 5. Validación de fechas
$checkin_dt = DateTime::createFromFormat('Y-m-d', $checkin);
$checkout_dt = DateTime::createFromFormat('Y-m-d', $checkout);

if (!$checkin_dt || !$checkout_dt || $checkout_dt <= $checkin_dt) {
    header('Location: /?error=fechas_invalidas');
    exit;
}

// 6. Validar disponibilidad real (Evitar Overbooking)
$overlapStmt = $conn->prepare("SELECT COUNT(*) FROM reservas WHERE apartamento_id = ? AND estado <> 'cancelada' AND fecha_checkin < ? AND fecha_checkout > ?");
$overlapStmt->bind_param('iss', $id_apartamento, $checkout, $checkin);
$overlapStmt->execute();
$overlapStmt->bind_result($overlapCount);
$overlapStmt->fetch();
$overlapStmt->close();

if ($overlapCount > 0) {
    $embedParam = $isEmbed ? '&embed=1' : '';
    header("Location: reservar.php?id=$id_apartamento&error=fechas$embedParam");
    exit;
}

// 7. Insertar en la Base de Datos
$estado = 'pendiente';

$insertSql = "INSERT INTO reservas (
        apartamento_id, 
        nombre_cliente, 
        apellido_cliente, 
        email_cliente, 
        telefono, 
        huespedes_nombres, 
        documento_ruta, 
        cuenta_devolucion, 
        fecha_checkin, 
        fecha_checkout, 
        adultos, 
        ninos, 
        bebes, 
        perro_guia, 
        precio_total, 
        estado
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertStmt = $conn->prepare($insertSql);

if ($insertStmt) {
    $insertStmt->bind_param(
        'isssssssssiiiids',
        $id_apartamento,
        $nombre,
        $apellido,
        $email,
        $telefono,
        $huespedes_nombres,
        $documento_ruta,
        $cuenta_banco,
        $checkin,
        $checkout,
        $adults,
        $children,
        $infants,
        $guideDog,
        $total_price,
        $estado
    );

    if ($insertStmt->execute()) {
        $id_reserva = $conn->insert_id;

        // --- BLOQUE DE ENVÍO DE EMAIL (AÑADIDO) ---
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'richard_12345@santamartabeachfront.com'; // USA TU EMAIL REAL AQUÍ
            $mail->Password   = 'Richardcastiblanco_1234567890';           // USA TU CONTRASEÑA REAL AQUÍ
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('richard_12345@santamartabeachfront.com', 'Santa Marta Beachfront');
            $mail->addAddress($email, "$nombre $apellido"); // Al cliente
            $mail->addAddress('richardcastiblanco4@gmail.com'); // Copia para ti

            // Adjuntamos la cédula que se acaba de subir
            if (!empty($documento_ruta)) {
                $mail->addAttachment($dir_subida . $documento_ruta, "ID_$apellido.jpg");
            }

            $mail->isHTML(true);
            $mail->Subject = "Solicitud de Reserva #$id_reserva recibida";
            $mail->Body    = "<h2>¡Hola $nombre!</h2>
                              <p>Hemos recibido tu solicitud para el apartamento #$id_apartamento.</p>
                              <p><strong>Detalles:</strong><br>
                              Entrada: $checkin<br>
                              Salida: $checkout<br>
                              Total: $" . number_format($total_price, 0, ',', '.') . "</p>
                              <p>Revisaremos la información y nos contactaremos contigo pronto.</p>";

            $mail->send();
        } catch (Exception $e) {
            // Si el correo falla, la reserva ya está guardada, así que solo registramos el error
            error_log("Error enviando correo: " . $mail->ErrorInfo);
        }
        // --- FIN BLOQUE DE EMAIL ---

        $embedParam = $isEmbed ? '&embed=1' : '';
        header("Location: reserva_exitosa.php?id=$id_reserva$embedParam");
        exit;
    } else {
        die("Error al guardar: " . $insertStmt->error);
    }
} else {
    die("Error en SQL: " . $conn->error);
}

$conn->close();
