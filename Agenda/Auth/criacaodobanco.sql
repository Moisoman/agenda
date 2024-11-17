-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Agenda
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Agenda` DEFAULT CHARACTER SET utf8 ;
USE `Agenda`;  -- Use the correct schema

-- -----------------------------------------------------
-- Table `CONSULTA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CONSULTA` (
  `id_consulta` INT NOT NULL auto_increment,
  `dt_consulta` DATE NULL,
  `id_paciente` INT NOT NULL,
  PRIMARY KEY (`id_consulta`),
  INDEX `fk_CONSULTA_PACIENTE1_idx` (`id_paciente`),
  CONSTRAINT `fk_CONSULTA_PACIENTE1`
    FOREIGN KEY (`id_paciente`)
    REFERENCES `Usuario` (`id_paciente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

-- -----------------------------------------------------
-- Table `PROFISSIONAL`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `PROFISSIONAL` (
  `id_profissional` INT NOT NULL auto_increment,
  `nm_profissional` VARCHAR(45) NULL,
  `cro` VARCHAR(20) NULL,
  `id_consulta` INT NOT NULL,
  PRIMARY KEY (`id_profissional`, `id_consulta`),
  INDEX `fk_PROFISSIONAL_CONSULTA1_idx` (`id_consulta`),
  CONSTRAINT `fk_PROFISSIONAL_CONSULTA1`
    FOREIGN KEY (`id_consulta`)
    REFERENCES `CONSULTA` (`id_consulta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

-- -----------------------------------------------------
-- Table `CLINICA`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CLINICA` (
  `id_clinica` INT NOT NULL auto_increment,
  `nm_clinica` VARCHAR(45) NULL,
  `id_profissional` INT,
  `PROFISSIONAL_CONSULTA_id_consulta` INT,
   cnpj varchar(14) not null,
   senha varchar(255) not null,
  PRIMARY KEY (`id_clinica`),
  INDEX `fk_CLINICA_PROFISSIONAL1_idx` (`id_profissional`, `PROFISSIONAL_CONSULTA_id_consulta`),
  CONSTRAINT `fk_CLINICA_PROFISSIONAL1`
    FOREIGN KEY (`id_profissional`, `PROFISSIONAL_CONSULTA_id_consulta`)
    REFERENCES `PROFISSIONAL` (`id_profissional`, `id_consulta`)
    
);

-- -----------------------------------------------------
-- Table `AGENDAMENTO`
-- -----------------------------------------------------
CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    clinica_id INT NOT NULL,
    data_hora DATETIME NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    ativo TINYINT(1) DEFAULT 0,  -- 0 means not confirmed, 1 means confirmed
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (clinica_id) REFERENCES CLINICA(id_clinica)
);


-- -----------------------------------------------------
-- Table `Usuario`
-- -----------------------------------------------------
CREATE TABLE `usuarios` (
  `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,  -- Unique constraint on email
  `senha` VARCHAR(255) NOT NULL
);

-- -----------------------------------------------------
-- Table `TRATAMENTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `TRATAMENTO` (
  `id_tratamento` INT NOT NULL auto_increment,
  `nm_tratamento` VARCHAR(45),
  PRIMARY KEY (`id_tratamento`)
);

-- -----------------------------------------------------
-- Table `CONSULTA_TRATAMENTO`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CONSULTA_TRATAMENTO` (
  `id_consulta` INT NOT NULL auto_increment,
  `id_tratamento` INT NOT NULL,
  PRIMARY KEY (`id_consulta`, `id_tratamento`),
  INDEX `fk_CONSULTA_has_TRATAMENTO_TRATAMENTO1_idx` (`id_tratamento`),
  INDEX `fk_CONSULTA_has_TRATAMENTO_CONSULTA_idx` (`id_consulta`),
  CONSTRAINT `fk_CONSULTA_has_TRATAMENTO_CONSULTA`
    FOREIGN KEY (`id_consulta`)
    REFERENCES `CONSULTA` (`id_consulta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CONSULTA_has_TRATAMENTO_TRATAMENTO1`
    FOREIGN KEY (`id_tratamento`)
    REFERENCES `TRATAMENTO` (`id_tratamento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE telefone (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,  -- Assuming you have a users table and this references it
    numero VARCHAR(15) NOT NULL,
    
    CONSTRAINT FK_user_id FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
 
  -- drop database agenda;