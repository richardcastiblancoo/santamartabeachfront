<?php
include __DIR__ . '/../../auth/conexion_be.php';

// Habilitar visualización de errores

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>Actualizando estructura de la base de datos...</h2>";

// 1. Añadir columna 'slug' a la tabla 'apartamentos'
try {
    $sql = "ALTER TABLE apartamentos ADD COLUMN slug VARCHAR(255) UNIQUE DEFAULT NULL AFTER titulo";
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green'>✅ Columna 'slug' añadida correctamente.</p>";
    } else {
        // Si ya existe, es un error esperado, continuamos
        if (strpos($conn->error, 'Duplicate column name') !== false) {
            echo "<p style='color:orange'>⚠️ La columna 'slug' ya existe.</p>";
        } else {
            echo "<p style='color:red'>❌ Error al añadir columna 'slug': " . $conn->error . "</p>";
        }
    }
} catch (Exception $e) {
    // Si la excepción es por columna duplicada, continuamos
    if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
        echo "<p style='color:orange'>⚠️ La columna 'slug' ya existe (Excepción capturada).</p>";
    } else {
        echo "<p style='color:red'>❌ Excepción al alterar tabla: " . $e->getMessage() . "</p>";
    }
}

// 2. Generar slugs para apartamentos existentes (siempre ejecutar esto)
echo "<p>Verificando slugs para apartamentos existentes...</p>";

$result = $conn->query("SELECT id, titulo FROM apartamentos WHERE slug IS NULL OR slug = ''");

if ($result && $result->num_rows > 0) {
    $count = 0;
    while($row = $result->fetch_assoc()) {
        $slug = crearSlug($row['titulo']);
        
        // Verificar duplicados
        $original_slug = $slug;
        $counter = 1;
        $check = true;
        
        while($check) {
            $check_sql = "SELECT id FROM apartamentos WHERE slug = '$slug' AND id != " . $row['id'];
            $check_res = $conn->query($check_sql);
            if ($check_res->num_rows > 0) {
                $slug = $original_slug . '-' . $counter;
                $counter++;
            } else {
                $check = false;
            }
        }
        
        $update = "UPDATE apartamentos SET slug = '$slug' WHERE id = " . $row['id'];
        if ($conn->query($update)) {
            $count++;
        }
    }
    echo "<p style='color:green'>✅ Se generaron $count slugs para apartamentos existentes.</p>";
} else {
    echo "<p>No hay apartamentos sin slug pendiente.</p>";
}

// Función auxiliar para crear slug (copiada de guardar_apartamento_be.php para este script)
function crearSlug($texto) {
    if (empty($texto)) return 'sin-titulo-' . time();
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
    $texto = strtolower($texto);
    $texto = preg_replace('/[^a-z0-9\s-]/', '', $texto);
    $texto = preg_replace('/[\s-]+/', '-', $texto);
    $texto = trim($texto, '-');
    if (empty($texto)) $texto = 'apartamento-' . time();
    return $texto;
}

echo "<br><a href='apartamentos.php'>Volver a Apartamentos</a>";
?>
