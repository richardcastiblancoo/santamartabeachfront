<?php
/**
 * Procesamiento de Reserva - Santamartabeachfront
 * Versión Completa: Múltiples documentos, Perros guía, Pagos y Correos Duales.
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
$cuenta_banco    = trim($_POST['cuenta_devolucion'] ?? '');

// 2. Procesar Lista de Huéspedes
$lista_huespedes = isset($_POST['huespedes']) ? $_POST['huespedes'] : [];
$huespedes_nombres = implode(", ", array_map('trim', $lista_huespedes));

// 3. Manejo de Múltiples Documentos (Fotos o PDFs)
$documentos_subidos = [];
$dir_subida = "../../uploads/documentos/"; 

if (!empty($_FILES['documento_id']['name'][0])) {
    if (!file_exists($dir_subida)) { mkdir($dir_subida, 0777, true); }
    
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

// 4. Validación de Disponibilidad (Overlap)
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

// 5. Insertar en BD (17 parámetros)
$estado = 'pendiente';
$insertSql = "INSERT INTO reservas (apartamento_id, nombre_cliente, apellido_cliente, email_cliente, telefono, huespedes_nombres, documento_ruta, cuenta_devolucion, fecha_checkin, fecha_checkout, adultos, ninos, bebes, perro_guia, precio_total, estado, metodo_pago) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$insertStmt = $conn->prepare($insertSql);

if ($insertStmt) {
    $insertStmt->bind_param('isssssssssiiiidss', 
        $id_apartamento, $nombre, $apellido, $email, $telefono, 
        $huespedes_nombres, $documento_ruta_db, $cuenta_banco, 
        $checkin, $checkout, $adults, $children, $infants, 
        $guideDog, $total_price, $estado, $metodo_pago
    );

    if ($insertStmt->execute()) {
        $id_reserva = $conn->insert_id;

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

            // --- CORREO AL HUÉSPED ---
            $mail->addAddress($email, "$nombre $apellido");
            $mail->Subject = "Solicitud Recibida - Santamartabeachfront (Reserva #$id_reserva)";
            $mail->Body = "
            <div style='background-color: #f4f7f9; padding: 20px; font-family: sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 15px; border: 1px solid #e1e8ed;'>
                    <div style='background-color: #0a2f42; padding: 25px; text-align: center;'>
                        <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Logo' style='width: 140px;'>
                    </div>
                    <div style='padding: 30px;'>
                        <h2 style='color: #0a2f42;'>¡Hola $nombre!</h2>
                        <p>Hemos recibido tu solicitud para el <strong>Apartamento 1730 reserva del mar 1</strong>.</p>
                        <p style='color: #718096; font-size: 14px; background: #edf2f7; padding: 15px; border-radius: 8px;'>
                            📍 <strong>Ubicación:</strong> Calle 22 # 1 - 67 Playa Salguero, Santa Marta.
                        </p>
                        <h3 style='color: #13a4ec;'>Detalles:</h3>
                        <p><strong>Check-in:</strong> $checkin<br>
                        <strong>Check-out:</strong> $checkout<br>
                        <strong>Total:</strong> $" . number_format($total_price, 0, ',', '.') . "<br>
                        <strong>Método de pago:</strong> " . ucfirst($metodo_pago) . "</p>
                        <p>Nos comunicaremos pronto para finalizar el proceso.</p>
                    </div>
                </div>
            </div>";
            $mail->send();

            // --- CORREO AL ADMINISTRADOR ---
            $mail->clearAddresses();
            $mail->addAddress('richardcastiblanco4@gmail.com'); 
            $mail->Subject = "NUEVA RESERVA #$id_reserva - " . strtoupper($metodo_pago);
            
            // Adjuntar todos los archivos
            foreach ($documentos_subidos as $archivo) {
                $mail->addAttachment($dir_subida . $archivo);
            }

            $mail->Body = "
            <div style='background-color: #fff5f5; padding: 20px; font-family: sans-serif;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 15px; border: 1px solid #feb2b2;'>
                    <div style='background-color: #c53030; padding: 20px; text-align: center; color: white;'>
                        <h1 style='margin:0; font-size: 18px;'>NUEVA SOLICITUD DE RESERVA</h1>
                    </div>
                    <div style='padding: 30px;'>
                        <p><strong>Huésped:</strong> $nombre $apellido</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>WhatsApp:</strong> $telefono</p>
                        <p><strong>Huéspedes Adicionales:</strong> $huespedes_nombres</p>
                        <p><strong>Perro Guía:</strong> " . ($guideDog ? 'Sí' : 'No') . "</p>
                        <p><strong>Pago Elegido:</strong> " . strtoupper($metodo_pago) . "</p>
                        <p><strong>Cuenta Reembolso:</strong> $cuenta_banco</p>
                        <hr>
                        <div style='text-align: center; margin-top: 20px;'>
                            <a href='https://wa.me/57$telefono' style='background-color: #25d366; color: white; padding: 12px 20px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Contactar por WhatsApp</a>
                        </div>
                    </div>
                </div>
            </div>";
            $mail->send();

        } catch (Exception $e) {
            error_log("Error de Mail: " . $mail->ErrorInfo);
        }

        $embedParam = $isEmbed ? '&embed=1' : '';
        header("Location: reserva_exitosa.php?id=$id_reserva$embedParam");
        exit;
    }
}
$conn->close();
?>