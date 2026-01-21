<?php
session_start();
include 'conexion_be.php';

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Buscar por usuario
$validar_login = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$usuario'");

if (mysqli_num_rows($validar_login) > 0) {
    $row = mysqli_fetch_assoc($validar_login);
    $password_bd = $row['password'];
    $rol = $row['rol'];
    $nombre = $row['nombre'];
    
    if (password_verify($password, $password_bd)) {
        // Verificar si el email está confirmado (si no es usuario de Google)
        if (empty($row['google_id']) && isset($row['is_verified']) && $row['is_verified'] == 0) {
             // Permitir acceso pero notificar (opcional: usar una variable de sesión para mostrar banner en dashboard)
             $_SESSION['show_verify_alert'] = true;
        }

        $_SESSION['id'] = $row['id'];
                $_SESSION['usuario'] = $usuario;
                $_SESSION['nombre'] = $nombre;
                $_SESSION['apellido'] = $row['apellido'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['imagen'] = $row['imagen'];
                $_SESSION['rol'] = $rol;
                $_SESSION['tema'] = isset($row['tema']) ? $row['tema'] : '#13a4ec';
                
                if ($rol == 'Admin') {
            header("location: ../php/dashboard-admin/dashboard.php");
        } else {
            header("location: ../php/dashboard-huesped/huesped.php");
        }
        exit;
    } else {
        echo '
            <script>
                alert("Contraseña incorrecta, por favor verifique los datos introducidos");
                window.location = "login.php";
            </script>
        ';
        exit;
    }
} else {
    echo '
        <script>
            alert("El usuario no existe, por favor verifique los datos introducidos");
            window.location = "login.php";
        </script>
    ';
    exit;
}
?>
