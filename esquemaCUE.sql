-- -----------------------------------------------------
-- Esquema de Cuaderno de Campo Digital
-- -----------------------------------------------------

SET NAMES 'utf8';
SET CHARACTER SET utf8;
SET character_set_client = utf8;
SET character_set_results = utf8;
SET character_set_connection = utf8;

-- -----------------------------------------------------
-- Creación de la base de datos si no existe.
-- -----------------------------------------------------

CREATE SCHEMA IF NOT EXISTS `CuadernoDeCampoDB` DEFAULT CHARACTER SET utf8 ;
USE `CuadernoDeCampoDB` ;

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`usuarios` (
  `id` VARCHAR(10) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NULL,
  `fecha_creacion` DATETIME,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`organizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`organizacion` (
  `nif` VARCHAR(10) NOT NULL,
  `nombre_razon_social` VARCHAR(45) NULL,
  `nombre_organizacion` VARCHAR(45) NULL,
  `nreg_exp_nacional` VARCHAR(45) NULL,
  `nreg_exp_autonomico` VARCHAR(45) NULL,
  `regepa` VARCHAR(15) NULL,
  `direccion` VARCHAR(45) NULL,
  `localidad` VARCHAR(45) NULL,  -- Haría referencia a la tabla municipio
  `cod_postal` VARCHAR(5) NULL,
  `provincia` VARCHAR(45) NULL,  -- Haría referencia a la tabla provincia
  `comunidad` VARCHAR(45) NULL,
  `tlf_fijo` VARCHAR(12) NULL,
  `tlf_movil` VARCHAR(12) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`nif`));
  
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`explotacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`explotacion` (
  `explotacion_ID` VARCHAR(10) NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `alias` VARCHAR(45) NULL,
  `comunidad` VARCHAR(45) NULL,
  `organizacion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`explotacion_ID`),
  CONSTRAINT `fk_explotacion_organizacion`
    FOREIGN KEY (`organizacion`)
    REFERENCES `CuadernoDeCampoDB`.`organizacion` (`nif`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios_explotacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`usuarios_explotacion` (
  `explotacion_ID` VARCHAR(10) NOT NULL,
  `usuario_ID` VARCHAR(10) NOT NULL,
  PRIMARY KEY (`explotacion_ID`, `usuario_ID`),
  CONSTRAINT `fk_usuarios`
    FOREIGN KEY (`usuario_ID`)
    REFERENCES `CuadernoDeCampoDB`.`usuarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
 CONSTRAINT `fk_explotacion`
    FOREIGN KEY (`explotacion_ID`)
    REFERENCES `CuadernoDeCampoDB`.`explotacion` (`explotacion_ID`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`provincia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`provincia`(
`provincia_id` INT NOT NULL PRIMARY KEY,
`nombre` VARCHAR(20) NOT NULL
);
  
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`municipio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`municipio`(
`municipio_id` INT NOT NULL PRIMARY KEY,
`provincia_id` INT NOT NULL,
`nombre` VARCHAR(20) NOT NULL,
CONSTRAINT `fk_provincia_municipio` FOREIGN KEY(`provincia_id`) REFERENCES `CuadernoDeCampoDB`.`provincia`(`provincia_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`unidad`
-- -----------------------------------------------------
    
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`unidad`(
`unidad_id` INT auto_increment PRIMARY KEY,
`unidad` VARCHAR(10),
`tipo` ENUM("volumen", "peso", "densidad", "cosecha")  
);
    
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`parcela`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`parcela`(
`parcela_id` INT auto_increment PRIMARY KEY,
`explotacion_ID` VARCHAR(10) NOT NULL,
`provincia_id` INT NOT NULL,
`municipio_id` INT NOT NULL,
`ref_sigpac` VARCHAR(20) NOT NULL,
`nombre` VARCHAR(20) NOT NULL,
`superficie` DOUBLE,
CONSTRAINT `fk_explotacion_parcela` FOREIGN KEY(`explotacion_ID`) REFERENCES `CuadernoDeCampoDB`.`explotacion`(`explotacion_ID`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_provincia_parcela` FOREIGN KEY(`provincia_id`) REFERENCES `CuadernoDeCampoDB`.`provincia`(`provincia_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_municipio_parcela` FOREIGN KEY(`municipio_id`) REFERENCES `CuadernoDeCampoDB`.`municipio`(`municipio_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`unidad_gestion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`unidad_gestion`(
`unidad_gestion_id` INT auto_increment PRIMARY KEY,
`parcela_id` INT NOT NULL, 
`nombre` VARCHAR(20),
`superficie` DOUBLE,
`uso` ENUM("agricola", "en_descanso", "ganadero", "forestal", "otros"),
 CONSTRAINT `fk_parcela_unidadgestion` FOREIGN KEY(`parcela_id`) REFERENCES `CuadernoDeCampoDB`.`parcela`(`parcela_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cultivo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`cultivo`(
`cultivo_id` INT auto_increment PRIMARY KEY,
`genero` VARCHAR(20),
`variedad` VARCHAR(20),
`descripcion` VARCHAR(100),
`tipo` ENUM("leñoso","herbaceo", "horticola", "forrejero", "ganadero"),
`ciclo` ENUM("anual", "bianual", "perenne")
); 

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`ecorregimen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`ecorregimen`(
`ecorregimen_id` INT auto_increment PRIMARY KEY,
`nombre` VARCHAR(20) NOT NULL, 
`descripcion` VARCHAR(200),
`active` BOOLEAN
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`plantacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`plantacion`(
`plantacion_id` INT auto_increment PRIMARY KEY,
`parcela_id` INT NOT NULL,
`unidad_gestion_id` INT,
`cultivo_id` INT NOT NULL,
`densidad_unidad` INT, 
`fecha_inicio` DATE NOT NULL,
`fecha_fin` DATE,
`sistema_cultivo` ENUM("intensivo", "extensivo", "tradicional", "superintensivo"),
`sistema_riego` ENUM("secano", "goteo", "aspersion", "gravedad"),
`finalidad` ENUM("produccion_agricola", "autoconsumo", "ganadera", "conservacion", "energetica"),
`manejo` ENUM("convencional", "produccion_integrada", "ecologico", "regenerativo"),
`valor_densidad` DOUBLE,
`anotaciones` VARCHAR(200),
CONSTRAINT `fk_parcela_plantacion` FOREIGN KEY(`parcela_id`) REFERENCES `CuadernoDeCampoDB`.`parcela`(`parcela_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_un_gestion_plantacion` FOREIGN KEY(`unidad_gestion_id`) REFERENCES `CuadernoDeCampoDB`.`unidad_gestion`(`unidad_gestion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_cultivo_plantacion` FOREIGN KEY(`cultivo_id`) REFERENCES `CuadernoDeCampoDB`.`cultivo`(`cultivo_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_unidad_densidad` FOREIGN KEY(`densidad_unidad`) REFERENCES `CuadernoDeCampoDB`.`unidad`(`unidad_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`ecorregimen_plantacion`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`ecorregimen_plantacion`(
`ecorregimen_id` INT NOT NULL,
`plantacion_id` INT NOT NULL,
PRIMARY KEY(`ecorregimen_id`, `plantacion_id`),
CONSTRAINT `fk_ecorregimen` FOREIGN KEY(`ecorregimen_id`) REFERENCES `CuadernoDeCampoDB`.`ecorregimen`(`ecorregimen_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_plantacion_ecorregimen` FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fenologia`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`fenologia` (
`fenologia_id` INT NOT NULL PRIMARY KEY,
`plantacion_id` INT NOT NULL,
`fecha_deteccion` DATE NOT NULL,
`estado` ENUM("germinacion", "desarrollo_hojas", "desarrollo_brotes", "crecimiento_tallo", "desarrollo_organos_reproductivos", "inflorescencia", "floracion", "desarrollo_fruto", "maduracion", "senescencia"),
`anotaciones` VARCHAR(200),
CONSTRAINT `fk_plantacion_fenologia` FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);


