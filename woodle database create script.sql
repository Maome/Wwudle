SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `CS492_201310` DEFAULT CHARACTER SET latin1 ;
USE `CS492_201310` ;

-- -----------------------------------------------------
-- Table `CS492_201310`.`User`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`User` (
  `UserID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Email` VARCHAR(50) NOT NULL ,
  `FirstLoginDate` DATETIME NULL DEFAULT NULL ,
  `LastLoginDate` DATETIME NULL DEFAULT NULL ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  `UserName` VARCHAR(50) NULL DEFAULT NULL ,
  `SecurityLevel` SMALLINT(5) UNSIGNED NOT NULL ,
  `Enabled` BIT(1) NULL DEFAULT NULL ,
  PRIMARY KEY (`UserID`) )
ENGINE = InnoDB
AUTO_INCREMENT = 17
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`BookCategory`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`BookCategory` (
  `BookCategoryID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Description` VARCHAR(100) NOT NULL ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  PRIMARY KEY (`BookCategoryID`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`Book`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`Book` (
  `BookID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `ISBN` DECIMAL(13,0) NOT NULL ,
  `Authors` VARCHAR(150) NULL DEFAULT NULL ,
  `Title` VARCHAR(150) NULL DEFAULT NULL ,
  `Edition` VARCHAR(5) NULL DEFAULT NULL ,
  `BookCategoryID` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  `UserID` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`BookID`) ,
  INDEX `BookCategoryID` (`BookCategoryID` ASC) ,
  INDEX `UserID` (`UserID` ASC) ,
  CONSTRAINT `Book_ibfk_2`
    FOREIGN KEY (`UserID` )
    REFERENCES `CS492_201310`.`User` (`UserID` ),
  CONSTRAINT `Book_ibfk_1`
    FOREIGN KEY (`BookCategoryID` )
    REFERENCES `CS492_201310`.`BookCategory` (`BookCategoryID` ))
ENGINE = InnoDB
AUTO_INCREMENT = 65
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`BookCondition`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`BookCondition` (
  `BookConditionID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Description` VARCHAR(20) NOT NULL ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  PRIMARY KEY (`BookConditionID`) )
ENGINE = InnoDB
AUTO_INCREMENT = 6
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`BookListing`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`BookListing` (
  `PostID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `PostDate` DATETIME NOT NULL ,
  `UserID` INT(10) UNSIGNED NOT NULL ,
  `BookID` INT(10) UNSIGNED NOT NULL ,
  `BookConditionID` INT(10) UNSIGNED NULL DEFAULT NULL ,
  `Price` DECIMAL(6,2) NULL DEFAULT NULL ,
  `ViewCount` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  `CourseDept` VARCHAR(45) NULL DEFAULT NULL ,
  `CourseNumber` VARCHAR(4) NULL DEFAULT NULL ,
  PRIMARY KEY (`PostID`) ,
  INDEX `UserID` (`UserID` ASC) ,
  INDEX `BookID` (`BookID` ASC) ,
  INDEX `BookConditionID` (`BookConditionID` ASC) ,
  CONSTRAINT `BookListing_ibfk_1`
    FOREIGN KEY (`UserID` )
    REFERENCES `CS492_201310`.`User` (`UserID` ),
  CONSTRAINT `BookListing_ibfk_2`
    FOREIGN KEY (`BookID` )
    REFERENCES `CS492_201310`.`Book` (`BookID` ),
  CONSTRAINT `BookListing_ibfk_3`
    FOREIGN KEY (`BookConditionID` )
    REFERENCES `CS492_201310`.`BookCondition` (`BookConditionID` ))
ENGINE = InnoDB
AUTO_INCREMENT = 74
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`BookReview`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`BookReview` (
  `PostID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `PostDate` DATETIME NOT NULL ,
  `UserID` INT(10) UNSIGNED NOT NULL ,
  `BookID` INT(10) UNSIGNED NOT NULL ,
  `ViewCount` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  PRIMARY KEY (`PostID`) ,
  INDEX `UserID` (`UserID` ASC) ,
  INDEX `BookID` (`BookID` ASC) ,
  CONSTRAINT `BookReview_ibfk_1`
    FOREIGN KEY (`UserID` )
    REFERENCES `CS492_201310`.`User` (`UserID` ),
  CONSTRAINT `BookReview_ibfk_2`
    FOREIGN KEY (`BookID` )
    REFERENCES `CS492_201310`.`Book` (`BookID` ))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`Configuration`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`Configuration` (
  `Name` VARCHAR(200) NULL DEFAULT NULL ,
  `Value` VARCHAR(200) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NULL DEFAULT NULL ,
  `RecordStatusDate` DATETIME NULL DEFAULT NULL )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`Department`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`Department` (
  `DepartmentID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Abbreviation` VARCHAR(10) NOT NULL ,
  `Description` VARCHAR(150) NOT NULL ,
  `RowOrder` SMALLINT(5) UNSIGNED NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  PRIMARY KEY (`DepartmentID`) )
ENGINE = InnoDB
AUTO_INCREMENT = 202
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`Flag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`Flag` (
  `TableName` VARCHAR(30) NULL DEFAULT NULL ,
  `PostID` INT(10) UNSIGNED NOT NULL ,
  `UserID` INT(10) UNSIGNED NOT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  `Comments` VARCHAR(150) NULL DEFAULT NULL )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`HyperLink`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`HyperLink` (
  `HyperlinkID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `LinkType` SMALLINT(6) NULL DEFAULT NULL ,
  `URL` VARCHAR(200) NULL DEFAULT NULL ,
  `Text` VARCHAR(100) NULL DEFAULT NULL ,
  `Position` SMALLINT(6) NULL DEFAULT NULL ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  `ParentHyperLinkID` INT(10) UNSIGNED NULL DEFAULT NULL ,
  PRIMARY KEY (`HyperlinkID`) ,
  INDEX `ParentHyperLinkID` (`ParentHyperLinkID` ASC) ,
  CONSTRAINT `HyperLink_ibfk_1`
    FOREIGN KEY (`ParentHyperLinkID` )
    REFERENCES `CS492_201310`.`HyperLink` (`HyperlinkID` ))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`Professor`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`Professor` (
  `Name` VARCHAR(50) NOT NULL ,
  `ProfessorID` INT(11) NULL DEFAULT NULL ,
  `RecordStatus` INT(11) NULL DEFAULT NULL ,
  `RecordStatusDate` DATETIME NULL DEFAULT NULL ,
  `RowOrder` INT(11) NULL DEFAULT NULL ,
  PRIMARY KEY (`Name`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`Review`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`Review` (
  `PostID` INT(11) NOT NULL AUTO_INCREMENT ,
  `PostDate` DATETIME NULL DEFAULT NULL ,
  `UserID` INT(11) NULL DEFAULT NULL ,
  `CourseDept` VARCHAR(45) NULL DEFAULT NULL ,
  `CourseNumber` VARCHAR(4) NULL DEFAULT NULL ,
  `Professor` VARCHAR(45) NULL DEFAULT NULL ,
  `Workload` INT(11) NULL DEFAULT NULL ,
  `LectureQuality` DOUBLE NULL DEFAULT NULL ,
  `TestRelevance` DOUBLE NULL DEFAULT NULL ,
  `RelevanceToProgram` DOUBLE NULL DEFAULT NULL ,
  `Enjoyable` DOUBLE NULL DEFAULT NULL ,
  `BookNecessity` INT(11) NULL DEFAULT NULL ,
  `Comments` VARCHAR(255) NULL DEFAULT NULL ,
  `Overall` FLOAT NULL DEFAULT NULL ,
  `ViewCount` INT(11) NULL DEFAULT NULL ,
  `ChangeSource` INT(11) NULL DEFAULT NULL ,
  `RecordStatus` INT(11) NULL DEFAULT NULL ,
  `RecordStatusDate` DATETIME NULL DEFAULT NULL ,
  PRIMARY KEY (`PostID`) )
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `CS492_201310`.`RideShare`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `CS492_201310`.`RideShare` (
  `PostID` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `PostDate` DATETIME NOT NULL ,
  `UserID` INT(10) UNSIGNED NOT NULL ,
  `DepartureDate` DATETIME NOT NULL ,
  `ReturnDate` DATETIME NOT NULL ,
  `SourceLatitude` DECIMAL(8,5) NOT NULL ,
  `SourceLongitude` DECIMAL(8,5) NOT NULL ,
  `SourceCity` VARCHAR(50) NOT NULL ,
  `DestLatitude` DECIMAL(8,5) NOT NULL ,
  `DestLongitude` DECIMAL(8,5) NOT NULL ,
  `DestCity` VARCHAR(50) NOT NULL ,
  `SourceThresholdMiles` SMALLINT(5) UNSIGNED NULL DEFAULT NULL ,
  `DestThresholdMiles` SMALLINT(5) UNSIGNED NULL DEFAULT NULL ,
  `SeatsRemaining` TINYINT(3) UNSIGNED NULL DEFAULT NULL ,
  `MaxSeats` TINYINT(3) UNSIGNED NULL DEFAULT NULL ,
  `Price` DECIMAL(6,2) NULL DEFAULT NULL ,
  `ViewCount` INT(10) UNSIGNED NOT NULL DEFAULT '0' ,
  `ChangeSource` VARCHAR(50) NULL DEFAULT NULL ,
  `RecordStatus` TINYINT(3) UNSIGNED NOT NULL ,
  `RecordStatusDate` DATETIME NOT NULL ,
  PRIMARY KEY (`PostID`) ,
  INDEX `UserID` (`UserID` ASC) ,
  CONSTRAINT `RideShare_ibfk_1`
    FOREIGN KEY (`UserID` )
    REFERENCES `CS492_201310`.`User` (`UserID` ))
ENGINE = InnoDB
AUTO_INCREMENT = 111
DEFAULT CHARACTER SET = latin1;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
