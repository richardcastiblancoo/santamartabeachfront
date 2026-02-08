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

CREATE DATABASE IF NOT EXISTS santamarta_db;
USE santamarta_db;

-- 1. Tabla de Apartamentos
CREATE TABLE apartamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL, -- Precio por noche
    imagen_principal VARCHAR(255),
    capacidad_max INT DEFAULT 4,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabla de Reseñas (Para el promedio de estrellas)
CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    comentario TEXT,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
);

-- 3. Tabla de Reservas (Donde se guardará el formulario)
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT NOT NULL,
    nombre_cliente VARCHAR(100) NOT NULL,
    apellido_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    huespedes_nombres TEXT,            -- Nombres de todos los acompañantes
    documento_ruta VARCHAR(255),       -- Ruta de la foto de la cédula/pasaporte
    cuenta_devolucion VARCHAR(255),    -- Información bancaria para el depósito
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    bebes INT DEFAULT 0,
    perro_guia BOOLEAN DEFAULT FALSE,
    precio_total DECIMAL(12, 2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE reservas MODIFY COLUMN estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente';

-- 1. Asegúrate de que la tabla de apartamentos exista y use INT UNSIGNED para el ID
CREATE TABLE IF NOT EXISTS apartamentos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    precio DECIMAL(12, 2) NOT NULL,
    imagen_principal VARCHAR(255),
    -- ... otros campos que ya tengas
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabla de Reservas corregida
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT UNSIGNED NOT NULL, -- Debe ser igual al ID de apartamentos
    nombre_cliente VARCHAR(100) NOT NULL,
    apellido_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    huespedes_nombres TEXT,            -- Nombres de todos los acompañantes
    documento_ruta VARCHAR(255),       -- Ruta de la foto de la cédula/pasaporte
    cuenta_devolucion VARCHAR(255),    -- Información bancaria para el depósito
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    bebes INT DEFAULT 0,
    perro_guia BOOLEAN DEFAULT FALSE,
    precio_total DECIMAL(12, 2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_apto 
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- notificacion
ALTER TABLE reservas ADD COLUMN notificacion_vista BOOLEAN DEFAULT FALSE;


CREATE TABLE IF NOT EXISTS push_subscriptions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL, -- Corregido para que coincida con usuarios.id
    endpoint TEXT NOT NULL,
    p256dh VARCHAR(255) NOT NULL,
    auth VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);










-- server hostinger ---------------------

-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS u135528686_santamarta_db;
USE u135528686_santamarta_db;



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

CREATE DATABASE IF NOT EXISTS u135528686_santamarta_db;
USE u135528686_santamarta_db;

-- 1. Tabla de Apartamentos
CREATE TABLE apartamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL, -- Precio por noche
    imagen_principal VARCHAR(255),
    capacidad_max INT DEFAULT 4,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. Tabla de Reseñas (Para el promedio de estrellas)
CREATE TABLE resenas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT,
    calificacion INT CHECK (calificacion BETWEEN 1 AND 5),
    comentario TEXT,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
);

-- 3. Tabla de Reservas (Donde se guardará el formulario)
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT NOT NULL,
    nombre_cliente VARCHAR(100) NOT NULL,
    apellido_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    huespedes_nombres TEXT,            -- Nombres de todos los acompañantes
    documento_ruta VARCHAR(255),       -- Ruta de la foto de la cédula/pasaporte
    cuenta_devolucion VARCHAR(255),    -- Información bancaria para el depósito
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    bebes INT DEFAULT 0,
    perro_guia BOOLEAN DEFAULT FALSE,
    precio_total DECIMAL(12, 2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE reservas MODIFY COLUMN estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente';

-- 1. Asegúrate de que la tabla de apartamentos exista y use INT UNSIGNED para el ID
CREATE TABLE IF NOT EXISTS apartamentos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    precio DECIMAL(12, 2) NOT NULL,
    imagen_principal VARCHAR(255),
    -- ... otros campos que ya tengas
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. Tabla de Reservas corregida
CREATE TABLE IF NOT EXISTS reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    apartamento_id INT UNSIGNED NOT NULL, -- Debe ser igual al ID de apartamentos
    nombre_cliente VARCHAR(100) NOT NULL,
    apellido_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    huespedes_nombres TEXT,            -- Nombres de todos los acompañantes
    documento_ruta VARCHAR(255),       -- Ruta de la foto de la cédula/pasaporte
    cuenta_devolucion VARCHAR(255),    -- Información bancaria para el depósito
    fecha_checkin DATE NOT NULL,
    fecha_checkout DATE NOT NULL,
    adultos INT DEFAULT 1,
    ninos INT DEFAULT 0,
    bebes INT DEFAULT 0,
    perro_guia BOOLEAN DEFAULT FALSE,
    precio_total DECIMAL(12, 2) NOT NULL,
    estado ENUM('pendiente', 'confirmada', 'cancelada', 'finalizada') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reserva_apto 
    FOREIGN KEY (apartamento_id) REFERENCES apartamentos(id) 
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- notificacion
ALTER TABLE reservas ADD COLUMN notificacion_vista BOOLEAN DEFAULT FALSE;


CREATE TABLE IF NOT EXISTS push_subscriptions (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL, -- Corregido para que coincida con usuarios.id
    endpoint TEXT NOT NULL,
    p256dh VARCHAR(255) NOT NULL,
    auth VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);