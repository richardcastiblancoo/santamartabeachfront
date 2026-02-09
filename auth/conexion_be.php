<?php
require_once __DIR__ . '/env_loader.php';

$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASS') ?: "";
$dbname = getenv('DB_NAME') ?: "santamarta_db";

// Crear conexión
$conn = new mysqli($servername, $username, $password);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // echo "Base de datos creada exitosamente o ya existe";
} else {
    echo "Error creando base de datos: " . $conn->error;
}

// Seleccionar la base de datos
$conn->select_db($dbname);

// Crear tabla de usuarios si no existe
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    rol VARCHAR(20) NOT NULL,
    token VARCHAR(100) DEFAULT NULL,
    google_id VARCHAR(255) DEFAULT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creando tabla usuarios: " . $conn->error;
}

// Crear tabla de apartamentos si no existe
$sql_apartamentos = "CREATE TABLE IF NOT EXISTS apartamentos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    habitaciones INT(3) NOT NULL,
    banos INT(3) NOT NULL,
    capacidad INT(3) NOT NULL,
    imagen_principal VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_apartamentos) !== TRUE) {
    echo "Error creando tabla apartamentos: " . $conn->error;
}

// Intentar añadir la columna 'video' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE apartamentos ADD COLUMN video VARCHAR(255) DEFAULT NULL AFTER imagen_principal");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Crear tabla de reseñas si no existe
$sql_resenas = "CREATE TABLE IF NOT EXISTS resenas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    usuario_id INT(6) UNSIGNED NOT NULL,
    calificacion INT(1) NOT NULL,
    comentario TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)";

if ($conn->query($sql_resenas) !== TRUE) {
    echo "Error creando tabla resenas: " . $conn->error;
}

// Crear tabla de galería multimedia (fotos y videos adicionales)
$sql_galeria = "CREATE TABLE IF NOT EXISTS galeria_apartamentos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    tipo ENUM('imagen', 'video') NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
)";

if ($conn->query($sql_galeria) !== TRUE) {
    echo "Error creando tabla galeria_apartamentos: " . $conn->error;
}

// Intentar añadir la columna 'usuario' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE usuarios ADD COLUMN usuario VARCHAR(50) NOT NULL UNIQUE AFTER apellido");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Intentar añadir la columna 'imagen' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE usuarios ADD COLUMN imagen VARCHAR(255) DEFAULT NULL AFTER password");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Intentar añadir la columna 'tema' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE usuarios ADD COLUMN tema VARCHAR(20) DEFAULT '#13a4ec' AFTER imagen");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Intentar añadir la columna 'token' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE usuarios ADD COLUMN token VARCHAR(100) DEFAULT NULL AFTER rol");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Intentar añadir la columna 'google_id' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE usuarios ADD COLUMN google_id VARCHAR(255) DEFAULT NULL AFTER token");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Intentar añadir la columna 'is_verified' si la tabla ya existía sin ella
try {
    $conn->query("ALTER TABLE usuarios ADD COLUMN is_verified TINYINT(1) DEFAULT 0 AFTER token");
} catch (Exception $e) {
    // Ignorar error si la columna ya existe
}

// Verificar si existe el usuario admin por defecto
$usuario_admin = "admin";
$email_admin = "admin@santamarta.com";
$check_admin = "SELECT * FROM usuarios WHERE usuario = '$usuario_admin' OR email = '$email_admin'";
$result = $conn->query($check_admin);

if ($result->num_rows == 0) {
    // Crear usuario admin por defecto
    $password_admin = password_hash("123456", PASSWORD_DEFAULT);
    $sql_admin = "INSERT INTO usuarios (nombre, apellido, usuario, email, password, rol)
    VALUES ('Carlos', 'Admin', '$usuario_admin', '$email_admin', '$password_admin', 'Admin')";

    if ($conn->query($sql_admin) !== TRUE) {
        echo "Error creando usuario admin: " . $conn->error;
    }
} else {
    // Si el admin existe pero no tiene usuario (caso migración), actualizarlo
    $row = $result->fetch_assoc();
    if (empty($row['usuario'])) {
        $id_admin = $row['id'];
        $conn->query("UPDATE usuarios SET usuario = 'admin' WHERE id = $id_admin");
    }
}

