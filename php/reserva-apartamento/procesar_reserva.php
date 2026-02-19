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
$dir_subida = "../../uploads/documentos/"; 
if (isset($_FILES['documento_id']) && $_FILES['documento_id']['error'] === UPLOAD_ERR_OK) {
    
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

        // --- BLOQUE DE ENVÍO DE EMAIL ACTUALIZADO ---
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'richard_12345@santamartabeachfront.com'; 
            $mail->Password   = 'Richardcastiblanco_1234567890';           
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('richard_12345@santamartabeachfront.com', 'Santa Marta Beachfront');
            $mail->addAddress($email, "$nombre $apellido"); 
            $mail->addAddress('richardcastiblanco4@gmail.com'); 

            if (!empty($documento_ruta)) {
                $mail->addAttachment($dir_subida . $documento_ruta, "ID_$apellido.jpg");
            }

            $mail->isHTML(true);
            $mail->Subject = "Solicitud de Reserva #$id_reserva recibida - Santa Marta Beachfront";
            
            // Cuerpo del correo estilizado con toda la información solicitada
            $mail->Body    = "
            <div style='background-color: #f4f7f9; padding: 20px; font-family: Arial, sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
                    <div style='background-color: #13a4ec; padding: 20px; text-align: center;'>
                        <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Santa Marta Beachfront' style='width: 150px;'>
                    </div>
                    <div style='padding: 30px;'>
                        <h2 style='color: #333;'>¡Hola $nombre!</h2>
                        <p style='color: #555;'>Hemos recibido tu solicitud para el <strong>Apartamento #$id_apartamento</strong>. Aquí tienes el resumen de la información proporcionada:</p>
                        
                        <div style='background-color: #f9f9f9; padding: 15px; border-radius: 10px; margin-bottom: 20px;'>
                            <h3 style='margin-top: 0; font-size: 16px; color: #13a4ec;'>Detalles de la Estadía</h3>
                            <p style='margin: 5px 0; font-size: 14px;'><strong>Entrada:</strong> $checkin</p>
                            <p style='margin: 5px 0; font-size: 14px;'><strong>Salida:</strong> $checkout</p>
                            <p style='margin: 5px 0; font-size: 14px;'><strong>Total estimado:</strong> $" . number_format($total_price, 0, ',', '.') . "</p>
                        </div>

                        <div style='margin-bottom: 20px;'>
                            <h3 style='font-size: 16px; color: #13a4ec; border-bottom: 1px solid #eee; padding-bottom: 5px;'>Información de Contacto</h3>
                            <p style='margin: 5px 0; font-size: 14px;'><strong>Email:</strong> $email</p>
                            <p style='margin: 5px 0; font-size: 14px;'><strong>Teléfono:</strong> $telefono</p>
                            <p style='margin: 5px 0; font-size: 14px;'><strong>Cuenta para Devolución:</strong> " . ($cuenta_banco ? $cuenta_banco : 'No especificada') . "</p>
                        </div>

                        <div style='margin-bottom: 20px;'>
                            <h3 style='font-size: 16px; color: #13a4ec; border-bottom: 1px solid #eee; padding-bottom: 5px;'>Lista de Acompañantes</h3>
                            <p style='margin: 5px 0; font-size: 14px; color: #555; line-height: 1.5;'>$huespedes_nombres</p>
                        </div>

                        <p style='color: #777; font-size: 13px; text-align: center;'>Revisaremos la información y nos contactaremos contigo pronto para confirmar la disponibilidad y el pago.</p>
                    </div>
                    <div style='background-color: #eee; padding: 10px; text-align: center; font-size: 11px; color: #999;'>
                        Este es un correo automático, por favor no respondas a este mensaje.
                    </div>
                </div>
            </div>";

            $mail->send();
        } catch (Exception $e) {
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
?>