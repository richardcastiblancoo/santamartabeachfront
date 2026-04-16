<?php

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

const RESERVA_SMTP_HOST = 'smtp.hostinger.com';
const RESERVA_SMTP_PORT = 465;
const RESERVA_SMTP_USER = 'richard_12345@santamartabeachfront.com';
const RESERVA_SMTP_PASS = 'Richardcastiblanco_1234567890';
const RESERVA_FROM_EMAIL = 'richard_12345@santamartabeachfront.com';
const RESERVA_FROM_NAME = 'Santamartabeachfront';
const RESERVA_ADMIN_EMAIL = 'richardcastiblanco4@gmail.com';
const RESERVA_CONTACT_EMAIL = 'richardcastiblanco4@gmail.com';
const RESERVA_WHATSAPP = '+57 318 3813381';

function crearMailerReserva(): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = RESERVA_SMTP_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = RESERVA_SMTP_USER;
    $mail->Password = RESERVA_SMTP_PASS;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = RESERVA_SMTP_PORT;
    $mail->CharSet = 'UTF-8';
    $mail->setFrom(RESERVA_FROM_EMAIL, RESERVA_FROM_NAME);
    $mail->isHTML(true);

    return $mail;
}

function escaparTextoCorreo(?string $valor): string
{
    return htmlspecialchars(trim((string) $valor), ENT_QUOTES, 'UTF-8');
}

function formatearPrecioCorreo($valor): string
{
    return '$' . number_format((float) $valor, 0, ',', '.');
}

function obtenerNombreCompletoReserva(array $reserva): string
{
    return trim(($reserva['nombre'] ?? $reserva['nombre_cliente'] ?? '') . ' ' . ($reserva['apellido'] ?? $reserva['apellido_cliente'] ?? ''));
}

function obtenerCorreoReserva(array $reserva): string
{
    return trim((string) ($reserva['email'] ?? $reserva['email_cliente'] ?? ''));
}

