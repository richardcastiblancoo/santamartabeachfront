<?php

include 'conexion_be.php';

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$usuario = $_POST['usuario'];
$correo = $_POST['correo'];
$password = $_POST['password'];
$rol = $_POST['rol'];

// Encriptar contraseña
$password = password_hash($password, PASSWORD_DEFAULT);

// Verificar que el correo no se repita en la base de datos
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

// Verificar que el usuario no se repita en la base de datos
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

$query = "INSERT INTO usuarios(nombre, apellido, usuario, email, password, rol) 
          VALUES('$nombre', '$apellido', '$usuario', '$correo', '$password', '$rol')";

$ejecutar = mysqli_query($conn, $query);

if ($ejecutar) {
    echo '
        <script>
            alert("Usuario almacenado exitosamente");
            window.location = "login.php";
        </script>
    ';
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
