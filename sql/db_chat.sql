-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2023 at 04:42 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_chat`
--
CREATE DATABASE db_chat;
USE db_chat;
-- --------------------------------------------------------

--
-- Table structure for table `amistades`
--

CREATE TABLE `amistades` (
  `friendship_id` int(11) NOT NULL,
  `user_id_1` int(11) NOT NULL,
  `user_id_2` int(11) NOT NULL,
  `estado_solicitud` enum('pendiente','aceptada') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amistades`
--

INSERT INTO `amistades` (`friendship_id`, `user_id_1`, `user_id_2`, `estado_solicitud`) VALUES
(11, 36, 37, 'aceptada'),
(12, 37, 38, 'pendiente'),
(13, 38, 39, 'aceptada'),
(14, 37, 40, 'pendiente'),
(15, 37, 36, 'aceptada'),
(18, 36, 38, 'pendiente'),
(19, 38, 36, 'pendiente'),
(22, 36, 40, 'aceptada'),
(23, 40, 36, 'aceptada'),
(24, 45, 36, 'aceptada'),
(25, 36, 45, 'aceptada'),
(26, 45, 39, 'aceptada'),
(27, 39, 45, 'aceptada');

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE `mensajes` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `contenido` varchar(250) NOT NULL,
  `fecha_envio` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`message_id`, `sender_id`, `receiver_id`, `contenido`, `fecha_envio`) VALUES
(13, 36, 37, 'Hola, ¿cómo estás?', '2023-11-08 12:00:00'),
(14, 37, 36, '¡Hola! Estoy bien, gracias.', '2023-11-08 12:05:00'),
(15, 37, 38, '¿Quieres ser mi amigo?', '2023-11-08 12:10:00'),
(16, 38, 39, 'Claro, me encantaría.', '2023-11-08 12:15:00'),
(21, 36, 37, 'Vale', '2023-11-08 18:34:41'),
(22, 37, 36, 'Vale, que?', '2023-11-11 13:27:35'),
(23, 36, 37, 'Mec', '2023-11-11 13:27:44'),
(24, 37, 36, 'Bistec', '2023-11-11 13:31:12'),
(25, 36, 38, 'pepa', '2023-11-13 15:10:48'),
(26, 36, 40, 'hola', '2023-11-13 16:25:13'),
(27, 40, 36, 'hola', '2023-11-13 16:25:22'),
(28, 36, 40, 'que tal?', '2023-11-13 16:25:29'),
(29, 40, 36, 'Mal', '2023-11-13 16:25:34'),
(30, 36, 40, 'Porque?', '2023-11-13 16:25:41'),
(31, 40, 36, 'Porque mec', '2023-11-13 16:25:49'),
(32, 36, 40, 'Que dices', '2023-11-13 16:26:00'),
(33, 40, 36, 'Bistec', '2023-11-13 16:26:10'),
(34, 45, 39, 'Hola Don Pepito', '2023-11-13 16:32:39'),
(35, 45, 39, 'Como estás?', '2023-11-13 16:32:54'),
(36, 45, 39, 'Te escribo, para saber que tal te va', '2023-11-13 16:33:04'),
(37, 39, 45, 'Hola Rubén', '2023-11-13 16:33:23'),
(38, 39, 45, 'Yo estoy bien y tú como estás?', '2023-11-13 16:33:43');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nombre_real` varchar(255) NOT NULL,
  `contraseña` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`user_id`, `username`, `nombre_real`, `contraseña`) VALUES
(36, 'oclemente', 'Olga Clemente', '$2y$10$0TnU7wn3LfO.CDCKCecaKeGj4mr8AW5NwBQ2TGZXr527yo0IccVgC'),
(37, 'pgrillo', 'Pepito Grillo', '$2y$10$jSMCM7X5zgyz3MoT4GspiurNXwaOTYFHl1H6HBCIi5YwNPK1gONNa'),
(38, 'ppig', 'Pepa Pig', '$2y$10$fFWgXxDKlkfDnMXwKFjBJenB1du3Gk3b2d7cVNdlnDPnkhPT3pQmq'),
(39, 'dpepito', 'Don Pepito', '$2y$10$nqVnOos7pvv2dLUidSlR5OsnnNnsqzISslMPg4uSUTSBfpr7eveo2'),
(40, 'fsystem', 'File System', '$2y$10$AQGrX3jwp3QC/FA3FizPD.O0822nX5NjABcch7.SW3gAFcQc0EWI.'),
(41, 'cmolina', 'Carla Molina', '$2y$10$3HlkhE.Y5W/jBr5/fn7ciuSDaRS95qdWyaJLMAHMxyl2tuqfKnmna'),
(42, 'llusuardi', 'Lucas Lusuardi', '$2y$10$ZCCw1e8vot4DqSio4A3Qi.TkfszX3DfDwH3vBdgKO2/qxlmL4ikci'),
(43, 'mbalada', 'María Balada', '$2y$10$btr810Q/Hlsau9DIwoT7.Ocmo8GO43GQym2LIseeGe9QurNZZoq8a'),
(44, 'pguapo', 'Pepe Guapo', '$2y$10$ds1tib51tzgmSwpwmAjdZ.vb2Mjjz2pJeDmppQwT0TzeY/4gKFcXC'),
(45, 'rcasillas', 'Rubén Casillas', '$2y$10$YXnOCiv1dDZ2lzbkMamF.O9P/2sN8FdZrH7iUr8Y6Mi0onKnxoew6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amistades`
--
ALTER TABLE `amistades`
  ADD PRIMARY KEY (`friendship_id`),
  ADD KEY `user_id_1` (`user_id_1`),
  ADD KEY `user_id_2` (`user_id_2`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amistades`
--
ALTER TABLE `amistades`
  MODIFY `friendship_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amistades`
--
ALTER TABLE `amistades`
  ADD CONSTRAINT `amistades_ibfk_1` FOREIGN KEY (`user_id_1`) REFERENCES `usuarios` (`user_id`),
  ADD CONSTRAINT `amistades_ibfk_2` FOREIGN KEY (`user_id_2`) REFERENCES `usuarios` (`user_id`);

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
  ADD CONSTRAINT `mensajes_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `usuarios` (`user_id`),
  ADD CONSTRAINT `mensajes_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `usuarios` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
