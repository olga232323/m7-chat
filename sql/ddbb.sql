-- Crear la tabla de Usuarios
CREATE DATABASE db_chat DEFAULT CHARACTER SET utf8mb4;
USE db_chat;

CREATE TABLE Usuarios (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) UNIQUE NOT NULL,
    nombre_real VARCHAR(255) NOT NULL,
    contraseña VARCHAR(255) NOT NULL
);

-- Crear la tabla de Amistades
CREATE TABLE Amistades (
    friendship_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id_1 INT NOT NULL,
    user_id_2 INT NOT NULL,
    estado_solicitud ENUM('pendiente', 'aceptada') NOT NULL,
    FOREIGN KEY (user_id_1) REFERENCES Usuarios(user_id),
    FOREIGN KEY (user_id_2) REFERENCES Usuarios(user_id)
);

-- Crear la tabla de Mensajes
CREATE TABLE Mensajes (
    message_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    contenido VARCHAR(250) NOT NULL,
    fecha_envio DATETIME NOT NULL,
    FOREIGN KEY (sender_id) REFERENCES Usuarios(user_id),
    FOREIGN KEY (receiver_id) REFERENCES Usuarios(user_id)
);
