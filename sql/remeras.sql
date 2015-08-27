CREATE TABLE `uqbarwik_payments`.`remeras` (
  `idRemera` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NULL,
  `cantidad` INT NULL,
  `talle` VARCHAR(5) NULL,
  `valor` INT NULL,
  `estado` VARCHAR(45) NULL,
  `creado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modificado` TIMESTAMP NULL,
  PRIMARY KEY (`idRemera`));