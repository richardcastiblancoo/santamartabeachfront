<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Admin' && $_SESSION['rol'] != 'admin')) {
    header("Location: ../../auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pqr_id = $_POST['pqr_id'];
    $mensaje = mysqli_real_escape_string($conn, $_POST['mensaje']);
    $estado = $_POST['estado'];
    $admin_id = $_SESSION['id'];
    
    // Procesar archivo adjunto (si existe)
    $archivo_path = null;
    if (isset($_FILES['adjunto']) && $_FILES['adjunto']['error'] == 0) {
        $archivo_nombre = $_FILES['adjunto']['name'];
        $archivo_temp = $_FILES['adjunto']['tmp_name'];
        $archivo_ext = strtolower(pathinfo($archivo_nombre, PATHINFO_EXTENSION));
        
        // Validar extensiones permitidas (pdf, jpg, jpeg, png)
        $allowed_ext = array('pdf', 'jpg', 'jpeg', 'png');
        
        if (in_array($archivo_ext, $allowed_ext)) {
            $nuevo_nombre = 'pqr_' . $pqr_id . '_' . time() . '.' . $archivo_ext;
            $destino = '../../assets/archivos/pqr/';
            
            if (!file_exists($destino)) {
                mkdir($destino, 0777, true);
            }
            
            if (move_uploaded_file($archivo_temp, $destino . $nuevo_nombre)) {
                $archivo_path = 'assets/archivos/pqr/' . $nuevo_nombre;
            } else {
                echo '<script>alert("Error al subir el archivo."); window.location = "pqr.php";</script>';
                exit();
            }
        } else {
            echo '<script>alert("Formato de archivo no permitido. Solo PDF, JPG, PNG."); window.location = "pqr.php";</script>';
            exit();
        }
    }

    // Insertar respuesta
    $sql_respuesta = "INSERT INTO respuestas_pqr (pqr_id, admin_id, mensaje, archivo) VALUES ('$pqr_id', '$admin_id', '$mensaje', " . ($archivo_path ? "'$archivo_path'" : "NULL") . ")";
    
    if (mysqli_query($conn, $sql_respuesta)) {
        // Actualizar estado de la PQR
        $sql_update = "UPDATE pqr SET estado = '$estado' WHERE id = '$pqr_id'";
        mysqli_query($conn, $sql_update);
        
        echo '<script>alert("Respuesta enviada correctamente."); window.location = "pqr.php";</script>';
    } else {
        echo '<script>alert("Error al enviar la respuesta: ' . mysqli_error($conn) . '"); window.location = "pqr.php";</script>';
    }
    
    mysqli_close($conn);
} else {
    header("Location: pqr.php");
    exit();
}
?>
