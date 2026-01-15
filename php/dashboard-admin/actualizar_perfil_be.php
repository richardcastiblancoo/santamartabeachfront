<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    header("location: ../../auth/login.php");
    exit;
}

$id_usuario = $_SESSION['id'];

if (isset($_POST['update_profile'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    // Check email uniqueness
    $check_email = mysqli_query($conn, "SELECT * FROM usuarios WHERE email = '$email' AND id != '$id_usuario'");
    if (mysqli_num_rows($check_email) > 0) {
        echo '<script>alert("El correo electrónico ya está en uso."); window.location = "configuracion.php";</script>';
        exit;
    }

    // Handle Image
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $img_name = $_FILES['imagen']['name'];
        $img_tmp_name = $_FILES['imagen']['tmp_name'];
        $img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($img_ext, $allowed_exts)) {
            $new_img_name = "user_" . $id_usuario . "_" . time() . "." . $img_ext;
            $upload_dir = "../../assets/img/usuarios/";
            
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($img_tmp_name, $upload_dir . $new_img_name)) {
                // Remove old image
                if (!empty($_SESSION['imagen']) && file_exists($upload_dir . $_SESSION['imagen'])) {
                    unlink($upload_dir . $_SESSION['imagen']);
                }
                $sql_img = "UPDATE usuarios SET imagen = '$new_img_name' WHERE id = '$id_usuario'";
                mysqli_query($conn, $sql_img);
                $_SESSION['imagen'] = $new_img_name;
            }
        }
    } elseif (isset($_POST['borrar_imagen']) && $_POST['borrar_imagen'] == '1') {
        $upload_dir = "../../assets/img/usuarios/";
        if (!empty($_SESSION['imagen']) && file_exists($upload_dir . $_SESSION['imagen'])) {
            unlink($upload_dir . $_SESSION['imagen']);
        }
        $sql_img = "UPDATE usuarios SET imagen = NULL WHERE id = '$id_usuario'";
        mysqli_query($conn, $sql_img);
        $_SESSION['imagen'] = null;
    }

    $sql_update = "UPDATE usuarios SET nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE id = '$id_usuario'";
    if (mysqli_query($conn, $sql_update)) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['apellido'] = $apellido;
        $_SESSION['email'] = $email;
        echo '<script>alert("Perfil actualizado."); window.location = "configuracion.php";</script>';
    } else {
        echo '<script>alert("Error al actualizar."); window.location = "configuracion.php";</script>';
    }
}

if (isset($_POST['update_username'])) {
    $new_username = $_POST['new_username'];
    
    // Check if username exists
    $check_user = mysqli_query($conn, "SELECT * FROM usuarios WHERE usuario = '$new_username' AND id != '$id_usuario'");
    if (mysqli_num_rows($check_user) > 0) {
        echo '<script>alert("El nombre de usuario ya está en uso."); window.location = "configuracion.php";</script>';
        exit;
    }

    $sql_update = "UPDATE usuarios SET usuario = '$new_username' WHERE id = '$id_usuario'";
    if (mysqli_query($conn, $sql_update)) {
        $_SESSION['usuario'] = $new_username;
        echo '<script>alert("Nombre de usuario actualizado."); window.location = "configuracion.php";</script>';
    } else {
        echo '<script>alert("Error al actualizar usuario."); window.location = "configuracion.php";</script>';
    }
}

if (isset($_POST['update_theme'])) {
    $theme_color = $_POST['theme_color'];
    $sql_update = "UPDATE usuarios SET tema = '$theme_color' WHERE id = '$id_usuario'";
    
    if (mysqli_query($conn, $sql_update)) {
        $_SESSION['tema'] = $theme_color;
        echo '<script>alert("Tema actualizado."); window.location = "configuracion.php";</script>';
    } else {
        echo '<script>alert("Error al actualizar el tema."); window.location = "configuracion.php";</script>';
    }
}

if (isset($_POST['update_password'])) {
    $current_pass = $_POST['current_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    if ($new_pass !== $confirm_pass) {
        echo '<script>alert("Las nuevas contraseñas no coinciden."); window.location = "configuracion.php";</script>';
        exit;
    }

    $sql = "SELECT password FROM usuarios WHERE id = '$id_usuario'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if (password_verify($current_pass, $row['password'])) {
        $new_pass_hashed = password_hash($new_pass, PASSWORD_DEFAULT);
        $sql_update = "UPDATE usuarios SET password = '$new_pass_hashed' WHERE id = '$id_usuario'";
        if (mysqli_query($conn, $sql_update)) {
            echo '<script>alert("Contraseña actualizada."); window.location = "configuracion.php";</script>';
        } else {
            echo '<script>alert("Error al actualizar contraseña."); window.location = "configuracion.php";</script>';
        }
    } else {
        echo '<script>alert("Contraseña actual incorrecta."); window.location = "configuracion.php";</script>';
    }
}
?>
