<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

include '../../auth/conexion_be.php';

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Obtener ruta para eliminar archivo
    $sql = "SELECT tipo, ruta FROM galeria_apartamentos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ruta_archivo = '';
        
        if ($row['tipo'] == 'imagen') {
            $ruta_archivo = '../../assets/img/apartamentos/' . $row['ruta'];
        } else if ($row['tipo'] == 'video') {
            $ruta_archivo = '../../assets/video/apartamentos/' . $row['ruta'];
        }

        // Eliminar archivo físico
        if (file_exists($ruta_archivo)) {
            unlink($ruta_archivo);
        }

        // Eliminar registro DB
        $sql_del = "DELETE FROM galeria_apartamentos WHERE id = ?";
        $stmt_del = $conn->prepare($sql_del);
        $stmt_del->bind_param("i", $id);
        
        if ($stmt_del->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error DB']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Archivo no encontrado']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
}
?>