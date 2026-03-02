<?php
include '../../auth/conexion_be.php';

// Leer el JSON recibido
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (isset($data['orden']) && is_array($data['orden'])) {
    $orden = $data['orden'];
    
    // Preparar la consulta
    $sql = "UPDATE galeria_apartamentos SET orden = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $success = true;
        foreach ($orden as $item) {
            $id = intval($item['id']);
            $posicion = intval($item['posicion']);
            
            $stmt->bind_param("ii", $posicion, $id);
            if (!$stmt->execute()) {
                $success = false;
                break;
            }
        }
        
        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Orden actualizado correctamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el orden']);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
}
?>
