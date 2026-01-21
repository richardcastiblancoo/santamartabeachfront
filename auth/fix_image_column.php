<?php
include 'auth/conexion_be.php';

// Aumentar el tamaño de la columna imagen para soportar URLs largas de Google
try {
    $sql = "ALTER TABLE usuarios MODIFY COLUMN imagen VARCHAR(2048) DEFAULT NULL";
    if ($conn->query($sql) === TRUE) {
        echo "Columna 'imagen' actualizada correctamente a VARCHAR(2048).<br>";
    } else {
        echo "Error actualizando columna: " . $conn->error . "<br>";
    }
} catch (Exception $e) {
    echo "Excepción: " . $e->getMessage();
}

// También verificamos si el usuario actual tiene la imagen cortada y la intentamos arreglar si está en sesión
session_start();
if (isset($_SESSION['id'])) {
    echo "Sesión activa para usuario ID: " . $_SESSION['id'] . "<br>";
    // Si pudiéramos volver a pedir los datos a Google lo haríamos, pero aquí solo podemos preparar la DB.
    echo "Por favor, cierra sesión y vuelve a entrar con Google para actualizar tu foto.";
}
?>