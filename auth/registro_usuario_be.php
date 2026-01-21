<?php
include 'conexion_be.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$correo = $_POST['email'];
$password = $_POST['password'];
$rol = 'Huésped'; // Rol por defecto

// Encriptar contraseña
$password_encriptada = password_hash($password, PASSWORD_DEFAULT);

// Verificar que el correo no se repita
$verificar_correo = mysqli_query($conn, "SELECT * FROM usuarios WHERE email = '$correo' ");
if (mysqli_num_rows($verificar_correo) > 0) {
    echo '
        <script>
            alert("Este correo ya está registrado, intenta con otro diferente");
            window.location = "registro.php";
        </script>
    ';
    exit();
}

// Verificar que el usuario no se repita
$verificar_usuario = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$usuario' ");
if (mysqli_num_rows($verificar_usuario) > 0) {
    echo '
        <script>
            alert("Este usuario ya está registrado, intenta con otro diferente");
            window.location = "registro.php";
        </script>
    ';
    exit();
}

// Generar token de verificación
$token = bin2hex(random_bytes(50));
$is_verified = 0;

$query = "INSERT INTO usuarios(nombre, apellido, usuario, email, password, rol, token, is_verified) 
          VALUES('$nombre', '$apellido', '$usuario', '$correo', '$password_encriptada', '$rol', '$token', '$is_verified')";

$ejecutar = mysqli_query($conn, $query);

if ($ejecutar) {
    // Enviar correo de verificación
    $asunto = "Verifica tu cuenta - Santamartabeachfront";
    $mensaje = "
    Hola $nombre,

    Gracias por registrarte en Santamartabeachfront. Para completar tu registro, por favor verifica tu correo electrónico haciendo clic en el siguiente enlace:

    http://localhost/auth/verificar_email.php?token=$token

    Si no te has registrado, por favor ignora este correo.

    Saludos,
    El equipo de Santamartabeachfront
    ";
    
    $cabeceras = "From: no-reply@santamartabeachfront.com";

    // Intentar enviar correo (Nota: en localhost requiere configuración de SMTP)
    $mail_sent = @mail($correo, $asunto, $mensaje, $cabeceras);
    
    if ($mail_sent) {
        echo '
            <script>
                alert("Usuario registrado. Por favor revisa tu correo para verificar tu cuenta.");
                window.location = "login.php";
            </script>
        ';
    } else {
        // Fallback para localhost si no hay servidor de correo
        echo '
            <script>
                alert("Usuario registrado. (Modo Local: Verifica tu correo manualmente usando el enlace en la base de datos o consola)");
                console.log("Enlace de verificación: http://localhost/auth/verificar_email.php?token=' . $token . '");
                window.location = "login.php";
            </script>
        ';
    }

} else {
    echo '
        <script>
            alert("Inténtalo de nuevo, usuario no almacenado");
            window.location = "registro.php";
        </script>
    ';
}

mysqli_close($conn);
?>