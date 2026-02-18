-- 1. Configuración Inicial
CREATE DATABASE IF NOT EXISTS santamarta_db;
USE santamarta_db;

-- 2. Tabla de Usuarios
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabla de Apartamentos (Versión completa)
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
    servicios TEXT NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 1. Crear la columna
ALTER TABLE apartamentos ADD COLUMN slug VARCHAR(255) UNIQUE AFTER nombre;

-- 2. Llenar la columna para el ID 1 (Ejemplo)
UPDATE apartamentos SET slug = 'apartamento-beachfront-santa-marta' WHERE id = 1;

-- 4. Tabla de Galería
CREATE TABLE IF NOT EXISTS galeria_apartamentos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    tipo ENUM('imagen','video') NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    CONSTRAINT fk_galeria_apto FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabla de Reservas (Corregida con notificaciones)
CREATE TABLE IF NOT EXISTS reservas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    nombre_cliente VARCHAR(100) NOT NULL,
    apellido_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    huespedes_nombres TEXT,
    documento_ruta VARCHAR(255),
    cuenta_devolucion VARCHAR(255),
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    bebes INT DEFAULT 0,
    perro_guia BOOLEAN DEFAULT FALSE,
    precio_total DECIMAL(12, 2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente',
    notificacion_vista BOOLEAN DEFAULT FALSE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_apto FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabla de Reseñas
CREATE TABLE IF NOT EXISTS resenas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    usuario_id INT(6) UNSIGNED NOT NULL,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_resena_apto FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE,
    CONSTRAINT fk_resena_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Tabla de PQR
CREATE TABLE IF NOT EXISTS pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(6) UNSIGNED NULL,
    asunto VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL DEFAULT 'Petición',
    mensaje TEXT NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pqr_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 8. Tabla de Respuestas PQR
CREATE TABLE IF NOT EXISTS respuestas_pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pqr_id INT(6) UNSIGNED NOT NULL,
    admin_id INT(6) UNSIGNED NULL,
    mensaje TEXT NOT NULL,
    archivo VARCHAR(255) DEFAULT NULL,
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_resp_pqr FOREIGN KEY (pqr_id) REFERENCES pqr(id) ON DELETE CASCADE,
    CONSTRAINT fk_resp_admin FOREIGN KEY (admin_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE sugerencias (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL, -- Agregamos UNSIGNED para que coincida
    mensaje TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_sugerencia 
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;






-- server hostinger ---------------------

   -- 1. Configuración Inicial
CREATE DATABASE IF NOT EXISTS u135528686_santamarta_db;
USE u135528686_santamarta_db;

-- 2. Tabla de Usuarios
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabla de Apartamentos
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
    servicios TEXT NULL DEFAULT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabla de Galería (Relacionada con Apartamentos)
CREATE TABLE IF NOT EXISTS galeria_apartamentos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    tipo ENUM('imagen','video') NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    CONSTRAINT fk_galeria_apto FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabla de Reservas
CREATE TABLE IF NOT EXISTS reservas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    nombre_cliente VARCHAR(100) NOT NULL,
    apellido_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    huespedes_nombres TEXT,
    documento_ruta VARCHAR(255),
    cuenta_devolucion VARCHAR(255),
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    bebes INT DEFAULT 0,
    perro_guia BOOLEAN DEFAULT FALSE,
    precio_total DECIMAL(12, 2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente',
    notificacion_vista BOOLEAN DEFAULT FALSE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_apto FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabla de Reseñas
CREATE TABLE IF NOT EXISTS resenas (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT(6) UNSIGNED NOT NULL,
    usuario_id INT(6) UNSIGNED NOT NULL,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha_resena TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_resena_apto FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE,
    CONSTRAINT fk_resena_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabla de PQR
CREATE TABLE IF NOT EXISTS pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(6) UNSIGNED NULL,
    asunto VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL DEFAULT 'Petición',
    mensaje TEXT NOT NULL,
    estado VARCHAR(20) DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pqr_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabla de Respuestas PQR
CREATE TABLE IF NOT EXISTS respuestas_pqr (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    pqr_id INT(6) UNSIGNED NOT NULL,
    admin_id INT(6) UNSIGNED NULL,
    mensaje TEXT NOT NULL,
    archivo VARCHAR(255) DEFAULT NULL,
    fecha_respuesta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_resp_pqr FOREIGN KEY (pqr_id) REFERENCES pqr(id) ON DELETE CASCADE,
    CONSTRAINT fk_resp_admin FOREIGN KEY (admin_id) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 9. Tabla Push Subscriptions
CREATE TABLE IF NOT EXISTS push_subscriptions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    endpoint TEXT NOT NULL,
    p256dh VARCHAR(255) NOT NULL,
    auth VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_push_user FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;