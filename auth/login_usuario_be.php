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
        $_SESSION['usuario'] = $usuario;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['rol'] = $rol;
        
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