function enviarCorreoNuevaReservaHuesped(array $reserva): bool
{
    $correo = obtenerCorreoReserva($reserva);
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $nombre = escaparTextoCorreo($reserva['nombre'] ?? $reserva['nombre_cliente'] ?? 'Huésped');
    $apartamento = escaparTextoCorreo($reserva['apartamento'] ?? $reserva['nombre_apartamento'] ?? 'Apartamento');
    $checkin = escaparTextoCorreo($reserva['checkin'] ?? $reserva['fecha_checkin'] ?? '');
    $checkout = escaparTextoCorreo($reserva['checkout'] ?? $reserva['fecha_checkout'] ?? '');
    $metodoPago = escaparTextoCorreo(ucfirst($reserva['metodo_pago'] ?? 'No especificado'));
    $bancoDetalle = escaparTextoCorreo($reserva['banco_detalle'] ?? '');
    $idReserva = (int) ($reserva['id_reserva'] ?? $reserva['id'] ?? 0);
    $precio = formatearPrecioCorreo($reserva['total_price'] ?? $reserva['precio_total'] ?? 0);

    try {
        $mail = crearMailerReserva();
        $mail->addAddress($correo, obtenerNombreCompletoReserva($reserva));
        $mail->Subject = "Confirmación de Solicitud - Santamartabeachfront (Reserva #$idReserva)";
        $mail->Body = "
        <div style='background-color: #f4f7f9; padding: 40px 20px; font-family: \"Segoe UI\", Helvetica, Arial, sans-serif; color: #333333;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;'>
                <div style='background-color: #0a2f42; padding: 40px 20px; text-align: center;'>
                    <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Santamartabeachfront Logo' style='width: 160px; margin-bottom: 20px;'>
                    <h1 style='margin: 0; font-size: 22px; color: #ffffff; font-weight: 400; letter-spacing: 1px;'>SOLICITUD RECIBIDA</h1>
                </div>
                <div style='padding: 40px 35px;'>
                    <h2 style='color: #0a2f42; font-size: 24px; margin-top: 0;'>Hola, $nombre</h2>
                    <p style='font-size: 16px; line-height: 1.6; color: #4a5568;'>
                        Recibimos tu solicitud de reserva para <strong>$apartamento</strong> y ya quedó registrada en nuestro sistema.
                    </p>
                    <div style='background-color: #f8fafc; border-left: 4px solid #13a4ec; padding: 20px; margin: 25px 0; border-radius: 4px;'>
                        <p style='margin: 0; font-size: 14px; color: #2d3748;'>
                            <strong>Reserva:</strong> #$idReserva<br>
                            <strong>Llegada:</strong> $checkin<br>
                            <strong>Salida:</strong> $checkout<br>
                            <strong>Método de pago:</strong> $metodoPago
                        </p>
                    </div>
                    " . ($bancoDetalle !== '' ? "
                    <p style='font-size: 14px; line-height: 1.6; color: #4a5568; margin: 0 0 15px 0;'>
                        <strong>Detalle bancario reportado:</strong> $bancoDetalle
                    </p>
                    " : "") . "
                    <p style='font-size: 15px; line-height: 1.6; color: #4a5568;'>
                        El equipo revisará tu información y te notificará por este mismo correo cuando la reserva sea <strong>confirmada</strong> o <strong>cancelada</strong>.
                    </p>
                    <table style='width: 100%; border-collapse: collapse; margin: 25px 0;'>
                        <tr>
                            <td style='padding: 14px 0; border-top: 1px solid #edf2f7; font-weight: bold;'>Total</td>
                            <td style='padding: 14px 0; border-top: 1px solid #edf2f7; text-align: right; font-weight: bold; color: #0a2f42;'>$precio</td>
                        </tr>
                    </table>
                    <div style='margin-top: 35px; padding-top: 20px; border-top: 1px solid #edf2f7; text-align: center;'>
                        <p style='font-size: 14px; color: #718096; margin-bottom: 10px;'>Si tienes preguntas, escríbenos a</p>
                        <a href='mailto:" . RESERVA_CONTACT_EMAIL . "' style='color: #13a4ec; font-weight: bold; text-decoration: none;'>" . RESERVA_CONTACT_EMAIL . "</a>
                    </div>
                </div>
            </div>
        </div>";
        $mail->send();

        return true;
    } catch (Exception $e) {
        error_log('Error al enviar correo de nueva reserva al huésped: ' . $e->getMessage());
        return false;
    }
}

