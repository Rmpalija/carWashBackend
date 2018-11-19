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
-- Table `carwash`.`countries`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`countries` ;

CREATE TABLE IF NOT EXISTS `carwash`.`countries` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 3
  DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `carwash`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`users` ;

CREATE TABLE IF NOT EXISTS `carwash`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `firstname` VARCHAR(45) NULL DEFAULT NULL,
  `lastname` VARCHAR(45) NULL DEFAULT NULL,
  `isOwner` INT(11) NULL DEFAULT NULL,
  `image` VARCHAR(100) NULL DEFAULT NULL,
  `code` VARCHAR(45) NULL DEFAULT NULL,
  `displayName` VARCHAR(45) NULL DEFAULT NULL,
  `city_id` INT(11) NULL DEFAULT NULL,
  `country_id` INT(11) NULL DEFAULT NULL,
  `updated_at` VARCHAR(50) NULL DEFAULT NULL,
  `created_at` VARCHAR(50) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 8
  DEFAULT CHARACTER SET = utf8mb4;

CREATE UNIQUE INDEX `users_email_unique` ON `carwash`.`users` (`email` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`companies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`companies` ;

CREATE TABLE IF NOT EXISTS `carwash`.`companies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(100) NULL DEFAULT NULL,
  `country_id` INT(11) NULL DEFAULT NULL,
  `owner_id` INT(11) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  `city_id` INT(11) NULL DEFAULT NULL,
  `longLat` VARCHAR(300) NULL DEFAULT NULL,
  `address` VARCHAR(255) NULL DEFAULT NULL,
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
  ENGINE = InnoDB
  AUTO_INCREMENT = 12
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `companies_country_id_idx` ON `carwash`.`companies` (`country_id` ASC);

CREATE INDEX `companies_owner_id_idx` ON `carwash`.`companies` (`owner_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`book_washes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`book_washes` ;

CREATE TABLE IF NOT EXISTS `carwash`.`book_washes` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `company_id` INT(11) NULL DEFAULT NULL,
  `user_id` INT(11) NULL DEFAULT NULL,
  `date` VARCHAR(50) NULL DEFAULT NULL,
  `startTime` VARCHAR(45) NULL DEFAULT NULL,
  `endTime` VARCHAR(45) NULL DEFAULT NULL,
  `car_type` VARCHAR(45) NULL DEFAULT NULL,
  `comment` VARCHAR(255) NULL DEFAULT NULL,
  `book_status` INT(11) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  `fullName` VARCHAR(100) NULL DEFAULT NULL,
  `email` VARCHAR(45) NULL DEFAULT NULL,
  `phone_number` VARCHAR(45) NULL DEFAULT NULL,
  `message` VARCHAR(45) NULL DEFAULT NULL,
  `vehicleMake` VARCHAR(45) NULL DEFAULT NULL,
  `vehicleModel` VARCHAR(45) NULL DEFAULT NULL,
  `offer_id` INT(11) NULL DEFAULT NULL,
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
  ENGINE = InnoDB
  AUTO_INCREMENT = 63
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `bookWash_company_id_idx` ON `carwash`.`book_washes` (`company_id` ASC);

CREATE INDEX `bookWash_user_id_idx` ON `carwash`.`book_washes` (`user_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`cities`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`cities` ;

CREATE TABLE IF NOT EXISTS `carwash`.`cities` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NULL DEFAULT NULL,
  `longLat` VARCHAR(100) NULL DEFAULT NULL,
  `country_id` INT(11) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `cities_country_id`
  FOREIGN KEY (`country_id`)
  REFERENCES `carwash`.`countries` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  AUTO_INCREMENT = 9
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `cities_country_id_idx` ON `carwash`.`cities` (`country_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`companyCampaings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`companyCampaings` ;

CREATE TABLE IF NOT EXISTS `carwash`.`companyCampaings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  `company_id` INT(11) NULL DEFAULT NULL,
  `start_date` VARCHAR(45) NULL DEFAULT NULL,
  `end_date` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `companiCampaings_company_id`
  FOREIGN KEY (`company_id`)
  REFERENCES `carwash`.`companies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `companiCampaings_company_id_idx` ON `carwash`.`companyCampaings` (`company_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`migrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`migrations` ;

CREATE TABLE IF NOT EXISTS `carwash`.`migrations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `carwash`.`offers`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`offers` ;

CREATE TABLE IF NOT EXISTS `carwash`.`offers` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NULL DEFAULT NULL,
  `description` VARCHAR(45) NULL DEFAULT NULL,
  `price` FLOAT NULL DEFAULT NULL,
  `company_id` INT(11) NULL DEFAULT NULL,
  `time` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `offers_company_id`
  FOREIGN KEY (`company_id`)
  REFERENCES `carwash`.`companies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  AUTO_INCREMENT = 7
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `offers_company_id_idx` ON `carwash`.`offers` (`company_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`password_resets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`password_resets` ;

CREATE TABLE IF NOT EXISTS `carwash`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8mb4;

CREATE INDEX `password_resets_email_index` ON `carwash`.`password_resets` (`email` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`user_campaings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`user_campaings` ;

CREATE TABLE IF NOT EXISTS `carwash`.`user_campaings` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL DEFAULT NULL,
  `campaing_id` INT(11) NULL DEFAULT NULL,
  `created_at` DATETIME NULL DEFAULT NULL,
  `updated_at` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_campaings_compaing_id`
  FOREIGN KEY (`campaing_id`)
  REFERENCES `carwash`.`companyCampaings` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_campaings_user_id`
  FOREIGN KEY (`user_id`)
  REFERENCES `carwash`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `user_campaings_user_id_idx` ON `carwash`.`user_campaings` (`user_id` ASC);

CREATE INDEX `user_campaings_company_id_idx` ON `carwash`.`user_campaings` (`campaing_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`user_companies`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`user_companies` ;

CREATE TABLE IF NOT EXISTS `carwash`.`user_companies` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL DEFAULT NULL,
  `company_id` INT(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `user_company_company_id`
  FOREIGN KEY (`company_id`)
  REFERENCES `carwash`.`companies` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `user_company_user_id`
  FOREIGN KEY (`user_id`)
  REFERENCES `carwash`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
  ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARACTER SET = latin1;

CREATE INDEX `user_company_user_id_idx` ON `carwash`.`user_companies` (`user_id` ASC);

CREATE INDEX `user_company_company_id_idx` ON `carwash`.`user_companies` (`company_id` ASC);


-- -----------------------------------------------------
-- Table `carwash`.`working_times`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `carwash`.`working_times` ;

CREATE TABLE IF NOT EXISTS `carwash`.`working_times` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `monday` VARCHAR(45) NULL DEFAULT NULL,
  `tuesday` VARCHAR(45) NULL DEFAULT NULL,
  `wednesday` VARCHAR(45) NULL DEFAULT NULL,
  `thursday` VARCHAR(45) NULL DEFAULT NULL,
  `friday` VARCHAR(45) NULL DEFAULT NULL,
  `saturday` VARCHAR(45) NULL DEFAULT NULL,
  `sunday` VARCHAR(45) NULL DEFAULT NULL,
  `company_id` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  AUTO_INCREMENT = 5
  DEFAULT CHARACTER SET = latin1;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `carwash`.`countries`
-- -----------------------------------------------------
START TRANSACTION;
USE `carwash`;
INSERT INTO `carwash`.`countries` (`id`, `name`, `created_at`, `updated_at`) VALUES (1, 'Serbia', NULL, NULL);
INSERT INTO `carwash`.`countries` (`id`, `name`, `created_at`, `updated_at`) VALUES (2, 'Bosnia', NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `carwash`.`cities`
-- -----------------------------------------------------
START TRANSACTION;
USE `carwash`;
INSERT INTO `carwash`.`cities` (`id`, `name`, `longLat`, `country_id`, `created_at`, `updated_at`) VALUES (NULL, 'Banja Luka', NULL, 2, NULL, NULL);
INSERT INTO `carwash`.`cities` (`id`, `name`, `longLat`, `country_id`, `created_at`, `updated_at`) VALUES (NULL, 'Beograd', NULL, 1, NULL, NULL);
INSERT INTO `carwash`.`cities` (`id`, `name`, `longLat`, `country_id`, `created_at`, `updated_at`) VALUES (NULL, 'Gradiska', NULL, 2, NULL, NULL);
INSERT INTO `carwash`.`cities` (`id`, `name`, `longLat`, `country_id`, `created_at`, `updated_at`) VALUES (NULL, 'Novi Sad', NULL, 1, NULL, NULL);

COMMIT;

