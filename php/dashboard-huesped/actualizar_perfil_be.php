<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['id'])) {
    header("location: ../../auth/login.php");
    exit;
}

$id = $_SESSION['id'];
$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
$apellido = mysqli_real_escape_string($conn, $_POST['apellido']);
$usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = $_POST['password'];

// Verificar si el usuario o email ya existen (excluyendo el actual)
$check_query = "SELECT * FROM usuarios WHERE (usuario = '$usuario' OR email = '$email') AND id != '$id'";
$check_result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($check_result) > 0) {
    echo '
        <script>
            alert("El usuario o correo electrónico ya está en uso por otra cuenta.");
            window.location = "huesped.php";
        </script>
    ';
    exit;
}

$update_query = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', usuario = '$usuario', email = '$email'";

// Manejo de contraseña
if (!empty($password)) {
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    $update_query .= ", password = '$password_hashed'";
}

// Manejo de imagen
if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $img_name = $_FILES['imagen']['name'];
    $img_tmp_name = $_FILES['imagen']['tmp_name'];
    $img_size = $_FILES['imagen']['size'];
    $img_error = $_FILES['imagen']['error'];
    
    // Extensiones permitidas
    $allowed_exs = array("jpg", "jpeg", "png", "gif");
    $img_ex = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
    
    if (in_array($img_ex, $allowed_exs)) {
        if ($img_size < 5000000) { // 5MB limit
            $new_img_name = uniqid("IMG-", true) . '.' . $img_ex;
            $img_upload_path = '../../assets/img/usuarios/' . $new_img_name;
            $db_img_path = 'assets/img/usuarios/' . $new_img_name;
            
            // Crear directorio si no existe
            if (!file_exists('../../assets/img/usuarios/')) {
                mkdir('../../assets/img/usuarios/', 0777, true);
            }
            
            move_uploaded_file($img_tmp_name, $img_upload_path);
            
            $update_query .= ", imagen = '$db_img_path'";
            $_SESSION['imagen'] = $db_img_path; // Actualizar sesión
        } else {
             echo '
                <script>
                    alert("Tu archivo es demasiado grande. Máximo 5MB.");
                    window.location = "huesped.php";
                </script>
            ';
            exit;
        }
    } else {
        echo '
            <script>
                alert("Tipo de archivo no permitido.");
                window.location = "huesped.php";
            </script>
        ';
        exit;
    }
}

$update_query .= " WHERE id = '$id'";

if (mysqli_query($conn, $update_query)) {
    // Actualizar variables de sesión
    $_SESSION['nombre'] = $nombre;
    $_SESSION['apellido'] = $apellido;
    $_SESSION['usuario'] = $usuario;
    $_SESSION['email'] = $email;
    
    echo '
        <script>
            alert("Perfil actualizado correctamente.");
            window.location = "huesped.php";
        </script>
    ';
} else {
    echo '
        <script>
            alert("Error al actualizar el perfil: ' . mysqli_error($conn) . '");
            window.location = "huesped.php";
        </script>
    ';
}
?>