<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['id'];
    $tipo = mysqli_real_escape_string($conn, $_POST['tipo']);
    $asunto = mysqli_real_escape_string($conn, $_POST['asunto']);
    $mensaje = mysqli_real_escape_string($conn, $_POST['mensaje']);

    if (empty($asunto) || empty($mensaje) || empty($tipo)) {
        echo '
            <script>
                alert("Por favor, completa todos los campos.");
                window.location = "huesped.php";
            </script>
        ';
        exit();
    }

    $query = "INSERT INTO pqr (usuario_id, tipo, asunto, mensaje) VALUES ('$usuario_id', '$tipo', '$asunto', '$mensaje')";

    if (mysqli_query($conn, $query)) {
        echo '
            <script>
                alert("Solicitud enviada exitosamente.");
                window.location = "huesped.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al enviar la solicitud: ' . mysqli_error($conn) . '");
                window.location = "huesped.php";
            </script>
        ';
    }

    mysqli_close($conn);
} else {
    header("Location: huesped.php");
    exit();
}
?>
