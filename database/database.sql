SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema carwash
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `carwash` ;
CREATE SCHEMA IF NOT EXISTS `carwash` DEFAULT CHARACTER SET latin1 ;
USE `carwash` ;

-- -----------------------------------------------------
-- Table `carwash`.`migrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`migrations` ;

CREATE TABLE IF NOT EXISTS `carwash`.`migrations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `batch` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `carwash`.`password_resets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`password_resets` ;

CREATE TABLE IF NOT EXISTS `carwash`.`password_resets` (
  `email` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `token` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE INDEX `password_resets_email_index` ON `carwash`.`password_resets` (`email` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`users` ;

CREATE TABLE IF NOT EXISTS `carwash`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `password` VARCHAR(255) CHARACTER SET 'utf8mb4' NOT NULL,
  `firstname` VARCHAR(45) NULL,
  `lastname` VARCHAR(45) NULL,
  `isOwner` INT NULL,
  `image` VARCHAR(100) NULL,
  `code` VARCHAR(45) NULL,
  `displayName` VARCHAR(45) NULL,
  `updated_at` VARCHAR(50) NULL DEFAULT NULL,
  `created_at` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE UNIQUE INDEX `users_email_unique` ON `carwash`.`users` (`email` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`countries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`countries` ;

CREATE TABLE IF NOT EXISTS `carwash`.`countries` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `created_at` VARCHAR(45) NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `carwash`.`cities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`cities` ;

CREATE TABLE IF NOT EXISTS `carwash`.`cities` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL,
  `longLat` VARCHAR(100) NULL,
  `country_id` INT NULL,
  `created_at` VARCHAR(45) NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `cities_country_id`
    FOREIGN KEY (`country_id`)
    REFERENCES `carwash`.`countries` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `cities_country_id_idx` ON `carwash`.`cities` (`country_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`companies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`companies` ;

CREATE TABLE IF NOT EXISTS `carwash`.`companies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(100) NULL,
  `country_id` INT NULL,
  `owner_id` INT NULL,
  `created_at` VARCHAR(45) NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `companies_country_id`
    FOREIGN KEY (`country_id`)
    REFERENCES `carwash`.`countries` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `companies_owner_id`
    FOREIGN KEY (`owner_id`)
    REFERENCES `carwash`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `companies_country_id_idx` ON `carwash`.`companies` (`country_id` ASC);

CREATE INDEX `companies_owner_id_idx` ON `carwash`.`companies` (`owner_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`book_wash`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`book_wash` ;

CREATE TABLE IF NOT EXISTS `carwash`.`book_wash` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `company_id` INT NULL,
  `user_id` INT NULL,
  `dateTime` VARCHAR(50) NULL,
  `car_type` VARCHAR(45) NULL,
  `book_status` INT NULL,
  `created_at` VARCHAR(45) NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `bookWash_company_id`
    FOREIGN KEY (`company_id`)
    REFERENCES `carwash`.`companies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `bookWash_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `carwash`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `bookWash_company_id_idx` ON `carwash`.`book_wash` (`company_id` ASC);

CREATE INDEX `bookWash_user_id_idx` ON `carwash`.`book_wash` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`companyCampaings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`companyCampaings` ;

CREATE TABLE IF NOT EXISTS `carwash`.`companyCampaings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `company_id` INT NULL,
  `start_date` VARCHAR(45) NULL,
  `end_date` VARCHAR(45) NULL,
  `created_at` VARCHAR(45) NULL,
  `updated_at` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `companiCampaings_company_id`
    FOREIGN KEY (`company_id`)
    REFERENCES `carwash`.`companies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `companiCampaings_company_id_idx` ON `carwash`.`companyCampaings` (`company_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`offers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`offers` ;

CREATE TABLE IF NOT EXISTS `carwash`.`offers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  `price` FLOAT NULL,
  `company_id` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `offers_company_id`
    FOREIGN KEY (`company_id`)
    REFERENCES `carwash`.`companies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `offers_company_id_idx` ON `carwash`.`offers` (`company_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`user_campaings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`user_campaings` ;

CREATE TABLE IF NOT EXISTS `carwash`.`user_campaings` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NULL,
  `campaing_id` INT NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_campaings_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `carwash`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_campaings_compaing_id`
    FOREIGN KEY (`campaing_id`)
    REFERENCES `carwash`.`companyCampaings` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `user_campaings_user_id_idx` ON `carwash`.`user_campaings` (`user_id` ASC);

CREATE INDEX `user_campaings_company_id_idx` ON `carwash`.`user_campaings` (`campaing_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
