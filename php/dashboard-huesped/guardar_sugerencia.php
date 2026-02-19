<?php
session_start();
// Ajusta esta ruta según donde tengas tu archivo de conexión
include '../../auth/conexion_be.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Validar sesión
    if (!isset($_SESSION['id'])) {
        echo '<script>alert("Error: No se identificó al usuario."); window.history.back();</script>';
        exit();
    }

    // 2. Recibir datos
    $usuario_id = $_SESSION['id']; // Asegúrate de que al loguear guardas $_SESSION['id']
    $mensaje = mysqli_real_escape_string($conn, $_POST['mensaje']);

    // 3. Insertar en BD
    if (!empty($mensaje)) {
        $query = "INSERT INTO sugerencias (usuario_id, mensaje) VALUES ('$usuario_id', '$mensaje')";
        
        if (mysqli_query($conn, $query)) {
            echo '<script>
                alert("¡Gracias! Tu sugerencia ha sido enviada al administrador.");
                window.location = "huesped.php"; // Regresa al perfil del huésped
            </script>';
        } else {
            echo "Error al guardar: " . mysqli_error($conn);
        }
    } else {
        echo '<script>alert("El mensaje no puede estar vacío."); window.history.back();</script>';
    }
}
?>