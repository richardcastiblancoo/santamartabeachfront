<?php
session_start();

// Validar si el usuario ha iniciado sesión y es administrador
if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'admin')) {
    header("Location: ../../auth/login.php");
    exit();
}

include '../../auth/conexion_be.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Evitar que un usuario se elimine a sí mismo
    if (isset($_SESSION['id']) && $_SESSION['id'] == $id) {
        echo '
            <script>
                alert("No puedes eliminar tu propia cuenta mientras estás conectado.");
                window.location = "usuarios.php";
            </script>
        ';
        exit();
    }

    // 1. Obtener y eliminar la imagen del servidor
    $sql_img = "SELECT imagen FROM usuarios WHERE id = $id";
    $result_img = mysqli_query($conn, $sql_img);
    
    if ($result_img && mysqli_num_rows($result_img) > 0) {
        $row = mysqli_fetch_assoc($result_img);
        $imagen_relativa = $row['imagen'];
        
        if (!empty($imagen_relativa)) {
            $ruta_imagen = '../../' . $imagen_relativa;
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }
    }

    // 2. Eliminar registros dependientes para evitar errores de Foreign Key
    
    // a) Eliminar respuestas de PQR hechas por este administrador
    $sql_del_respuestas_admin = "DELETE FROM respuestas_pqr WHERE admin_id = $id";
    mysqli_query($conn, $sql_del_respuestas_admin);

    // b) Eliminar respuestas asociadas a las PQRs creadas por este usuario
    // Primero identificamos las PQRs del usuario
    $sql_del_respuestas_pqr_usuario = "DELETE FROM respuestas_pqr WHERE pqr_id IN (SELECT id FROM pqr WHERE usuario_id = $id)";
    mysqli_query($conn, $sql_del_respuestas_pqr_usuario);

    // c) Eliminar las PQRs creadas por este usuario
    $sql_del_pqr = "DELETE FROM pqr WHERE usuario_id = $id";
    mysqli_query($conn, $sql_del_pqr);

    // d) Eliminar reservas del usuario (si la tabla existe)
    // Usamos @ para suprimir errores si la tabla no existe aún
    $sql_del_reservas = "DELETE FROM reservas WHERE usuario_id = $id";
    @mysqli_query($conn, $sql_del_reservas);

    // e) Eliminar reseñas del usuario
    $sql_del_resenas = "DELETE FROM resenas WHERE usuario_id = $id";
    mysqli_query($conn, $sql_del_resenas);

    // 3. Finalmente, eliminar el usuario
    $sql = "DELETE FROM usuarios WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo '
            <script>
                alert("Usuario eliminado exitosamente de forma permanente.");
                window.location = "usuarios.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Error al eliminar el usuario: ' . mysqli_error($conn) . '");
                window.location = "usuarios.php";
            </script>
        ';
    }
} else {
    header("Location: usuarios.php");
}

mysqli_close($conn);
?>