function enviarCorreoNuevaReservaAdmin(array $reserva, array $adjuntos = []): bool
{
    $idReserva = (int) ($reserva['id_reserva'] ?? $reserva['id'] ?? 0);
    $apartamento = escaparTextoCorreo($reserva['apartamento'] ?? $reserva['nombre_apartamento'] ?? 'Apartamento');
    $checkin = escaparTextoCorreo($reserva['checkin'] ?? $reserva['fecha_checkin'] ?? '');
    $checkout = escaparTextoCorreo($reserva['checkout'] ?? $reserva['fecha_checkout'] ?? '');
    $nombreCompleto = escaparTextoCorreo(obtenerNombreCompletoReserva($reserva));
    $identificacion = escaparTextoCorreo($reserva['identificacion'] ?? 'No registrada');
    $correo = escaparTextoCorreo(obtenerCorreoReserva($reserva));
    $telefono = escaparTextoCorreo($reserva['telefono'] ?? 'No registrado');
    $huespedes = escaparTextoCorreo($reserva['huespedes_nombres'] ?? 'Solo el titular registrado.');
    $guia = !empty($reserva['guideDog']) || !empty($reserva['perro_guia']) ? 'Sí' : 'No';
    $precio = formatearPrecioCorreo($reserva['total_price'] ?? $reserva['precio_total'] ?? 0);
    $metodoPago = escaparTextoCorreo(strtoupper($reserva['metodo_pago'] ?? 'NO ESPECIFICADO'));
    $bancoDetalle = escaparTextoCorreo($reserva['banco_detalle'] ?? '');
    $cuentaBanco = escaparTextoCorreo($reserva['cuenta_banco'] ?? $reserva['cuenta_devolucion'] ?? 'No registrada');

    try {
        $mail = crearMailerReserva();
        $mail->addAddress(RESERVA_ADMIN_EMAIL);
        $mail->addReplyTo(obtenerCorreoReserva($reserva), $nombreCompleto);
        $mail->Subject = "NUEVA RESERVA #$idReserva - $metodoPago";

        foreach ($adjuntos as $rutaAdjunto) {
            if (is_string($rutaAdjunto) && $rutaAdjunto !== '' && file_exists($rutaAdjunto)) {
                $mail->addAttachment($rutaAdjunto);
            }
        }

        $mail->Body = "
        <div style='background-color: #f4f7f6; padding: 40px 20px; font-family: sans-serif; color: #333333;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid #e1e8ed;'>
                <div style='background-color: #0a2f42; padding: 30px 20px; text-align: center;'>
                    <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Logo Santamartabeachfront' style='max-width: 140px; margin-bottom: 15px; display: block; margin-left: auto; margin-right: auto;'>
                    <h1 style='margin: 0; font-size: 20px; color: #ffffff; letter-spacing: 1px; font-weight: 600;'>NUEVA SOLICITUD DE RESERVA</h1>
                    <p style='margin: 8px 0 0 0; color: #90CDF4; font-size: 14px;'>$apartamento</p>
                    <div style='margin-top: 15px; display: inline-block; background-color: #2b6cb0; color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: bold;'>
                        Solicitado el: " . date('d/m/Y H:i') . "
                    </div>
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
                        <p style='margin: 5px 0;'><strong>Titular:</strong> $nombreCompleto</p>
                        <p style='margin: 5px 0;'><strong>Identificación:</strong> $identificacion</p>
                        <p style='margin: 5px 0;'><strong>Email:</strong> <a href='mailto:$correo' style='color: #3182ce; text-decoration: none;'>$correo</a></p>
                        <p style='margin: 5px 0;'><strong>WhatsApp:</strong> $telefono</p>
                        <p style='margin: 5px 0;'><strong>Acompañantes:</strong> $huespedes</p>
                        <p style='margin: 5px 0;'><strong>Perro Guía:</strong> $guia</p>
                    </div>
                    <h2 style='font-size: 16px; color: #0a2f42; border-bottom: 2px solid #edf2f7; padding-bottom: 8px;'>Facturación y Pagos</h2>
                    <div style='margin-bottom: 30px; line-height: 1.6;'>
                        <p style='margin: 5px 0;'><strong>Precio Total:</strong> $precio</p>
                        <p style='margin: 5px 0;'><strong>Método de Pago:</strong> $metodoPago</p>
                        " . ($bancoDetalle !== '' ? "<p style='margin: 5px 0;'><strong>Detalle Banco:</strong> $bancoDetalle</p>" : "") . "
                        <p style='margin: 5px 0;'><strong>Cuenta Reembolso:</strong> $cuentaBanco</p>
                    </div>
                    <div style='text-align: center; margin-top: 30px;'>
                        <a href='https://wa.me/57$telefono' style='background-color: #25D366; color: #ffffff; padding: 14px 24px; text-decoration: none; border-radius: 6px; font-weight: bold; font-size: 16px; display: inline-block;'>Contactar por WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>";
        $mail->send();

        return true;
    } catch (Exception $e) {
        error_log('Error al enviar correo de nueva reserva al administrador: ' . $e->getMessage());
        return false;
    }
}

