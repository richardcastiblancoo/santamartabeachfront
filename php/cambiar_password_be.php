<?php
session_start();
include 'conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

$correo = $_SESSION['usuario'];
$password_actual = $_POST['password_actual'];
$password_nueva = $_POST['password_nueva'];
$password_confirmar = $_POST['password_confirmar'];

if ($password_nueva !== $password_confirmar) {
    echo '
        <script>
            alert("Las nuevas contraseñas no coinciden");
            window.location = "panel.php";
        </script>
    ';
    exit();
}

// Obtener contraseña actual de la BD
$query = "SELECT password FROM usuarios WHERE usuario = '$correo'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$password_bd = $row['password'];

if (password_verify($password_actual, $password_bd)) {
    // La contraseña actual es correcta, proceder al cambio
    $password_nueva_hash = password_hash($password_nueva, PASSWORD_DEFAULT);
    
    $update_query = "UPDATE usuarios SET password = '$password_nueva_hash' WHERE usuario = '$correo'";
    if (mysqli_query($conn, $update_query)) {
        echo '
            <script>
                alert("Contraseña actualizada correctamente");
                window.location = "panel.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al actualizar la contraseña");
                window.location = "panel.php";
            </script>
        ';
    }
} else {
    echo '
        <script>
            alert("La contraseña actual es incorrecta");
            window.location = "panel.php";
        </script>
    ';
}

mysqli_close($conn);
?>
