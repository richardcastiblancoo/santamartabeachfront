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
    rol VARCHAR(20) NOT NULL, -- 'Admin' o 'Huésped'
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- NOTA: El usuario administrador por defecto se crea automáticamente 
-- desde el archivo php/conexion_be.php con la contraseña encriptada correctamente.
-- Usuario (Login): admin
-- Email: admin@santamarta.com
-- Contraseña: 123456
