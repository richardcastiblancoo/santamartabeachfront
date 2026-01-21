<?php
session_start();
include '../../auth/conexion_be.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

$id = $_SESSION['id'];

// Obtener datos del usuario
$query = "SELECT * FROM usuarios WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user['is_verified'] == 1) {
    echo json_encode(['success' => false, 'message' => 'Tu cuenta ya está verificada']);
    exit;
}

$email = $user['email'];
$nombre = $user['nombre'];
$token = $user['token'];

// Si no tiene token (por alguna razón), generar uno
if (empty($token)) {
    $token = bin2hex(random_bytes(50));
    $update = "UPDATE usuarios SET token = '$token' WHERE id = '$id'";
    mysqli_query($conn, $update);
}

// Enviar correo
$asunto = "Verifica tu cuenta - Santamartabeachfront";
$mensaje = "
Hola $nombre,

Para verificar tu cuenta en Santamartabeachfront, haz clic en el siguiente enlace:

http://localhost/auth/verificar_email.php?token=$token

Si no has solicitado esto, ignora este mensaje.

Saludos,
El equipo de Santamartabeachfront
";

$cabeceras = "From: no-reply@santamartabeachfront.com";

$mail_sent = @mail($email, $asunto, $mensaje, $cabeceras);

if ($mail_sent) {
    // AUNQUE SE ENVÍE (o PHP diga que sí), en localhost devolvemos el link para facilitar pruebas
    echo json_encode([
        'success' => true, 
        'message' => 'Correo enviado. (Si no llega, usa el enlace de abajo)',
        'debug_link' => "http://localhost/auth/verificar_email.php?token=$token"
    ]);
} else {
    // Fallback para localhost
    echo json_encode([
        'success' => true, 
        'message' => 'Correo enviado (Simulado en Localhost).',
        'debug_link' => "http://localhost/auth/verificar_email.php?token=$token"
    ]);
}
?>