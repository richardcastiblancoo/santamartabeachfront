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
    
    // Procesar servicios (convertir array a JSON)
    $servicios = isset($_POST['servicios']) ? json_encode($_POST['servicios'], JSON_UNESCAPED_UNICODE) : null;

    $nombre_imagen = null;

    // Procesamiento de la imagen principal
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $nombre_temp = time() . '_main_' . $imagen['name'];
        $ruta_temp = '../../assets/img/apartamentos/' . $nombre_temp;
        $tipo_imagen = strtolower(pathinfo($ruta_temp, PATHINFO_EXTENSION));

        $extensiones_permitidas = array("jpg", "jpeg", "png", "gif", "webp");
        if (!in_array($tipo_imagen, $extensiones_permitidas)) {
            echo '<script>alert("Solo se permiten archivos JPG, JPEG, PNG, GIF y WEBP para la imagen principal."); window.location = "apartamentos.php";</script>';
            exit;
        }

        if (move_uploaded_file($imagen['tmp_name'], $ruta_temp)) {
            $nombre_imagen = $nombre_temp;
        } else {
            echo '<script>alert("Error al subir la imagen principal."); window.location = "apartamentos.php";</script>';
            exit;
        }
    }

    $apartamento_id = $id;

    if ($id) {
        // UPDATE
        if ($nombre_imagen) {
            $stmt = $conn->prepare("UPDATE apartamentos SET titulo=?, descripcion=?, precio=?, ubicacion=?, habitaciones=?, banos=?, capacidad=?, imagen_principal=?, servicios=? WHERE id=?");
            $stmt->bind_param("ssdsiiissi", $titulo, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $nombre_imagen, $servicios, $id);
        } else {
            $stmt = $conn->prepare("UPDATE apartamentos SET titulo=?, descripcion=?, precio=?, ubicacion=?, habitaciones=?, banos=?, capacidad=?, servicios=? WHERE id=?");
            $stmt->bind_param("ssdsiiisi", $titulo, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $servicios, $id);
        }
        $mensaje_exito = "Apartamento actualizado exitosamente.";
        $mensaje_error = "Error al actualizar el apartamento.";
    } else {
        // INSERT
        if (!$nombre_imagen) {
            echo '<script>alert("Por favor selecciona una imagen principal para el nuevo apartamento."); window.location = "apartamentos.php";</script>';
            exit;
        }
        $stmt = $conn->prepare("INSERT INTO apartamentos (titulo, descripcion, precio, ubicacion, habitaciones, banos, capacidad, imagen_principal, servicios) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsiiiss", $titulo, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $nombre_imagen, $servicios);
        
        $mensaje_exito = "Apartamento publicado exitosamente.";
        $mensaje_error = "Error al guardar en la base de datos.";
    }

    if ($stmt->execute()) {
        if (!$id) {
            $apartamento_id = $stmt->insert_id;
        }
        $stmt->close();

        // Procesar Galería de Imágenes
        if (isset($_FILES['imagenes_galeria'])) {
            $total_imagenes = count($_FILES['imagenes_galeria']['name']);
            for ($i = 0; $i < $total_imagenes; $i++) {
                if ($_FILES['imagenes_galeria']['error'][$i] == 0) {
                    $tmp_name = $_FILES['imagenes_galeria']['tmp_name'][$i];
                    $name = time() . '_gal_' . $i . '_' . $_FILES['imagenes_galeria']['name'][$i];
                    $ruta_destino = '../../assets/img/apartamentos/' . $name;
                    $tipo = strtolower(pathinfo($ruta_destino, PATHINFO_EXTENSION));
                    
                    if (in_array($tipo, ["jpg", "jpeg", "png", "gif", "webp"])) {
                        if (move_uploaded_file($tmp_name, $ruta_destino)) {
                            $sql_gal = "INSERT INTO galeria_apartamentos (apartamento_id, tipo, ruta) VALUES (?, 'imagen', ?)";
                            $stmt_gal = $conn->prepare($sql_gal);
                            $stmt_gal->bind_param("is", $apartamento_id, $name);
                            $stmt_gal->execute();
                            $stmt_gal->close();
                        }
                    }
                }
            }
        }

        // Procesar Galería de Videos
        if (isset($_FILES['videos_galeria'])) {
            $total_videos = count($_FILES['videos_galeria']['name']);
            for ($i = 0; $i < $total_videos; $i++) {
                if ($_FILES['videos_galeria']['error'][$i] == 0) {
                    $tmp_name = $_FILES['videos_galeria']['tmp_name'][$i];
                    $name = time() . '_vid_' . $i . '_' . $_FILES['videos_galeria']['name'][$i];
                    
                    $dir_destino = '../../assets/video/apartamentos/';
                    if (!file_exists($dir_destino)) {
                        mkdir($dir_destino, 0777, true);
                    }
                    
                    $ruta_destino = $dir_destino . $name;
                    $tipo = strtolower(pathinfo($ruta_destino, PATHINFO_EXTENSION));
                    
                    if (in_array($tipo, ["mp4", "webm", "ogg"])) {
                        if (move_uploaded_file($tmp_name, $ruta_destino)) {
                            $sql_gal = "INSERT INTO galeria_apartamentos (apartamento_id, tipo, ruta) VALUES (?, 'video', ?)";
                            $stmt_gal = $conn->prepare($sql_gal);
                            $stmt_gal->bind_param("is", $apartamento_id, $name);
                            $stmt_gal->execute();
                            $stmt_gal->close();
                        }
                    }
                }
            }
        }

        echo '<script>alert("' . $mensaje_exito . '"); window.location = "apartamentos.php";</script>';

    } else {
        echo '<script>alert("' . $mensaje_error . '"); window.location = "apartamentos.php";</script>';
        $stmt->close();
    }

} else {
    header("Location: apartamentos.php");
}
?>