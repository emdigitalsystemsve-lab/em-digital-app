CREATE DATABASE IF NOT EXISTS em_digital_systems DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE em_digital_systems;-- 1. Tabla de Usuarios Administradores
CREATE TABLE IF NOT EXISTS usuarios (
id INT AUTO_INCREMENT PRIMARY KEY,
usuario VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
nombre VARCHAR(100) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;-- Insertar usuario admin por defecto (Usuario: admin | Clave temporal: admin123)
INSERT INTO usuarios (usuario, password, nombre) VALUES
('admin', '$2y$10$e0MYzXyjpJS7Pd0RVvHwHe1e8eL1yK8/kX6mFp5O5u3dO9/S9.G2G', 'Administrador General')
ON DUPLICATE KEY UPDATE id=id;-- 2. Tabla de Configuración General (Teléfono, Redes, Correo)
CREATE TABLE IF NOT EXISTS configuracion (
id INT PRIMARY KEY DEFAULT 1,
telefono_whatsapp VARCHAR(20) NOT NULL,
email_contacto VARCHAR(100) NOT NULL,
instagram VARCHAR(100) DEFAULT NULL,
direccion_oficina TEXT DEFAULT NULL,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;-- Insertar configuración inicial
INSERT INTO configuracion (id, telefono_whatsapp, email_contacto, instagram, direccion_oficina) VALUES
(1, '+584120000000', 'contacto@emdigitalsystems.com', '@emdigitalsystems', 'Anzoátegui, Venezuela')
ON DUPLICATE KEY UPDATE id=1;-- 3. Tabla del Catálogo de Demos (Los 10 Demos)
CREATE TABLE IF NOT EXISTS demos (
id INT AUTO_INCREMENT PRIMARY KEY,
titulo VARCHAR(100) NOT NULL,
categoria VARCHAR(50) NOT NULL,
descripcion TEXT NOT NULL,
link_demo VARCHAR(255) NOT NULL,
imagen_preview VARCHAR(255) DEFAULT 'default_demo.jpg',
estado ENUM('activo', 'inactivo') DEFAULT 'activo',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;-- 4. Tabla de Planes y Precios
CREATE TABLE IF NOT EXISTS planes (
id INT AUTO_INCREMENT PRIMARY KEY,
nombre_plan VARCHAR(50) NOT NULL,
precio DECIMAL(10,2) NOT NULL,
caracteristicas TEXT NOT NULL,
destacado TINYINT(1) DEFAULT 0,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;