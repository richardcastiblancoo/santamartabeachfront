<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include '../../auth/conexion_be.php'; // Tu conexión a la DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recoger datos del formulario
    $id_apartamento = $_POST['id_apartamento'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email_cliente = $_POST['email'];
    $telefono = $_POST['telefono'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $huespedes = $_POST['huespedes_nombres'];
    $total = $_POST['total_price'];

    // 2. (Opcional) Guardar en Base de Datos primero
    // $sql = "INSERT INTO reservas (nombre, email, ...) VALUES ('$nombre', '$email_cliente', ...)";
    // $conn->query($sql);

    // 3. Configurar PHPMailer para Hostinger
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP (Titan/Hostinger)
        $mail->isSMTP();
        $mail->Host       = 'smtp.titan.email'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'richard_12345@santamartabeachfront.com'; // REEMPLAZA CON TU CORREO
        $mail->Password   = 'Richardcastiblanco_1234567890';       // REEMPLAZA CON TU CONTRASEÑA
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port       = 465;

        // Quien envía y quien recibe
        $mail->setFrom('richard_12345@santamartabeachfront.com', 'Santamarta Beachfront');
        $mail->addAddress('richard_12345@santamartabeachfront.com'); // A ti te llega el aviso
        $mail->addReplyTo($email_cliente, $nombre);  // Para responderle al cliente directo

        // Contenido del correo (Diseño HTML)
        $mail->isHTML(true);
        $mail->Subject = "Nueva Solicitud de Reserva - $nombre $apellido";
        
        $mail->Body = "
            <div style='font-family: sans-serif; border: 1px solid #eee; padding: 20px;'>
                <h2 style='color: #13a4ec;'>¡Nueva Solicitud de Reserva!</h2>
                <p><strong>Cliente:</strong> $nombre $apellido</p>
                <p><strong>Email:</strong> $email_cliente</p>
                <p><strong>Teléfono:</strong> +57 $telefono</p>
                <hr>
                <p><strong>Check-in:</strong> $checkin</p>
                <p><strong>Check-out:</strong> $checkout</p>
                <p><strong>Lista de Huéspedes:</strong><br> $huespedes</p>
                <h3 style='background: #f6f7f8; padding: 10px;'>Total: $$total COP</h3>
            </div>
        ";

        $mail->send();
        
        // Redirigir al usuario a una página de gracias
        header("Location: gracias.php");

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}