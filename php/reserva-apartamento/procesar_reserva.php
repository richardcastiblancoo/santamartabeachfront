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

// 4. Validación de Disponibilidad (Overlap)
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

// 5. Insertar en BD (17 parámetros)
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
            $mail->Subject = "Confirmación de Solicitud - Santamartabeachfront (Reserva #$id_reserva)";
            $mail->Body = "
            <div style='background-color: #f4f7f9; padding: 40px 20px; font-family: \"Segoe UI\", Helvetica, Arial, sans-serif; color: #333333;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;'>
                    
                    <div style='background-color: #0a2f42; padding: 40px 20px; text-align: center;'>
                        <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Santamartabeachfront Logo' style='width: 160px; margin-bottom: 20px;'>
                        <h1 style='margin: 0; font-size: 22px; color: #ffffff; font-weight: 400; letter-spacing: 1px;'>SOLICITUD RECIBIDA</h1>
                    </div>

                    <div style='padding: 40px 35px;'>
                        <h2 style='color: #0a2f42; font-size: 24px; margin-top: 0;'>¡Hola $nombre!</h2>
                        <p style='font-size: 16px; line-height: 1.6; color: #4a5568;'>
                            Gracias por elegir <strong>Santamartabeachfront</strong>. Hemos recibido tu solicitud para disfrutar de una estancia en el <strong>Apartamento 1730 reserva del mar 1</strong>.
                        </p>

                        <div style='background-color: #f8fafc; border-left: 4px solid #13a4ec; padding: 20px; margin: 25px 0; border-radius: 4px;'>
                            <p style='margin: 0; font-size: 14px; color: #2d3748;'>
                                📍 <strong>Ubicación:</strong><br>
                                Calle 22 # 1 - 67 Playa Salguero, Santa Marta.
                            </p>
                        </div>

                        <h3 style='color: #13a4ec; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;'>Resumen de tu estancia:</h3>
                        <table style='width: 100%; border-collapse: collapse; margin-bottom: 30px;'>
                            <tr>
                                <td style='padding: 12px 0; border-bottom: 1px solid #edf2f7;'><strong>Llegada:</strong></td>
                                <td style='padding: 12px 0; border-bottom: 1px solid #edf2f7; text-align: right;'>$checkin</td>
                            </tr>
                            <tr>
                                <td style='padding: 12px 0; border-bottom: 1px solid #edf2f7;'><strong>Salida:</strong></td>
                                <td style='padding: 12px 0; border-bottom: 1px solid #edf2f7; text-align: right;'>$checkout</td>
                            </tr>
                            <tr>
                                <td style='padding: 12px 0; border-bottom: 1px solid #edf2f7;'><strong>Método de pago:</strong></td>
                                <td style='padding: 12px 0; border-bottom: 1px solid #edf2f7; text-align: right;'>" . ucfirst($metodo_pago) . "</td>
                            </tr>
                            <tr>
                                <td style='padding: 20px 0; font-size: 18px; color: #0a2f42;'><strong>Total:</strong></td>
                                <td style='padding: 20px 0; font-size: 18px; color: #0a2f42; text-align: right;'><strong>$" . number_format($total_price, 0, ',', '.') . "</strong></td>
                            </tr>
                        </table>

                        <p style='font-size: 15px; line-height: 1.6; color: #4a5568;'>
                            Nuestro equipo está revisando los detalles. <strong>Nos comunicaremos contigo a la brevedad</strong> para finalizar el proceso.
                        </p>

                        <div style='margin-top: 40px; padding-top: 25px; border-top: 1px solid #edf2f7; text-align: center;'>
                            <p style='font-size: 14px; color: #718096; margin-bottom: 10px;'>¿Tienes alguna duda o necesitas más información?</p>
                            <a href='mailto:17clouds@gmail.com' style='color: #13a4ec; font-weight: bold; text-decoration: none;'>17clouds@gmail.com</a>
                        </div>
                    </div>

                    <div style='background-color: #f8fafc; padding: 20px; text-align: center; font-size: 12px; color: #a0aec0;'>
                        &copy; " . date('Y') . " Santamartabeachfront. Todos los derechos reservados.
                    </div>
                </div>
            </div>";
            $mail->send();

            // --- CORREO AL ADMINISTRADOR ---
            $mail->clearAddresses();
            $mail->addAddress('17clouds@gmail.com');
            $mail->Subject = "NUEVA RESERVA #$id_reserva - " . strtoupper($metodo_pago);

            // Adjuntar todos los archivos
            foreach ($documentos_subidos as $archivo) {
                $mail->addAttachment($dir_subida . $archivo);
            }

            $mail->Body = "
            <div style='background-color: #f4f7f6; padding: 40px 20px; font-family: sans-serif; color: #333333;'>
                <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e1e8ed;'>
                    
                    <div style='background-color: #0a2f42; padding: 30px 20px; text-align: center;'>
                        <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Logo Santamartabeachfront' style='max-width: 140px; margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto;'>
                        <h1 style='margin: 0; font-size: 20px; color: #ffffff; letter-spacing: 1px; font-weight: 600;'>NUEVA SOLICITUD DE RESERVA</h1>
                        <p style='margin: 8px 0 0 0; color: #90CDF4; font-size: 14px;'>Apartamento 1730 reserva del mar 1</p>
                    </div>

                    <div style='padding: 30px;'>
                        <h2 style='font-size: 16px; color: #0a2f42; border-bottom: 2px solid #edf2f7; padding-bottom: 8px; margin-top: 0;'>Detalles de la Estancia</h2>
                        <table style='width: 100%; margin-bottom: 25px; border-collapse: collapse;'>
                            <tr>
                                <td style='padding: 8px 0; width: 50%;'>
                                    <span style='font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold;'>Llegada</span><br>
                                    <strong style='font-size: 15px;'>$checkin</strong>
                                </td>
                                <td style='padding: 8px 0; width: 50%;'>
                                    <span style='font-size: 12px; color: #718096; text-transform: uppercase; font-weight: bold;'>Salida</span><br>
                                    <strong style='font-size: 15px;'>$checkout</strong>
                                </td>
                            </tr>
                        </table>

                        <h2 style='font-size: 16px; color: #0a2f42; border-bottom: 2px solid #edf2f7; padding-bottom: 8px;'>Información del Huésped</h2>
                        <div style='margin-bottom: 25px; line-height: 1.6;'>
                            <p style='margin: 5px 0;'><strong>Titular:</strong> $nombre $apellido</p>
                            <p style='margin: 5px 0;'><strong>Email:</strong> <a href='mailto:$email' style='color: #3182ce; text-decoration: none;'>$email</a></p>
                            <p style='margin: 5px 0;'><strong>WhatsApp:</strong> $telefono</p>
                            <p style='margin: 5px 0;'><strong>Acompañantes:</strong> $huespedes_nombres</p>
                            <p style='margin: 5px 0;'><strong>Perro Guía:</strong> " . ($guideDog ? 'Sí' : 'No') . "</p>
                        </div>

                        <h2 style='font-size: 16px; color: #0a2f42; border-bottom: 2px solid #edf2f7; padding-bottom: 8px;'>Facturación y Pagos</h2>
                        <div style='margin-bottom: 30px; line-height: 1.6;'>
                            <p style='margin: 5px 0;'><strong>Precio Total:</strong> $" . number_format($total_price, 0, ',', '.') . "</p>
                            <p style='margin: 5px 0;'><strong>Método de Pago:</strong> " . strtoupper($metodo_pago) . "</p>
                            <p style='margin: 5px 0;'><strong>Cuenta Reembolso:</strong> $cuenta_banco</p>
                        </div>

                        <div style='text-align: center; margin-top: 30px;'>
                            <a href='https://wa.me/57$telefono' style='background-color: #25D366; color: #ffffff; padding: 14px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;'>Contactar por WhatsApp</a>
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
