-- MySQL Script generated by MySQL Workbench
-- 03/27/17 16:43:09
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ParagonMLS
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema ParagonMLS
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ParagonMLS` DEFAULT CHARACTER SET utf8 ;
USE `ParagonMLS` ;

-- -----------------------------------------------------
-- Table `ParagonMLS`.`Agencies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParagonMLS`.`Agencies` (
  `agency_id` INT NOT NULL AUTO_INCREMENT,
  `company_name` VARCHAR(100) NOT NULL,
  `phone_number` CHAR(14) NULL,
  `city` VARCHAR(45) NOT NULL,
  `state` CHAR(2) NOT NULL,
  `zip` CHAR(5) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`agency_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParagonMLS`.`Agents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParagonMLS`.`Agents` (
  `agent_id` INT NOT NULL AUTO_INCREMENT,
  `Agencies_agency_id` INT NOT NULL,
  `user_login` VARCHAR(50) NOT NULL,
  `password` VARCHAR(25) NOT NULL,
  `first_name` VARCHAR(50) NOT NULL,
  `last_name` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone_number` CHAR(14) NOT NULL,
  PRIMARY KEY (`agent_id`),
  INDEX `fk_Agents_Agencies1_idx` (`Agencies_agency_id` ASC),
  CONSTRAINT `fk_Agents_Agencies1`
    FOREIGN KEY (`Agencies_agency_id`)
    REFERENCES `ParagonMLS`.`Agencies` (`agency_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParagonMLS`.`Listings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParagonMLS`.`Listings` (
  `MLS_number` INT NOT NULL AUTO_INCREMENT,
  `Agents_listing_agent_id` INT NOT NULL,
  `price` VARCHAR(15) NULL,
  `city` VARCHAR(45) NOT NULL,
  `state` CHAR(2) NOT NULL,
  `zip` CHAR(5) NOT NULL,
  `address` VARCHAR(100) NOT NULL,
  `square_footage` VARCHAR(10) NULL,
  `number_of_bedrooms` VARCHAR(2) NULL,
  `number_of_bathrooms` VARCHAR(2) NULL,
  `room_desc` VARCHAR(300) NULL,
  `listing_desc` VARCHAR(300) NULL,
  `additional_info` VARCHAR(300) NULL,
  `agent_only_info` VARCHAR(300) NULL,
  `daily_hit_count` INT NOT NULL DEFAULT 0,
  `hit_count` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`MLS_number`),
  INDEX `fk_Listings_Agents1_idx` (`Agents_listing_agent_id` ASC),
  CONSTRAINT `fk_Listings_Agents1`
    FOREIGN KEY (`Agents_listing_agent_id`)
    REFERENCES `ParagonMLS`.`Agents` (`agent_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParagonMLS`.`Showings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParagonMLS`.`Showings` (
  `showing_id` INT NOT NULL AUTO_INCREMENT,
  `Listings_MLS_number` INT NOT NULL,
  `start_time` DATETIME(0) NOT NULL,
  `end_time` DATETIME(0) NOT NULL,
  `is_house_vacant` TINYINT(1) NOT NULL,
  `customer_first_name` VARCHAR(50) NULL,
  `customer_last_name` VARCHAR(50) NULL,
  `lockbox_code` VARCHAR(10) NULL,
  `showing_agent_id` INT NOT NULL,
  PRIMARY KEY (`showing_id`),
  INDEX `fk_Showings_Listings1_idx` (`Listings_MLS_number` ASC),
  INDEX `fk_Showings_Agents1_idx` (`showing_agent_id` ASC),
  CONSTRAINT `fk_Showings_Listings1`
    FOREIGN KEY (`Listings_MLS_number`)
    REFERENCES `ParagonMLS`.`Listings` (`MLS_number`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Showings_Agents1`
    FOREIGN KEY (`showing_agent_id`)
    REFERENCES `ParagonMLS`.`Agents` (`agent_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ParagonMLS`.`Showing_Feedback`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ParagonMLS`.`Showing_Feedback` (
  `idShowing_Feedback` INT NOT NULL AUTO_INCREMENT,
  `Showings_showing_id` INT NOT NULL,
  `customer_interest_level` INT(1) NULL,
  `showing_agent_experience_level` INT(1) NULL,
  `customer_price_opinion` VARCHAR(45) NULL,
  `additional_notes` VARCHAR(300) NULL,
  PRIMARY KEY (`idShowing_Feedback`),
  INDEX `fk_Showing_Feedback_Showings1_idx` (`Showings_showing_id` ASC),
  CONSTRAINT `fk_Showing_Feedback_Showings1`
    FOREIGN KEY (`Showings_showing_id`)
    REFERENCES `ParagonMLS`.`Showings` (`showing_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
