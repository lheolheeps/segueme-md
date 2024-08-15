-- MySQL Script generated by MySQL Workbench
-- 03/19/16 19:25:28
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`tipo_usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tipo_usuario` (
  `idtipo_usuario` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idtipo_usuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`hierarquia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`hierarquia` (
  `idhierarquia` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idhierarquia`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`canal`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`canal` (
  `idcanal` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idcanal`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`usuario` (
  `idusuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `tipo` INT NOT NULL,
  `apelido` VARCHAR(45) NULL,
  `senha` VARCHAR(45) NOT NULL,
  `url_img` VARCHAR(250) NOT NULL,
  `notificacoes` VARCHAR(1) NOT NULL DEFAULT 'A',
  `hierarquia` INT NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `fk_tipo_usuario_idx` (`tipo` ASC),
  INDEX `fk_hierarquia_usuario_idx` (`hierarquia` ASC),
  CONSTRAINT `fk_tipo_usuario`
    FOREIGN KEY (`tipo`)
    REFERENCES `mydb`.`tipo_usuario` (`idtipo_usuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_hierarquia_usuario`
    FOREIGN KEY (`hierarquia`)
    REFERENCES `mydb`.`hierarquia` (`idhierarquia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`publicacao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`publicacao` (
  `idpublicacao` INT NOT NULL AUTO_INCREMENT,
  `titulo` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(400) NOT NULL,
  `url_img` VARCHAR(250) NULL,
  `usuario` INT NOT NULL,
  `canal` INT NOT NULL,
  PRIMARY KEY (`idpublicacao`),
  INDEX `fk_usuario_publicacao_idx` (`usuario` ASC),
  INDEX `fk_canal_publicacao_idx` (`canal` ASC),
  CONSTRAINT `fk_usuario_publicacao`
    FOREIGN KEY (`usuario`)
    REFERENCES `mydb`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_canal_publicacao`
    FOREIGN KEY (`canal`)
    REFERENCES `mydb`.`canal` (`idcanal`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`curtidas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`curtidas` (
  `idcurtidas` INT NOT NULL AUTO_INCREMENT,
  `usuario` INT NOT NULL,
  `publicacao` INT NOT NULL,
  PRIMARY KEY (`idcurtidas`),
  INDEX `fk_usuario_curtida_idx` (`usuario` ASC),
  INDEX `fk_publicacao_curtida_idx` (`publicacao` ASC),
  CONSTRAINT `fk_usuario_curtida`
    FOREIGN KEY (`usuario`)
    REFERENCES `mydb`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacao_curtida`
    FOREIGN KEY (`publicacao`)
    REFERENCES `mydb`.`publicacao` (`idpublicacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`comentarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`comentarios` (
  `idcomentarios` INT NOT NULL AUTO_INCREMENT,
  `comentario` VARCHAR(300) NOT NULL,
  `usuario` INT NOT NULL,
  `publicacao` INT NOT NULL,
  PRIMARY KEY (`idcomentarios`),
  INDEX `fk_usuario_comentario_idx` (`usuario` ASC),
  INDEX `fk_publicacao_comentario_idx` (`publicacao` ASC),
  CONSTRAINT `fk_usuario_comentario`
    FOREIGN KEY (`usuario`)
    REFERENCES `mydb`.`usuario` (`idusuario`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_publicacao_comentario`
    FOREIGN KEY (`publicacao`)
    REFERENCES `mydb`.`publicacao` (`idpublicacao`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`frases`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`frases` (
  `idfrases` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(45) NOT NULL,
  `diasemana` VARCHAR(45) NOT NULL,
  `autor` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idfrases`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
