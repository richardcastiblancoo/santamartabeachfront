<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado."); window.location = "../../auth/login.php";</script>';
    exit;
}

include '../../auth/conexion_be.php';

// Función para crear slug
function crearSlug($texto) {
    // Reemplazar caracteres especiales latinos
    $texto = trim($texto);
    $texto = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $texto
    );
    $texto = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $texto
    );
    $texto = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $texto
    );
    $texto = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $texto
    );
    $texto = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $texto
    );
    $texto = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C'),
        $texto
    );
    
    // Convertir a minúsculas
    $texto = strtolower($texto);
    
    // Reemplazar cualquier cosa que no sea letras, números o espacios
    $texto = preg_replace('/[^a-z0-9\s-]/', '', $texto);
    
    // Reemplazar espacios y guiones múltiples por un solo guion
    $texto = preg_replace('/[\s-]+/', '-', $texto);
    
    return $texto;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : null;
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $banos = $_POST['banos'];
    $capacidad = $_POST['capacidad'];
    $cama = isset($_POST['cama']) ? $_POST['cama'] : 0;
    
    // Generar slug
    $slug = crearSlug($titulo);
    
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

    // Procesamiento del PDF
    $nombre_pdf = null;
    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $pdf_file = $_FILES['pdf'];
        $nombre_temp_pdf = time() . '_doc_' . $pdf_file['name'];
        $dir_pdf = '../../assets/pdf/';
        if (!file_exists($dir_pdf)) {
            mkdir($dir_pdf, 0777, true);
        }
        $ruta_temp_pdf = $dir_pdf . $nombre_temp_pdf;
        $tipo_pdf = strtolower(pathinfo($ruta_temp_pdf, PATHINFO_EXTENSION));

        if ($tipo_pdf == 'pdf') {
            if (move_uploaded_file($pdf_file['tmp_name'], $ruta_temp_pdf)) {
                $nombre_pdf = $nombre_temp_pdf;
            }
        } else {
             echo '<script>alert("Solo se permiten archivos PDF."); window.location = "apartamentos.php";</script>';
             exit;
        }
    }

    $apartamento_id = $id;

    if ($id) {
        // UPDATE
        // Nota: Solo actualizamos el slug si está vacío para no romper enlaces antiguos, 
        // o si queremos que se actualice siempre, lo agregamos. 
        // En este caso, lo actualizaremos para mantener coherencia con el título.
        
        $sql_base = "UPDATE apartamentos SET titulo=?, slug=?, descripcion=?, precio=?, ubicacion=?, habitaciones=?, banos=?, capacidad=?, cama=?, servicios=?";
        $types = "sssdsiisss";
        $params = [$titulo, $slug, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $cama, $servicios];

        if ($nombre_imagen) {
            $sql_base .= ", imagen_principal=?";
            $types .= "s";
            $params[] = $nombre_imagen;
        }
        
        if ($nombre_pdf) {
            $sql_base .= ", pdf=?";
            $types .= "s";
            $params[] = $nombre_pdf;
        }
        
        $sql_base .= " WHERE id=?";
        $types .= "i";
        $params[] = $id;

        $stmt = $conn->prepare($sql_base);
        $stmt->bind_param($types, ...$params);

        $mensaje_exito = "Apartamento actualizado exitosamente.";
        $mensaje_error = "Error al actualizar el apartamento.";
    } else {
        // INSERT
        if (!$nombre_imagen) {
            echo '<script>alert("Por favor selecciona una imagen principal para el nuevo apartamento."); window.location = "apartamentos.php";</script>';
            exit;
        }
        $stmt = $conn->prepare("INSERT INTO apartamentos (titulo, slug, descripcion, precio, ubicacion, habitaciones, banos, capacidad, cama, imagen_principal, servicios, pdf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdsiisssss", $titulo, $slug, $descripcion, $precio, $ubicacion, $habitaciones, $banos, $capacidad, $cama, $nombre_imagen, $servicios, $nombre_pdf);
        
        $mensaje_exito = "Apartamento publicado exitosamente.";
        $mensaje_error = "Error al guardar en la base de datos.";
    }

    try {
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
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        // Capturar error de duplicado (código 1062)
        if ($conn->errno == 1062) {
             echo '<script>alert("Error: Ya existe un apartamento con ese título/slug. Por favor modifica el título."); window.history.back();</script>';
        } else {
             echo '<script>alert("Error: ' . $mensaje_error . ' Detalles: ' . $e->getMessage() . '"); window.location = "apartamentos.php";</script>';
        }
        if (isset($stmt)) $stmt->close();
    }

} else {
    header("Location: apartamentos.php");
}
?>
