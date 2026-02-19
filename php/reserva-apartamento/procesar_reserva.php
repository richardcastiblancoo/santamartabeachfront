<?php

/**
 * Procesamiento de Reserva - Santamartabeachfront
 * Maneja la subida de múltiples documentos, validación de fechas y envío de correos duales.
 */

session_start();
include '../../auth/conexion_be.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

// 1. Recibir y limpiar datos del formulario
$id_apartamento = intval($_POST['id_apartamento']);
$checkin         = $_POST['checkin'];
$checkout        = $_POST['checkout'];
$adults          = intval($_POST['adults']);
$children        = intval($_POST['children']);
$infants         = intval($_POST['infants']);
$guideDog        = intval($_POST['guideDog']);
$total_price     = floatval($_POST['total_price']);
$metodo_pago     = $_POST['metodo_pago'] ?? 'No especificado';
$isEmbed         = isset($_POST['embed']) && $_POST['embed'] === '1';

$nombre          = trim($_POST['nombre'] ?? '');
$apellido        = trim($_POST['apellido'] ?? '');
$email           = trim($_POST['email'] ?? '');
$telefono        = trim($_POST['telefono'] ?? '');
$cuenta_banco    = trim($_POST['cuenta_devolucion'] ?? '');

// 2. Procesar Array de Huéspedes
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
            $nombre_original = $_FILES['documento_id']['name'][$key];
            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);
            $nuevo_nombre = "reserva_" . time() . "_" . uniqid() . "." . $extension;
            $ruta_dest = $dir_subida . $nuevo_nombre;

            if (move_uploaded_file($tmp_name, $ruta_dest)) {
                $documentos_subidos[] = $nuevo_nombre;
            }
        }
    }
}
// Guardamos los nombres de archivos en la BD separados por comas
$documento_ruta_db = implode(",", $documentos_subidos);

// 4. Validación de disponibilidad (Evitar Overlap)
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

// 5. Insertar Registro en Base de Datos
$estado = 'pendiente';
$insertSql = "INSERT INTO reservas (apartamento_id, nombre_cliente, apellido_cliente, email_cliente, telefono, huespedes_nombres, documento_ruta, cuenta_devolucion, fecha_checkin, fecha_checkout, adultos, ninos, bebes, perro_guia, precio_total, estado, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertStmt = $conn->prepare($insertSql);

if ($insertStmt) {
    $insertStmt->bind_param(
        'isssssssssiiiidss',
        $id_apartamento,
        $nombre,
        $apellido,
        $email,
        $telefono,
        $huespedes_nombres,
        $documento_ruta_db,
        $cuenta_banco,
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

        // --- BLOQUE DE ENVÍO DE EMAIL ---
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'smtp.hostinger.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'richard_12345@santamartabeachfront.com';
            $mail->Password   = 'Richardcastiblanco_1234567890';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom('richard_12345@santamartabeachfront.com', 'Santamartabeachfront');
            $mail->isHTML(true);

            // --- CORREO PARA EL HUÉSPED ---
            $mail->addAddress($email, "$nombre $apellido");
            $mail->Subject = "Solicitud Recibida - Apartamento 1730 Santamartabeachfront";
            $mail->Body = "
            <div style='background-color: #f4f7f9; padding: 20px; font-family: sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 15px; border: 1px solid #e1e8ed;'>
                    <div style='background-color: #0a2f42; padding: 25px; text-align: center;'>
                        <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Logo Santamartabeachfront' style='width: 140px;'>
                    </div>
                    <div style='padding: 30px;'>
                        <h2 style='color: #0a2f42;'>¡Hola $nombre!</h2>
                        <p>Gracias por elegir <strong>Santamartabeachfront</strong>. Hemos recibido tu solicitud para el <strong>Apartamento 1730</strong>.</p>
                        
                        <div style='background: #f8fafc; padding: 20px; border-radius: 10px; margin: 20px 0;'>
                            <h3 style='margin-top:0; color: #13a4ec;'>Resumen de tu estancia:</h3>
                            <p style='margin: 5px 0;'>📅 <strong>Check-in:</strong> $checkin</p>
                            <p style='margin: 5px 0;'>📅 <strong>Check-out:</strong> $checkout</p>
                            <p style='margin: 5px 0;'>👥 <strong>Huéspedes:</strong> " . ($adults + $children) . " personas</p>
                            <p style='margin: 5px 0;'>💳 <strong>Método elegido:</strong> " . ucfirst($metodo_pago) . "</p>
                            <p style='font-size: 18px; color: #0a2f42; font-weight: bold;'>Total: $" . number_format($total_price, 0, ',', '.') . "</p>
                        </div>

                        <p style='color: #4a5568;'><strong>¿Qué sigue?</strong> Nuestro equipo revisará la información y te contactará vía WhatsApp o correo para proporcionarte los datos de pago y confirmar tu reserva.</p>
                        
                        <p style='font-size: 12px; color: #94a3b8; margin-top: 30px;'>📍 Calle 22 # 1 - 67 Playa Salguero, Santa Marta, Colombia.</p>
                    </div>
                </div>
            </div>";
            $mail->send();

            // --- CORREO PARA EL ADMINISTRADOR ---
            $mail->clearAddresses();
            $mail->addAddress('richard_12345@santamartabeachfront.com');
            $mail->Subject = "NUEVA SOLICITUD #$id_reserva - Santamartabeachfront";

            // Adjuntar todos los archivos subidos
            foreach ($documentos_subidos as $doc) {
                $mail->addAttachment($dir_subida . $doc);
            }

            $mail->Body = "
            <div style='background-color: #fff5f5; padding: 20px; font-family: sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 15px; border: 1px solid #feb2b2;'>
                    <div style='background-color: #c53030; padding: 20px; text-align: center; color: white;'>
                        <h1 style='margin:0; font-size: 18px;'>NUEVA RESERVA PENDIENTE</h1>
                    </div>
                    <div style='padding: 30px;'>
                        <p><strong>Cliente:</strong> $nombre $apellido</p>
                        <p><strong>Teléfono:</strong> $telefono</p>
                        <p><strong>Método de Pago:</strong> <span style='color: #c53030; font-weight: bold;'>" . strtoupper($metodo_pago) . "</span></p>
                        <p><strong>Acompañantes:</strong> $huespedes_nombres</p>
                        <p><strong>Cuenta Reembolso:</strong> $cuenta_banco</p>
                        <hr>
                        <p><strong>Fechas:</strong> $checkin al $checkout</p>
                        <p><strong>Total a cobrar:</strong> $" . number_format($total_price, 0, ',', '.') . "</p>
                        
                        <div style='text-align: center; margin-top: 25px;'>
                            <a href='https://wa.me/57$telefono' style='background-color: #25d366; color: white; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Hablar con Cliente por WhatsApp</a>
                        </div>
                    </div>
                </div>
            </div>";
            $mail->send();
        } catch (Exception $e) {
            error_log("Error de PHPMailer: " . $mail->ErrorInfo);
        }

        $embedParam = $isEmbed ? '&embed=1' : '';
        header("Location: reserva_exitosa.php?id=$id_reserva$embedParam");
        exit;
    }
}
$conn->close();
?>