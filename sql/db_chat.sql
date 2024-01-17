-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema db_chat
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema db_chat
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `db_chat` DEFAULT CHARACTER SET utf8mb4 ;
USE `db_chat` ;

-- -----------------------------------------------------
-- Table `db_chat`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_chat`.`usuarios` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `nombre_real` VARCHAR(255) NOT NULL,
  `contraseña` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `username` (`username` ASC))
ENGINE = InnoDB
AUTO_INCREMENT = 47
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_chat`.`amistades`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_chat`.`amistades` (
  `friendship_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id_1` INT(11) NOT NULL,
  `user_id_2` INT(11) NOT NULL,
  `estado_solicitud` ENUM('pendiente','aceptada') NOT NULL,
  `enviadoPor` INT(11) NOT NULL,
  PRIMARY KEY (`friendship_id`),
  INDEX `user_id_1` (`user_id_1` ASC),
  INDEX `user_id_2` (`user_id_2` ASC),
  CONSTRAINT `amistades_ibfk_1`
    FOREIGN KEY (`user_id_1`)
    REFERENCES `db_chat`.`usuarios` (`user_id`),
  CONSTRAINT `amistades_ibfk_2`
    FOREIGN KEY (`user_id_2`)
    REFERENCES `db_chat`.`usuarios` (`user_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 196
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `db_chat`.`mensajes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `db_chat`.`mensajes` (
  `message_id` INT(11) NOT NULL AUTO_INCREMENT,
  `sender_id` INT(11) NOT NULL,
  `receiver_id` INT(11) NOT NULL,
  `contenido` VARCHAR(250) NOT NULL,
  `fecha_envio` DATETIME NOT NULL,
  PRIMARY KEY (`message_id`),
  INDEX `sender_id` (`sender_id` ASC),
  INDEX `receiver_id` (`receiver_id` ASC),
  CONSTRAINT `mensajes_ibfk_1`
    FOREIGN KEY (`sender_id`)
    REFERENCES `db_chat`.`usuarios` (`user_id`),
  CONSTRAINT `mensajes_ibfk_2`
    FOREIGN KEY (`receiver_id`)
    REFERENCES `db_chat`.`usuarios` (`user_id`))
ENGINE = InnoDB
AUTO_INCREMENT = 46
DEFAULT CHARACTER SET = utf8mb4;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
