<?php
include '../../auth/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Validar campos obligatorios
    if (empty($nombre) || empty($apellido) || empty($usuario) || empty($email) || empty($password) || empty($rol)) {
        echo '
            <script>
                alert("Por favor, completa todos los campos obligatorios.");
                window.location = "usuarios.php";
            </script>
        ';
        exit();
    }

    // Verificar si el usuario o correo ya existen
    $check_query = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo '
            <script>
                alert("El usuario o correo electrónico ya están registrados.");
                window.location = "usuarios.php";
            </script>
        ';
        exit();
    }

    // Procesar la imagen
    $imagen_path = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen_nombre = $_FILES['imagen']['name'];
        $imagen_temp = $_FILES['imagen']['tmp_name'];
        $imagen_ext = pathinfo($imagen_nombre, PATHINFO_EXTENSION);
        $imagen_nuevo_nombre = 'user_' . $usuario . '_' . time() . '.' . $imagen_ext;
        $destino = '../../assets/img/usuarios/' . $imagen_nuevo_nombre;
        
        // Crear directorio si no existe
        if (!file_exists('../../assets/img/usuarios/')) {
            mkdir('../../assets/img/usuarios/', 0777, true);
        }

        if (move_uploaded_file($imagen_temp, $destino)) {
            // Guardar ruta relativa para la base de datos (o absoluta según prefieras, pero relativa es mejor para portabilidad)
            // En este caso guardaremos la ruta relativa desde la raíz del sitio o la ruta completa de la imagen
            // Considerando cómo se usa en usuarios.php, parece que se usan URLs completas o rutas relativas.
            // Guardaremos la ruta relativa a la carpeta assets
            $imagen_path = 'assets/img/usuarios/' . $imagen_nuevo_nombre;
        } else {
            echo '
                <script>
                    alert("Error al subir la imagen.");
                    window.location = "usuarios.php";
                </script>
            ';
            exit();
        }
    }

    // Encriptar contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    $query = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, rol, imagen) 
              VALUES ('$nombre', '$apellido', '$usuario', '$email', '$password_hash', '$rol', '$imagen_path')";

    if (mysqli_query($conn, $query)) {
        echo '
            <script>
                alert("Usuario registrado exitosamente.");
                window.location = "usuarios.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al registrar el usuario: ' . mysqli_error($conn) . '");
                window.location = "usuarios.php";
            </script>
        ';
    }

    mysqli_close($conn);
} else {
    header("Location: usuarios.php");
    exit();
}
?>
