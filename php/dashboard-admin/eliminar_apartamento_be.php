<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado."); window.location = "../../auth/login.php";</script>';
    exit;
}

include '../../auth/conexion_be.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Primero obtener la imagen para eliminarla del servidor
    $sql_img = "SELECT imagen_principal FROM apartamentos WHERE id = $id";
    $result_img = $conn->query($sql_img);
    if ($result_img && $result_img->num_rows > 0) {
        $row = $result_img->fetch_assoc();
        $imagen = $row['imagen_principal'];
        $ruta_imagen = '../../assets/img/apartamentos/' . $imagen;
        
        if (file_exists($ruta_imagen)) {
            unlink($ruta_imagen);
        }
    }

    // Eliminar archivos de la galería
    $sql_galeria = "SELECT tipo, ruta FROM galeria_apartamentos WHERE apartamento_id = $id";
    $result_galeria = $conn->query($sql_galeria);
    if ($result_galeria && $result_galeria->num_rows > 0) {
        while($row_gal = $result_galeria->fetch_assoc()) {
            $ruta_archivo = '';
            if ($row_gal['tipo'] == 'imagen') {
                $ruta_archivo = '../../assets/img/apartamentos/' . $row_gal['ruta'];
            } else if ($row_gal['tipo'] == 'video') {
                $ruta_archivo = '../../assets/video/apartamentos/' . $row_gal['ruta'];
            }

            if (!empty($ruta_archivo) && file_exists($ruta_archivo)) {
                unlink($ruta_archivo);
            }
        }
    }

    // Eliminar el registro de la base de datos (Cascade borrará las filas de galería)
    $sql = "DELETE FROM apartamentos WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Apartamento eliminado exitosamente."); window.location = "apartamentos.php";</script>';
    } else {
        echo '<script>alert("Error al eliminar: ' . $conn->error . '"); window.location = "apartamentos.php";</script>';
    }
} else {
    header("Location: apartamentos.php");
}
?>