<?php
session_start();
include '../../auth/conexion_be.php';

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servicio = $_POST['servicio'];
    $mensaje = $_POST['mensaje'];
    $usuario_id = $_SESSION['id'];
    $nombre_usuario = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
    $email_usuario = $_SESSION['email'];

    // 1. Guardar en base de datos como PQR tipo "Petición"
    $asunto = "Solicitud de Servicio: " . $servicio;
    $mensaje_completo = "El usuario ha solicitado el servicio de: " . $servicio . "\n\nDetalles:\n" . $mensaje;
    
    $stmt = $conn->prepare("INSERT INTO pqr (usuario_id, tipo, asunto, mensaje, estado) VALUES (?, 'Petición', ?, ?, 'Pendiente')");
    $stmt->bind_param("iss", $usuario_id, $asunto, $mensaje_completo);
    
    if ($stmt->execute()) {
        // 2. Enviar correo (Simulación o implementación real)
        $to = "17clouds@gmail.com"; // Correo del administrador
        $subject = "Nueva Solicitud de Servicio - " . $servicio;
        $headers = "From: " . $email_usuario . "\r\n";
        $headers .= "Reply-To: " . $email_usuario . "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        $email_content = "
        <h2>Nueva Solicitud de Servicio</h2>
        <p><strong>Usuario:</strong> $nombre_usuario</p>
        <p><strong>Servicio:</strong> $servicio</p>
        <p><strong>Detalles:</strong><br>$mensaje</p>
        <hr>
        <p>Este mensaje fue enviado desde el Panel de Huésped.</p>
        ";

        // mail($to, $subject, $email_content, $headers); // Descomentar en servidor real

        // Redireccionar con éxito
        echo "<script>
            alert('Tu solicitud de servicio ha sido enviada correctamente.');
            window.location.href = 'huesped.php';
        </script>";
    } else {
        echo "<script>
            alert('Hubo un error al enviar tu solicitud.');
            window.history.back();
        </script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>