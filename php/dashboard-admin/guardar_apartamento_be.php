<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado."); window.location = "../../auth/login.php";</script>';
    exit;
}

include '../../auth/conexion_be.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : null;
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $banos = $_POST['banos'];
    $capacidad = $_POST['capacidad'];
    $video = isset($_POST['video']) ? $_POST['video'] : '';

    $nombre_imagen = null;
    $ruta_destino = null;

    // Procesamiento de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombre_temp = time() . '_' . $imagen['name'];
        $ruta_temp = '../../assets/img/apartamentos/' . $nombre_temp;
        $tipo_imagen = strtolower(pathinfo($ruta_temp, PATHINFO_EXTENSION));

        // Validar extensiones permitidas
        $extensiones_permitidas = array("jpg", "jpeg", "png", "gif", "webp");
        if (!in_array($tipo_imagen, $extensiones_permitidas)) {
            echo '<script>alert("Solo se permiten archivos JPG, JPEG, PNG, GIF y WEBP."); window.location = "apartamentos.php";</script>';
            exit;
        }

        if (move_uploaded_file($imagen['tmp_name'], $ruta_temp)) {
            $nombre_imagen = $nombre_temp;
        } else {
            echo '<script>alert("Error al subir la imagen."); window.location = "apartamentos.php";</script>';
            exit;
        }
    }

    if ($id) {
        // UPDATE
        if ($nombre_imagen) {
            // Actualizar con nueva imagen
            $stmt = $conn->prepare("UPDATE apartamentos SET titulo=?, descripcion=?, precio=?, ubicacion=?, habitaciones=?, banos=?, capacidad=?, video=?, imagen_principal=? WHERE id=?");
            $stmt->bind_param("ssdsiiissi", $titulo, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $video, $nombre_imagen, $id);
        } else {
            // Actualizar sin cambiar imagen
            $stmt = $conn->prepare("UPDATE apartamentos SET titulo=?, descripcion=?, precio=?, ubicacion=?, habitaciones=?, banos=?, capacidad=?, video=? WHERE id=?");
            $stmt->bind_param("ssdsiiisi", $titulo, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $video, $id);
        }
        $mensaje_exito = "Apartamento actualizado exitosamente.";
        $mensaje_error = "Error al actualizar el apartamento.";

    } else {
        // INSERT
        if (!$nombre_imagen) {
            echo '<script>alert("Por favor selecciona una imagen para el nuevo apartamento."); window.location = "apartamentos.php";</script>';
            exit;
        }
        $stmt = $conn->prepare("INSERT INTO apartamentos (titulo, descripcion, precio, ubicacion, habitaciones, banos, capacidad, imagen_principal, video) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsiiiss", $titulo, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $nombre_imagen, $video);
        
        $mensaje_exito = "Apartamento publicado exitosamente.";
        $mensaje_error = "Error al guardar en la base de datos.";
    }

    if ($stmt->execute()) {
        echo '<script>alert("' . $mensaje_exito . '"); window.location = "apartamentos.php";</script>';
    } else {
        echo '<script>alert("' . $mensaje_error . '"); window.location = "apartamentos.php";</script>';
    }
    $stmt->close();

} else {
    header("Location: apartamentos.php");
}
?>