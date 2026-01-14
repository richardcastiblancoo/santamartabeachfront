<?php
session_start();

// Validar si el usuario ha iniciado sesión y es administrador (ajusta según tu lógica de login)
// Por ahora asumimos que si llega aquí es porque tiene permisos o se maneja en el frontend, 
// pero es buena práctica verificar la sesión.
// if (!isset($_SESSION['usuario'])) { ... }

include '../../auth/conexion_be.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Evitar que un usuario se elimine a sí mismo (opcional pero recomendado)
    // if ($_SESSION['id'] == $id) { ... }

    // Obtener la imagen para eliminarla del servidor
    $sql_img = "SELECT imagen FROM usuarios WHERE id = $id";
    $result_img = mysqli_query($conn, $sql_img);
    
    if ($result_img && mysqli_num_rows($result_img) > 0) {
        $row = mysqli_fetch_assoc($result_img);
        $imagen_relativa = $row['imagen']; // e.g., assets/img/usuarios/foto.jpg
        
        if (!empty($imagen_relativa)) {
            // Construir la ruta física completa
            // usuarios.php está en php/dashboard-admin/
            // La imagen se guarda como assets/img/usuarios/...
            // Así que desde aquí (php/dashboard-admin/eliminar_usuario_be.php) debemos subir 2 niveles
            $ruta_imagen = '../../' . $imagen_relativa;
            
            if (file_exists($ruta_imagen)) {
                unlink($ruta_imagen);
            }
        }
    }

    // Eliminar el registro de la base de datos
    $sql = "DELETE FROM usuarios WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo '
            <script>
                alert("Usuario eliminado exitosamente.");
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
