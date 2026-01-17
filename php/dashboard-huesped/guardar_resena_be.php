<?php
session_start();
include '../../auth/conexion_be.php';

if (!isset($_SESSION['usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['id'];
    $apartamento_id = $_POST['apartamento_id'];
    $calificacion = $_POST['calificacion'];
    $comentario = $_POST['comentario'];

    // Validar datos
    if (empty($apartamento_id) || empty($calificacion)) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
        exit();
    }

    // Verificar si el usuario ya ha reseñado este apartamento (opcional, pero recomendado)
    // Por ahora permitiremos múltiples reseñas por diferentes estancias, o simplificamos a una por usuario/apto.
    // Vamos a permitir insertar directamente.

    $sql = "INSERT INTO resenas (apartamento_id, usuario_id, calificacion, comentario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $apartamento_id, $usuario_id, $calificacion, $comentario);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reseña guardada correctamente']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la reseña: ' . $conn->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>