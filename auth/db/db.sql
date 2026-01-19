-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS santamarta_db;
USE santamarta_db;



-- Crear la tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    rol VARCHAR(20) NOT NULL, -- 'Admin' o 'Huésped'
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- Crear la tabla de galería de apartamentos
CREATE TABLE `galeria_apartamentos` (
  `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `apartamento_id` int(6) UNSIGNED NOT NULL,
  `tipo` enum('imagen','video') COLLATE utf8mb4_general_ci NOT NULL,
  `ruta` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `apartamento_id` (`apartamento_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Crear la tabla de apartamentos
CREATE TABLE IF NOT EXISTS apartamentos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    ubicacion VARCHAR(100) NOT NULL,
    habitaciones INT(3) NOT NULL,
    banos INT(3) NOT NULL,
    capacidad INT(3) NOT NULL,
    imagen_principal VARCHAR(255) NOT NULL,
    video VARCHAR(255) NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    servicios TEXT NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Crear la tabla de PQR (Peticiones, Quejas y Reclamos)
CREATE TABLE IF NOT EXISTS pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(6) UNSIGNED NULL, -- En tu imagen "Nulo" dice "Sí"
    asunto VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL DEFAULT 'Petición', -- Este faltaba
    mensaje TEXT NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Crear la tabla de Respuestas PQR
CREATE TABLE IF NOT EXISTS respuestas_pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pqr_id INT(6) UNSIGNED,
    admin_id INT(6) UNSIGNED, -- ID del administrador que responde
    mensaje TEXT NOT NULL,
    archivo VARCHAR(255) DEFAULT NULL, -- Ruta del archivo adjunto (imagen o PDF)
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pqr_id) REFERENCES pqr(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES usuarios(id) ON DELETE SET NULL
);


CREATE TABLE IF NOT EXISTS reservas (
    -- Identificadores y Relaciones
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(6) UNSIGNED NULL,
    apartamento_id INT(6) UNSIGNED NULL,

    -- Datos del Cliente Principal
    nombre_cliente VARCHAR(100) NULL,
    apellido_cliente VARCHAR(100) NULL,
    email_cliente VARCHAR(100) NULL,
    telefono_cliente VARCHAR(50) NULL,

    -- Detalles de la Estancia
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    
    -- Huéspedes
    adultos INT(11) DEFAULT 1,
    ninos INT(11) DEFAULT 0,
    bebes INT(11) DEFAULT 0,
    perro_guia TINYINT(1) DEFAULT 0, -- Usado para booleanos
    nombres_huespedes TEXT NULL,

    -- Información Financiera y Estado
    total DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente', 
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    -- Claves Foráneas (Asumiendo que las tablas existen)
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- NOTA: El usuario administrador por defecto se crea automáticamente 
-- desde el archivo php/conexion_be.php con la contraseña encriptada correctamente.
-- Usuario (Login): admin
-- Email: admin@santamarta.com
-- Contraseña: 123456
