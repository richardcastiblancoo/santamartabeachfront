<?php
include '../../auth/conexion_be.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $galeria = array();

    $sql = "SELECT id, tipo, ruta FROM galeria_apartamentos WHERE apartamento_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $galeria[] = $row;
    }

    echo json_encode($galeria);
}
?>