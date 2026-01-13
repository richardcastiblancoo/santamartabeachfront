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

    // Eliminar el registro de la base de datos
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