function enviarCorreoEstadoReservaHuesped(array $reserva, string $estado): bool
{
    $correo = obtenerCorreoReserva($reserva);
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    $estado = strtolower(trim($estado));
    if (!in_array($estado, ['confirmada', 'cancelada'], true)) {
        return false;
    }

    $nombre = escaparTextoCorreo($reserva['nombre'] ?? $reserva['nombre_cliente'] ?? 'Huésped');
    $apartamento = escaparTextoCorreo($reserva['apartamento'] ?? $reserva['nombre_apartamento'] ?? 'Apartamento');
    $checkin = escaparTextoCorreo($reserva['checkin'] ?? $reserva['fecha_checkin'] ?? '');
    $checkout = escaparTextoCorreo($reserva['checkout'] ?? $reserva['fecha_checkout'] ?? '');
    $idReserva = (int) ($reserva['id_reserva'] ?? $reserva['id'] ?? 0);
    $precio = formatearPrecioCorreo($reserva['total_price'] ?? $reserva['precio_total'] ?? 0);

    $esConfirmada = $estado === 'confirmada';
    $titulo = $esConfirmada ? 'TU RESERVA HA SIDO CONFIRMADA' : 'TU RESERVA HA SIDO CANCELADA';
    $asunto = $esConfirmada
        ? "Reserva confirmada - Santamartabeachfront (#$idReserva)"
        : "Reserva cancelada - Santamartabeachfront (#$idReserva)";
    $mensaje = $esConfirmada
        ? "Tu solicitud fue revisada y <strong>ha sido confirmada</strong>. Ya puedes contar con esta reserva para las fechas seleccionadas."
        : "Tu solicitud fue revisada y <strong>ha sido cancelada</strong>. Si deseas una nueva opción, puedes responder este correo para recibir ayuda.";
    $color = $esConfirmada ? '#16a34a' : '#dc2626';
    $bloqueFinal = $esConfirmada
        ? "<p style='font-size: 15px; line-height: 1.6; color: #4a5568;'>Si necesitas apoyo antes de tu llegada, escríbenos a <a href='mailto:" . RESERVA_CONTACT_EMAIL . "' style='color: #13a4ec; font-weight: bold; text-decoration: none;'>" . RESERVA_CONTACT_EMAIL . "</a> o por WhatsApp al " . RESERVA_WHATSAPP . ".</p>"
        : "<p style='font-size: 15px; line-height: 1.6; color: #4a5568;'>Si tienes dudas sobre la cancelación o quieres reprogramar, contáctanos en <a href='mailto:" . RESERVA_CONTACT_EMAIL . "' style='color: #13a4ec; font-weight: bold; text-decoration: none;'>" . RESERVA_CONTACT_EMAIL . "</a>.</p>";

    try {
        $mail = crearMailerReserva();
        $mail->addAddress($correo, obtenerNombreCompletoReserva($reserva));
        $mail->Subject = $asunto;
        $mail->Body = "
        <div style='background-color: #f4f7f9; padding: 40px 20px; font-family: \"Segoe UI\", Helvetica, Arial, sans-serif; color: #333333;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden;'>
                <div style='background-color: #0a2f42; padding: 40px 20px; text-align: center;'>
                    <img src='https://santamartabeachfront.com/public/img/logo-def-Photoroom.png' alt='Santamartabeachfront Logo' style='width: 160px; margin-bottom: 20px;'>
                    <h1 style='margin: 0; font-size: 22px; color: #ffffff; font-weight: 400; letter-spacing: 1px;'>$titulo</h1>
                </div>
                <div style='padding: 40px 35px;'>
                    <h2 style='color: #0a2f42; font-size: 24px; margin-top: 0;'>Hola, $nombre</h2>
                    <p style='font-size: 16px; line-height: 1.6; color: #4a5568;'>$mensaje</p>
                    <div style='background-color: #f8fafc; border-left: 4px solid $color; padding: 20px; margin: 25px 0; border-radius: 4px;'>
                        <p style='margin: 0; font-size: 14px; color: #2d3748;'>
                            <strong>Reserva:</strong> #$idReserva<br>
                            <strong>Apartamento:</strong> $apartamento<br>
                            <strong>Llegada:</strong> $checkin<br>
                            <strong>Salida:</strong> $checkout<br>
                            <strong>Total:</strong> $precio
                        </p>
                    </div>
                    $bloqueFinal
                    <div style='margin-top: 35px; padding-top: 20px; border-top: 1px solid #edf2f7; text-align: center; color: #718096; font-size: 12px;'>
                        &copy; " . date('Y') . " Santamartabeachfront. Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </div>";
        $mail->send();

        return true;
    } catch (Exception $e) {
        error_log('Error al enviar correo de estado de reserva: ' . $e->getMessage());
        return false;
    }
}
