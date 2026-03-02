<?php
// Habilitar visualización de errores para depuración (solo temporal)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Admin') {
    echo '<script>alert("Acceso denegado."); window.location = "../../auth/login.php";</script>';
    exit;
}

include '../../auth/conexion_be.php';

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Función para crear slug MEJORADA
function crearSlug($texto) {
    if (empty($texto)) {
        return 'sin-titulo-' . time();
    }
    
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
    
    // Eliminar guiones al inicio y final
    $texto = trim($texto, '-');
    
    // Si después de todo esto el slug está vacío, poner uno por defecto
    if (empty($texto)) {
        $texto = 'apartamento-' . time();
    }
    
    return $texto;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar campos requeridos
    $errores = [];
    
    $id = isset($_POST['id']) && !empty($_POST['id']) ? intval($_POST['id']) : null;
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
    $precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
    $ubicacion = isset($_POST['ubicacion']) ? trim($_POST['ubicacion']) : '';
    $habitaciones = isset($_POST['habitaciones']) ? intval($_POST['habitaciones']) : 0;
    $banos = isset($_POST['banos']) ? intval($_POST['banos']) : 0;
    $capacidad = isset($_POST['capacidad']) ? intval($_POST['capacidad']) : 0;
    $cama = isset($_POST['cama']) ? intval($_POST['cama']) : 0;
    
    // Validaciones básicas
    if (empty($titulo)) $errores[] = "El título es obligatorio";
    if (empty($descripcion)) $errores[] = "La descripción es obligatoria";
    if ($precio <= 0) $errores[] = "El precio debe ser mayor a 0";
    if (empty($ubicacion)) $errores[] = "La ubicación es obligatoria";
    if ($habitaciones <= 0) $errores[] = "El número de habitaciones debe ser mayor a 0";
    if ($banos <= 0) $errores[] = "El número de baños debe ser mayor a 0";
    if ($capacidad <= 0) $errores[] = "La capacidad debe ser mayor a 0";
    
    if (!empty($errores)) {
        $mensaje_error = implode("\\n", $errores);
        echo '<script>alert("' . $mensaje_error . '"); window.history.back();</script>';
        exit;
    }
    
    // Generar slug
    $slug = crearSlug($titulo);
    
    // Para evitar slugs duplicados, podemos agregar un sufijo si es necesario
    if (!$id) { // Solo para nuevos apartamentos
        $check_sql = "SELECT id FROM apartamentos WHERE slug = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $slug);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        $counter = 1;
        $original_slug = $slug;
        while ($check_result->num_rows > 0) {
            $slug = $original_slug . '-' . $counter;
            $check_stmt->bind_param("s", $slug);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $counter++;
        }
        $check_stmt->close();
    }
    
    // Procesar servicios (convertir array a JSON)
    $servicios = isset($_POST['servicios']) && is_array($_POST['servicios']) ? 
                 json_encode($_POST['servicios'], JSON_UNESCAPED_UNICODE) : null;

    $nombre_imagen = null;
    $imagen_anterior = null;

    // Si es actualización, obtener la imagen anterior
    if ($id) {
        $img_query = $conn->prepare("SELECT imagen_principal FROM apartamentos WHERE id = ?");
        $img_query->bind_param("i", $id);
        $img_query->execute();
        $img_result = $img_query->get_result();
        if ($img_row = $img_result->fetch_assoc()) {
            $imagen_anterior = $img_row['imagen_principal'];
        }
        $img_query->close();
    }

    // Procesamiento de la imagen principal
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
        $imagen = $_FILES['imagen'];
        $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));
        $nombre_temp = time() . '_main_' . uniqid() . '.' . $extension;
        $ruta_temp = '../../assets/img/apartamentos/' . $nombre_temp;

        $extensiones_permitidas = array("jpg", "jpeg", "png", "gif", "webp");
        if (!in_array($extension, $extensiones_permitidas)) {
            echo '<script>alert("Solo se permiten archivos JPG, JPEG, PNG, GIF y WEBP para la imagen principal."); window.history.back();</script>';
            exit;
        }

        // Crear directorio si no existe
        $dir_imagenes = '../../assets/img/apartamentos/';
        if (!file_exists($dir_imagenes)) {
            mkdir($dir_imagenes, 0777, true);
        }

        if (move_uploaded_file($imagen['tmp_name'], $ruta_temp)) {
            $nombre_imagen = $nombre_temp;
            
            // Eliminar imagen anterior si existe y es diferente
            if ($id && $imagen_anterior && file_exists($dir_imagenes . $imagen_anterior)) {
                unlink($dir_imagenes . $imagen_anterior);
            }
        } else {
            echo '<script>alert("Error al subir la imagen principal."); window.history.back();</script>';
            exit;
        }
    }

    // Procesamiento del PDF
    $nombre_pdf = null;
    $pdf_anterior = null;

    // Si es actualización, obtener el PDF anterior
    if ($id) {
        $pdf_query = $conn->prepare("SELECT pdf FROM apartamentos WHERE id = ?");
        $pdf_query->bind_param("i", $id);
        $pdf_query->execute();
        $pdf_result = $pdf_query->get_result();
        if ($pdf_row = $pdf_result->fetch_assoc()) {
            $pdf_anterior = $pdf_row['pdf'];
        }
        $pdf_query->close();
    }

    if (isset($_FILES['pdf']) && $_FILES['pdf']['error'] == 0) {
        $pdf_file = $_FILES['pdf'];
        $extension_pdf = strtolower(pathinfo($pdf_file['name'], PATHINFO_EXTENSION));
        $nombre_temp_pdf = time() . '_doc_' . uniqid() . '.pdf';
        $dir_pdf = '../../assets/pdf/';
        
        if (!file_exists($dir_pdf)) {
            mkdir($dir_pdf, 0777, true);
        }
        
        $ruta_temp_pdf = $dir_pdf . $nombre_temp_pdf;

        if ($extension_pdf == 'pdf') {
            if (move_uploaded_file($pdf_file['tmp_name'], $ruta_temp_pdf)) {
                $nombre_pdf = $nombre_temp_pdf;
                
                // Eliminar PDF anterior si existe
                if ($id && $pdf_anterior && file_exists($dir_pdf . $pdf_anterior)) {
                    unlink($dir_pdf . $pdf_anterior);
                }
            }
        } else {
             echo '<script>alert("Solo se permiten archivos PDF."); window.history.back();</script>';
             exit;
        }
    }

    $apartamento_id = $id;

    if ($id) {
        // UPDATE - Corregido el orden de los tipos
        $sql_base = "UPDATE apartamentos SET titulo=?, slug=?, descripcion=?, precio=?, ubicacion=?, habitaciones=?, banos=?, capacidad=?, cama=?, servicios=?";
        $types = "sssdsiiiss"; // s=string, d=double, i=integer
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
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        
        $stmt->bind_param($types, ...$params);

        $mensaje_exito = "Apartamento actualizado exitosamente.";
        $mensaje_error = "Error al actualizar el apartamento.";
    } else {
        // INSERT - Para nuevo apartamento
        if (!$nombre_imagen) {
            echo '<script>alert("Por favor selecciona una imagen principal para el nuevo apartamento."); window.history.back();</script>';
            exit;
        }
        
        $sql = "INSERT INTO apartamentos (titulo, slug, descripcion, precio, ubicacion, habitaciones, banos, capacidad, cama, imagen_principal, servicios, pdf) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            die("Error en prepare: " . $conn->error);
        }
        
        $stmt->bind_param("sssdsiiissss", 
            $titulo, 
            $slug, 
            $descripcion, 
            $precio, 
            $ubicacion, 
            $habitaciones, 
            $banos, 
            $capacidad, 
            $cama, 
            $nombre_imagen, 
            $servicios, 
            $nombre_pdf
        );
        
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
            if (isset($_FILES['imagenes_galeria']) && is_array($_FILES['imagenes_galeria']['name'])) {
                $total_imagenes = count($_FILES['imagenes_galeria']['name']);
                for ($i = 0; $i < $total_imagenes; $i++) {
                    if ($_FILES['imagenes_galeria']['error'][$i] == 0) {
                        $tmp_name = $_FILES['imagenes_galeria']['tmp_name'][$i];
                        $extension = strtolower(pathinfo($_FILES['imagenes_galeria']['name'][$i], PATHINFO_EXTENSION));
                        $name = time() . '_gal_' . $i . '_' . uniqid() . '.' . $extension;
                        $dir_destino = '../../assets/img/apartamentos/';
                        $ruta_destino = $dir_destino . $name;
                        
                        if (in_array($extension, ["jpg", "jpeg", "png", "gif", "webp"])) {
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
            if (isset($_FILES['videos_galeria']) && is_array($_FILES['videos_galeria']['name'])) {
                $total_videos = count($_FILES['videos_galeria']['name']);
                for ($i = 0; $i < $total_videos; $i++) {
                    if ($_FILES['videos_galeria']['error'][$i] == 0) {
                        $tmp_name = $_FILES['videos_galeria']['tmp_name'][$i];
                        $extension = strtolower(pathinfo($_FILES['videos_galeria']['name'][$i], PATHINFO_EXTENSION));
                        $name = time() . '_vid_' . $i . '_' . uniqid() . '.' . $extension;
                        
                        $dir_destino = '../../assets/video/apartamentos/';
                        if (!file_exists($dir_destino)) {
                            mkdir($dir_destino, 0777, true);
                        }
                        
                        $ruta_destino = $dir_destino . $name;
                        
                        if (in_array($extension, ["mp4", "webm", "ogg"])) {
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
             echo '<script>alert("Error: Ya existe un apartamento con ese título. Por favor modifica el título."); window.history.back();</script>';
        } else {
             echo '<script>alert("Error: ' . $mensaje_error . '"); console.error("' . addslashes($e->getMessage()) . '"); window.history.back();</script>';
        }
        if (isset($stmt)) $stmt->close();
    }

} else {
    header("Location: apartamentos.php");
}
?>