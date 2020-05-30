-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema samplaces
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema samplaces
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `samplaces` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
USE `samplaces` ;

-- -----------------------------------------------------
-- Table `samplaces`.`bairros`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`bairros` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user` VARCHAR(45) NOT NULL,
  `nome` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `senha` VARCHAR(45) NOT NULL,
  `foto` VARCHAR(100) NULL,
  `bairros_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `user_UNIQUE` (`user` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_users_bairros_idx` (`bairros_id` ASC) ,
  CONSTRAINT `fk_users_bairros`
    FOREIGN KEY (`bairros_id`)
    REFERENCES `samplaces`.`bairros` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`lugar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`lugar` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`favorito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`favorito` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(200) NULL,
  `foto` VARCHAR(100) NOT NULL,
  `users_id` INT NOT NULL,
  `lugar_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_favorito_users1_idx` (`users_id` ASC) ,
  INDEX `fk_favorito_lugar1_idx` (`lugar_id` ASC) ,
  CONSTRAINT `fk_favorito_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `samplaces`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favorito_lugar1`
    FOREIGN KEY (`lugar_id`)
    REFERENCES `samplaces`.`lugar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`favamigos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`favamigos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(200) NULL,
  `foto` VARCHAR(100) NOT NULL,
  `users_id` INT NOT NULL,
  `lugar_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_favamigos_users1_idx` (`users_id` ASC) ,
  INDEX `fk_favamigos_lugar1_idx` (`lugar_id` ASC) ,
  CONSTRAINT `fk_favamigos_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `samplaces`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favamigos_lugar1`
    FOREIGN KEY (`lugar_id`)
    REFERENCES `samplaces`.`lugar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`favdomingo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`favdomingo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(200) NULL,
  `foto` VARCHAR(100) NOT NULL,
  `users_id` INT NOT NULL,
  `lugar_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_favdomingo_users1_idx` (`users_id` ASC) ,
  INDEX `fk_favdomingo_lugar1_idx` (`lugar_id` ASC) ,
  CONSTRAINT `fk_favdomingo_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `samplaces`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favdomingo_lugar1`
    FOREIGN KEY (`lugar_id`)
    REFERENCES `samplaces`.`lugar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`favdate`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`favdate` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `descricao` VARCHAR(200) NULL,
  `foto` VARCHAR(100) NOT NULL,
  `users_id` INT NOT NULL,
  `lugar_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_favdate_users1_idx` (`users_id` ASC) ,
  INDEX `fk_favdate_lugar1_idx` (`lugar_id` ASC) ,
  CONSTRAINT `fk_favdate_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `samplaces`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_favdate_lugar1`
    FOREIGN KEY (`lugar_id`)
    REFERENCES `samplaces`.`lugar` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `samplaces`.`users_has_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `samplaces`.`users_has_users` (
  `users_id` INT NOT NULL,
  `users_id1` INT NOT NULL,
  PRIMARY KEY (`users_id`, `users_id1`),
  INDEX `fk_users_has_users_users2_idx` (`users_id1` ASC) ,
  INDEX `fk_users_has_users_users1_idx` (`users_id` ASC) ,
  CONSTRAINT `fk_users_has_users_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `samplaces`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_users_users2`
    FOREIGN KEY (`users_id1`)
    REFERENCES `samplaces`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


select * from users;

update users set users('senha' VARCHAR(200));

alter table users alter column senha varchar(200);

ALTER TABLE users ALTER COLUMN senha VARCHAR(200) NOT NULL;

select * from bairros;

ALTER TABLE users MODIFY senha varchar(200) not null;

ALTER TABLE users MODIFY foto varchar(500);
