<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['id'];
    $apartamento_id = intval($_POST['id_apartamento']); // Cambiado a id_apartamento para coincidir con el form
    $calificacion = intval($_POST['calificacion']);
    $comentario = mysqli_real_escape_string($conn, $_POST['comentario']);

    // Validar datos
    if (empty($apartamento_id) || empty($calificacion)) {
        echo '
            <script>
                alert("Faltan datos requeridos para la reseña.");
                window.location = "huesped.php";
            </script>
        ';
        exit();
    }

    $sql = "INSERT INTO resenas (apartamento_id, usuario_id, calificacion, comentario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $apartamento_id, $usuario_id, $calificacion, $comentario);

    if ($stmt->execute()) {
        echo '
            <script>
                alert("¡Gracias! Tu reseña ha sido guardada correctamente.");
                window.location = "huesped.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al guardar la reseña: ' . $conn->error . '");
                window.location = "huesped.php";
            </script>
        ';
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: huesped.php");
    exit();
}
?>