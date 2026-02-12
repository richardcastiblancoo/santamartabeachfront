<?php
session_start();
include '../../auth/conexion_be.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!isset($_SESSION['id'])) {
        echo "No has iniciado sesión";
        exit();
    }

    $apartamento_id = intval($_POST['id_apartamento']);
    $usuario_id     = intval($_SESSION['id']);
    $calificacion   = intval($_POST['calificacion']);
    $comentario     = mysqli_real_escape_string($conn, $_POST['comentario']);

    if ($apartamento_id > 0 && $calificacion >= 1 && $calificacion <= 5) {
        
        $sql = "INSERT INTO resenas (apartamento_id, usuario_id, calificacion, comentario) 
                VALUES ('$apartamento_id', '$usuario_id', '$calificacion', '$comentario')";

        if ($conn->query($sql)) {
            echo "success"; // Mensaje clave para el JS
        } else {
            echo "Error en base de datos: " . $conn->error;
        }
    } else {
        echo "Datos inválidos";
    }
}
$conn->close();
?>