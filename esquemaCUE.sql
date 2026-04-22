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
-- Tabla `CuadernoDeCampoDB`.`provincia`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`provincia`(
`provincia_id` INT NOT NULL PRIMARY KEY,
`nombre` VARCHAR(30) NOT NULL
);
  
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`municipio`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`municipio`(
`municipio_id` INT NOT NULL PRIMARY KEY,
`provincia_id` INT NOT NULL,
`nombre` VARCHAR(50) NOT NULL,
CONSTRAINT `fk_provincia_municipio` FOREIGN KEY(`provincia_id`) REFERENCES `CuadernoDeCampoDB`.`provincia`(`provincia_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`usuarios` (
  `id` INT auto_increment NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NULL,
  `fecha_creacion` DATETIME,
  PRIMARY KEY (`id`));


-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`organizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`organizacion` (
  `organizacion_id` INT auto_increment NOT NULL,
  `nif` VARCHAR(10) NOT NULL,
  `nombre_razon_social` VARCHAR(45) NULL,
  `nombre_organizacion` VARCHAR(45) NULL,
  `nreg_exp_nacional` VARCHAR(45) NULL,
  `nreg_exp_autonomico` VARCHAR(45) NULL,
  `regepa` VARCHAR(15) NULL,
  `direccion` VARCHAR(45) NULL,
  `municipio_id` INT NULL, 
  `cod_postal` VARCHAR(5) NULL,
  `provincia_id` INT NULL, 
  `comunidad` VARCHAR(45) NULL,
  `tlf_fijo` VARCHAR(12) NULL,
  `tlf_movil` VARCHAR(12) NULL,
  `email` VARCHAR(45) NULL,
  PRIMARY KEY (`organizacion_id`),
  CONSTRAINT `fk_provincia_organizacion` FOREIGN KEY(`provincia_id`) REFERENCES `CuadernoDeCampoDB`.`provincia`(`provincia_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_municipio_organizacion` FOREIGN KEY(`municipio_id`) REFERENCES `CuadernoDeCampoDB`.`municipio`(`municipio_id`) ON DELETE RESTRICT ON UPDATE CASCADE
  );
  
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`explotacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`explotacion` (
  `explotacion_id` INT auto_increment NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `alias` VARCHAR(45) NULL,
  `comunidad` VARCHAR(45) NULL,
  `organizacion_id` INT NOT NULL,
  PRIMARY KEY (`explotacion_id`),
  CONSTRAINT `fk_explotacion_organizacion`
    FOREIGN KEY (`organizacion_id`)
    REFERENCES `CuadernoDeCampoDB`.`organizacion` (`organizacion_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios_explotacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`usuarios_explotacion` (
  `explotacion_id` INT NOT NULL,
  `usuario_id` INT NOT NULL,
  PRIMARY KEY (`explotacion_id`, `usuario_id`),
  CONSTRAINT `fk_usuarios`
    FOREIGN KEY (`usuario_id`)
    REFERENCES `CuadernoDeCampoDB`.`usuarios` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
 CONSTRAINT `fk_explotacion`
    FOREIGN KEY (`explotacion_id`)
    REFERENCES `CuadernoDeCampoDB`.`explotacion` (`explotacion_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`unidad`
-- -----------------------------------------------------
    
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`unidad`(
`unidad_id` INT auto_increment PRIMARY KEY,
`unidad` VARCHAR(10),
`tipo` ENUM("volumen", "masa", "densidad", "cantidad", "concentracion", "por_superficie")   
);
    
-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`parcela`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`parcela`(
`parcela_id` INT auto_increment PRIMARY KEY,
`explotacion_id` INT NOT NULL,
`provincia_id` INT NOT NULL,
`municipio_id` INT NOT NULL,
`ref_sigpac` VARCHAR(20) NOT NULL,
`nombre` VARCHAR(20) NOT NULL,
`superficie` DOUBLE,
CONSTRAINT `fk_explotacion_parcela` FOREIGN KEY(`explotacion_id`) REFERENCES `CuadernoDeCampoDB`.`explotacion`(`explotacion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
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
`nombre` VARCHAR(20),
`variedad` VARCHAR(20),
UNIQUE(`nombre`, `variedad`), -- Evitar duplicados
`descripcion` VARCHAR(100),
`tipo` ENUM("leñoso","herbaceo", "horticola", "forrajero"),
`ciclo` ENUM("anual", "bianual", "perenne")
); 

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`ecorregimen`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`ecorregimen`(
`ecorregimen_id` VARCHAR(4) PRIMARY KEY,
`nombre` VARCHAR(100) NOT NULL, 
`descripcion` VARCHAR(200),
`activo` BOOLEAN
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
`ecorregimen_id` VARCHAR(4) NOT NULL,
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

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`personal`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`personal` (
`personal_id` INT auto_increment PRIMARY KEY,
`dni` VARCHAR(9) NOT NULL,
`nombre` VARCHAR(45),
`apellidos` VARCHAR(45),
`telefono` VARCHAR(15),
`email` VARCHAR(45),
`direccion` VARCHAR(45),
`nacionalidad` VARCHAR(45),
`rol` ENUM("propietario", "tecnico", "trabajador", "administrativo"),
`municipio_id` INT NOT NULL,
`provincia_id` INT NOT NULL,
CONSTRAINT `fk_municipio_personal` 
  FOREIGN KEY(`municipio_id`) REFERENCES `CuadernoDeCampoDB`.`municipio`(`municipio_id`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE,
CONSTRAINT `fk_provincia_personal` 
  FOREIGN KEY(`provincia_id`) REFERENCES `CuadernoDeCampoDB`.`provincia`(`provincia_id`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fertilizante`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`fertilizante`(
`fertilizante_id` INT auto_increment PRIMARY KEY,
`nombre` VARCHAR(30) NOT NULL,
`tipo` ENUM("propio", "comercial") NOT NULL,
`descripcion` VARCHAR(200),
`nitrogeno` DOUBLE,
`fosforo` DOUBLE,
`potasio` DOUBLE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fertilizacion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`fertilizacion`(
`fertilizacion_id` INT auto_increment PRIMARY KEY,
`plantacion_id` INT NOT NULL,
`fertilizante_id` INT NOT NULL,
`dosis_unidad_id` INT NOT NULL,
`caldo_unidad_id` INT,
`fecha_inicio` DATE NOT NULL,
`fecha_fin` DATE,
`superficie` DOUBLE,
`tipo_aplicacion` ENUM('fondo','cobertura','fertirrigacion','foliar','localizada'),
`dosis_cantidad` DOUBLE NOT NULL,
`caldo_cantidad` DOUBLE,
`anotaciones` VARCHAR(200),
CONSTRAINT `fk_plantacion_fert` FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_fertilizante_fert` FOREIGN KEY(`fertilizante_id`) REFERENCES `CuadernoDeCampoDB`.`fertilizante`(`fertilizante_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_uni_dosis_fert` FOREIGN KEY(`dosis_unidad_id`) REFERENCES `CuadernoDeCampoDB`.`unidad`(`unidad_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_uni_caldo_fert` FOREIGN KEY(`caldo_unidad_id`) REFERENCES `CuadernoDeCampoDB`.`unidad`(`unidad_id`) ON DELETE SET NULL ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`riego`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`riego`(
`riego_id` INT auto_increment PRIMARY KEY,
`plantacion_id` INT NOT NULL,
`cantidad_unidad_id` INT NOT NULL,
`fecha_inicio` DATE NOT NULL,
`fecha_fin` DATE,
`superficie` DOUBLE,
`cantidad` DOUBLE,
`tipo_riego` ENUM("goteo", "aspersion", "microaspersion", "inundacion", "surcos", "pivot", "manual"),
`tipo_energia` ENUM("electrica", "combustible", "solar", "gravedad"),
`origen_agua` ENUM("subterranea", "superficial", "embalse", "rio", "canal", "reciclada", "desalada", "red_publica"),
CONSTRAINT `fk_plantacion_riego` FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_uni_cantidad_riego` FOREIGN KEY(`cantidad_unidad_id`) REFERENCES `CuadernoDeCampoDB`.`unidad`(`unidad_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`maquinaria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`maquinaria`(
`maquinaria_id` INT auto_increment PRIMARY KEY,
`alias` VARCHAR(45) NULL,
`titular` VARCHAR(45) NULL,
`marca` VARCHAR(45) NULL,
`modelo` VARCHAR(45) NULL,
`num_roma` VARCHAR(45) NULL,
`num_reganip` VARCHAR(45) NULL,
`matricula` VARCHAR(10) NULL,
`estado` ENUM("operativa", "en_mantenimiento", "fuera_de_servicio") NULL,
`fecha_adquisicion` DATE NULL,
`ultima_inspeccion` DATE NULL,
`caducidad_itv` DATE NULL,
`observaciones` VARCHAR(200) NULL,
`tipo_maquina` ENUM('tractor','arado','subsolador','cultivador','grada','sembradora','plantadora','pulverizador','atomizador','cosechadora','vibrador','remolque','desbrozadora','trituradora','otros') NOT NULL,
`explotacion_id` INT NOT NULL,
CONSTRAINT `fk_explotacion_maquinaria` 
  FOREIGN KEY(`explotacion_id`) REFERENCES `CuadernoDeCampoDB`.`explotacion`(`explotacion_id`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cosecha`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`cosecha`(
`cosecha_id` INT auto_increment PRIMARY KEY,
`plantacion_id` INT NOT NULL,
`maquinaria_id` INT,
`personal_id` INT,
`cantidad_unidad_id` INT NOT NULL,
`tipo_cosecha` ENUM("manual", "mecanizada", "semimecanizada"),
`metodo_cosecha` ENUM("vareo", "vibrador", "cosechadora"), 
`producto` VARCHAR(30) NOT NULL,
`cantidad` DOUBLE NOT NULL,
`superficie` DOUBLE,
CONSTRAINT `fk_plantacion_cosecha` FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_maquinaria_cosecha` FOREIGN KEY(`maquinaria_id`) REFERENCES `CuadernoDeCampoDB`.`maquinaria`(`maquinaria_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_personal_cosecha` FOREIGN KEY(`personal_id`) REFERENCES `CuadernoDeCampoDB`.`personal`(`personal_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_uni_cantidad_cosecha` FOREIGN KEY(`cantidad_unidad_id`) REFERENCES `CuadernoDeCampoDB`.`unidad`(`unidad_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cliente`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`cliente`(
`cliente_id` INT auto_increment PRIMARY KEY,
`nif` VARCHAR(15) NOT NULL,
`nombre` VARCHAR(50),
`direccion` VARCHAR(100),
`num_rgseaa` VARCHAR(20)
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`comercial`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`comercial`(
`transaccion_id` INT auto_increment PRIMARY KEY,
`cosecha_id` INT NOT NULL,
`cantidad_unidad_id` INT NOT NULL,
`cliente_id` INT NOT NULL,
`cantidad` DOUBLE NOT NULL,
`num_albaran` VARCHAR(20),
CONSTRAINT `fk_cosecha_comercial` FOREIGN KEY(`cosecha_id`) REFERENCES `CuadernoDeCampoDB`.`cosecha`(`cosecha_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_cliente_comercial` FOREIGN KEY(`cliente_id`) REFERENCES `CuadernoDeCampoDB`.`cliente`(`cliente_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
CONSTRAINT `fk_uni_cantidad_comercial` FOREIGN KEY(`cantidad_unidad_id`) REFERENCES `CuadernoDeCampoDB`.`unidad`(`unidad_id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fitosanitario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`fitosanitario`(
`fitosanitario_id` INT auto_increment PRIMARY KEY,
`nombre` VARCHAR(20) NOT NULL,
`descripcion` VARCHAR(100),
`stock` INT
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`tratamientos`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`tratamientos`(
`tratamientos_id` INT auto_increment PRIMARY KEY,
`fecha` DATETIME,
`descripcion` VARCHAR(100),
`modo_aplicacion` VARCHAR(45),
`dosis` DOUBLE,
`caldo` DOUBLE,
`superficie_tratada` DOUBLE,
`fitosanitario_id` INT NOT NULL,
`plantacion_id` INT NOT NULL,
CONSTRAINT `fk_fitosanitarios_tratamientos` 
  FOREIGN KEY(`fitosanitario_id`) REFERENCES `CuadernoDeCampoDB`.`fitosanitario`(`fitosanitario_id`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE,
CONSTRAINT `fk_plantacion_tratamientos` 
  FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE
);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`analitica`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `CuadernoDeCampoDB`.`analitica`(
`analitica_id` INT auto_increment PRIMARY KEY,
`fecha` DATETIME,
`tipo_analisis` VARCHAR(20),
`material` VARCHAR(20),
`nombre_laboratiorio` VARCHAR(45),
`nif_laboratorio` VARCHAR(15),
`parametros_suelo` VARCHAR(200),
`n_boletin_analisis` VARCHAR(10),
`anotaciones` VARCHAR(200),
`plantacion_id` INT NOT NULL,
CONSTRAINT `fk_plantacion_analitica` 
  FOREIGN KEY(`plantacion_id`) REFERENCES `CuadernoDeCampoDB`.`plantacion`(`plantacion_id`) 
  ON DELETE CASCADE 
  ON UPDATE CASCADE
);
