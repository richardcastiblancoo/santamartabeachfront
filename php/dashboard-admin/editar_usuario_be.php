<?php
session_start();
include '../../auth/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    
    // La contraseña es opcional en la edición
    $password = $_POST['password'];

    // Validar campos obligatorios
    if (empty($nombre) || empty($apellido) || empty($usuario) || empty($email) || empty($rol)) {
        echo '
            <script>
                alert("Por favor, completa todos los campos obligatorios.");
                window.location = "usuarios.php";
            </script>
        ';
        exit();
    }

    // Verificar si el usuario o correo ya existen en OTRO registro
    $check_query = "SELECT * FROM usuarios WHERE (usuario = '$usuario' OR email = '$email') AND id != $id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo '
            <script>
                alert("El usuario o correo electrónico ya están registrados por otro usuario.");
                window.location = "usuarios.php";
            </script>
        ';
        exit();
    }

    // Manejo de la imagen
    $update_imagen_sql = "";
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
            // Eliminar imagen anterior si existe
            $sql_old = "SELECT imagen FROM usuarios WHERE id = $id";
            $res_old = mysqli_query($conn, $sql_old);
            if ($row_old = mysqli_fetch_assoc($res_old)) {
                if (!empty($row_old['imagen']) && file_exists('../../' . $row_old['imagen'])) {
                    unlink('../../' . $row_old['imagen']);
                }
            }
            
            $imagen_path = 'assets/img/usuarios/' . $imagen_nuevo_nombre;
            $update_imagen_sql = ", imagen = '$imagen_path'";
        }
    }

    // Manejo de contraseña
    $update_pass_sql = "";
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $update_pass_sql = ", password = '$password_hash'";
    }

    // Actualizar en la base de datos
    $query = "UPDATE usuarios SET 
              nombre = '$nombre', 
              apellido = '$apellido', 
              usuario = '$usuario', 
              email = '$email', 
              rol = '$rol' 
              $update_imagen_sql 
              $update_pass_sql 
              WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        // Si el usuario editado es el mismo que está logueado, actualizar la sesión
        if (isset($_SESSION['id']) && $_SESSION['id'] == $id) {
            $_SESSION['nombre'] = $nombre;
            $_SESSION['apellido'] = $apellido;
            $_SESSION['usuario'] = $usuario;
            $_SESSION['email'] = $email;
            $_SESSION['rol'] = $rol;
            if (!empty($update_imagen_sql)) {
                $_SESSION['imagen'] = $imagen_path;
            }
        }

        echo '
            <script>
                alert("Usuario actualizado exitosamente.");
                window.location = "usuarios.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al actualizar el usuario: ' . mysqli_error($conn) . '");
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
