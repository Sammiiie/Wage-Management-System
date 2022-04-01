SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- Drop database wage_system if it exists
DROP SCHEMA IF EXISTS `wage_system` ;


-- Create new database - wage_system
CREATE SCHEMA IF NOT EXISTS `wage_system` DEFAULT CHARACTER SET utf8 ;
USE `wage_system` ;


-- Table `wage_system`.`staff`
DROP TABLE IF EXISTS `wage_system`.`staff` ;

CREATE TABLE IF NOT EXISTS `wage_system`.`staff` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(60) NULL,
  `lastname` VARCHAR(60) NULL,
  `staff_id` VARCHAR(45) NULL,
  `designation` VARCHAR(45) NULL,
  `password` VARCHAR(800) NULL,
  PRIMARY KEY (`id`))
;



-- Table `wage_system`.`compliant`
DROP TABLE IF EXISTS `wage_system`.`compliant` ;
CREATE TABLE IF NOT EXISTS `wage_system`.`compliant` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `compliant_type` VARCHAR(200) NULL,
  `message` LONGTEXT NULL,
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_compliant_staff_idx` (`staff_id` ASC),
  CONSTRAINT `fk_compliant_staff`
    FOREIGN KEY (`staff_id`)
    REFERENCES `wage_system`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;



-- Table `wage_system`.`wages`

DROP TABLE IF EXISTS `wage_system`.`wages` ;
CREATE TABLE IF NOT EXISTS `wage_system`.`wages` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `rate` DECIMAL(19,2) NULL,
  `hours_worked` INT NULL,
  `pay` DECIMAL(19,2) NULL,
  `day_worked` DATE NULL,
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_wages_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_wages_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `wage_system`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);



-- Table `wage_system`.`comments`

DROP TABLE IF EXISTS `wage_system`.`comments` ;
CREATE TABLE IF NOT EXISTS `wage_system`.`comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `message` LONGTEXT NULL,
  `date_sent` DATETIME NULL,
  `compliant_id` INT NOT NULL,
  `staff_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_comments_compliant1_idx` (`compliant_id` ASC),
  INDEX `fk_comments_staff1_idx` (`staff_id` ASC),
  CONSTRAINT `fk_comments_compliant1`
    FOREIGN KEY (`compliant_id`)
    REFERENCES `wage_system`.`compliant` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_staff1`
    FOREIGN KEY (`staff_id`)
    REFERENCES `wage_system`.`staff` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