// Crear tabla de PQR si no existe
$sql_pqr = "CREATE TABLE IF NOT EXISTS pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(6) UNSIGNED,
    asunto VARCHAR(100) NOT NULL,
    mensaje TEXT NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
)";

if ($conn->query($sql_pqr) !== TRUE) {
    echo "Error creando tabla pqr: " . $conn->error;
}

// Crear tabla de reservas si no existe
$sql_reservas = "CREATE TABLE IF NOT EXISTS reservas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(6) UNSIGNED,
    apartamento_id INT(6) UNSIGNED,
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
)";

if ($conn->query($sql_reservas) !== TRUE) {
    echo "Error creando tabla reservas: " . $conn->error;
}

// Intentar añadir columnas a 'reservas' si la tabla ya existía sin ellas
try {
    $conn->query("ALTER TABLE reservas ADD COLUMN fecha_inicio DATE NOT NULL AFTER apartamento_id");
} catch (Exception $e) {}

// Intentar añadir apartamento_id si falta
try {
    $check_column = $conn->query("SHOW COLUMNS FROM reservas LIKE 'apartamento_id'");
    if ($check_column->num_rows == 0) {
        $conn->query("ALTER TABLE reservas ADD COLUMN apartamento_id INT(6) UNSIGNED AFTER usuario_id");
        $conn->query("ALTER TABLE reservas ADD CONSTRAINT fk_apartamento_id FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE");
    }
} catch (Exception $e) {}

try {
    $conn->query("ALTER TABLE reservas ADD COLUMN fecha_fin DATE NOT NULL AFTER fecha_inicio");
} catch (Exception $e) {}

try {
    $conn->query("ALTER TABLE reservas ADD COLUMN total DECIMAL(10, 2) NOT NULL AFTER fecha_fin");
} catch (Exception $e) {}

try {
    $conn->query("ALTER TABLE reservas ADD COLUMN estado VARCHAR(20) DEFAULT 'Pendiente' AFTER total");
} catch (Exception $e) {}

// Add usuario_id column to reservas table if it doesn't exist
try {
    $check_column = $conn->query("SHOW COLUMNS FROM reservas LIKE 'usuario_id'");
    if ($check_column->num_rows == 0) {
        $conn->query("ALTER TABLE reservas ADD COLUMN usuario_id INT(6) UNSIGNED AFTER id");
        $conn->query("ALTER TABLE reservas ADD CONSTRAINT fk_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE");
    }
} catch (Exception $e) {
    // Ignore error if column or foreign key already exists
}

/*
// Insertar datos de prueba en reservas si está vacía
$check_reservas = "SELECT count(*) as count FROM reservas";
$result_reservas = $conn->query($check_reservas);
if ($result_reservas) {
    $row_res = $result_reservas->fetch_assoc();
    if ($row_res['count'] == 0) {
        // Obtener IDs válidos
        $user_res = $conn->query("SELECT id FROM usuarios LIMIT 1");
        $apt_res = $conn->query("SELECT id FROM apartamentos LIMIT 1");
        
        if ($user_res->num_rows > 0 && $apt_res->num_rows > 0) {
            $uid = $user_res->fetch_assoc()['id'];
            $aid = $apt_res->fetch_assoc()['id'];
            
            $insert_reservas = "INSERT INTO reservas (usuario_id, apartamento_id, fecha_inicio, fecha_fin, total, estado) VALUES 
            ($uid, $aid, DATE_ADD(CURDATE(), INTERVAL 5 DAY), DATE_ADD(CURDATE(), INTERVAL 10 DAY), 1250.00, 'Confirmada'),
            ($uid, $aid, DATE_ADD(CURDATE(), INTERVAL 12 DAY), DATE_ADD(CURDATE(), INTERVAL 15 DAY), 2100.00, 'Pendiente'),
            ($uid, $aid, DATE_ADD(CURDATE(), INTERVAL -5 DAY), DATE_ADD(CURDATE(), INTERVAL -1 DAY), 650.00, 'Completada')";
            
            $conn->query($insert_reservas);
        }
    }
}
*/
?>
