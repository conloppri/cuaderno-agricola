-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`unidad`
-- -----------------------------------------------------

INSERT INTO `CuadernoDeCampoDB`.`unidad` (unidad, tipo) VALUES
('kg', 'masa'),('g', 'masa'),('t', 'masa'),
('l', 'volumen'),('ml', 'volumen'),('m3', 'volumen'),('cm3', 'volumen'),
('plantas/ha', 'densidad'),('plantas/m2', 'densidad'),('arboles/ha', 'densidad'),('arboles/m2', 'densidad'),
('%', 'concentracion'),('g/l', 'concentracion'),('kg/l', 'concentracion'),('mg/l', 'concentracion'),('g/kg', 'concentracion'),('mg/kg', 'concentracion'),
('unidades', 'cantidad'), ('cajas', 'cantidad'), ('pacas', 'cantidad'), ('palet', 'cantidad'),
('kg/ha','por_superficie'), ('t/ha', 'por_superficie'), ('kg/m2', 'por_superficie'), ('t/m2', 'por_superficie');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`provincia`
-- -----------------------------------------------------

INSERT INTO `CuadernoDeCampoDB`.`provincia` (provincia_id, nombre) VALUES
(01, 'Araba/Álava'), (02, 'Albacete'),(03, 'Alicante'),(04, 'Almería'),(05, 'Ávila'),(06, 'Badajoz'),(07, 'Islas Baleares'),(08, 'Barcelona'),(09, 'Burgos'),
(10, 'Cáceres'),(11, 'Cádiz'),(12, 'Castellón'),(13, 'Ciudad Real'),(14, 'Córdoba'),(15, 'A Coruña'),(16, 'Cuenca'),(17, 'Girona'),(18, 'Granada'),(19, 'Guadalajara'),
(20, 'Gipuzkoa'),(21, 'Huelva'),(22, 'Huesca'),(23, 'Jaén'),(24, 'León'),(25, 'Lleida'),(26, 'La Rioja'),(27, 'Lugo'),(28, 'Madrid'),(29, 'Málaga'),
(30, 'Murcia'),(31, 'Navarra'),(32, 'Ourense'),(33, 'Asturias'),(34, 'Palencia'),(35, 'Las Palmas'),(36, 'Pontevedra'),(37, 'Salamanca'),(38, 'Santa Cruz de Tenerife'),(39, 'Cantabria'),
(40, 'Segovia'),(41, 'Sevilla'),(42, 'Soria'),(43, 'Tarragona'),(44, 'Teruel'),(45, 'Toledo'),(46, 'Valencia'),(47, 'Valladolid'),(48, 'Bizkaia'),(49, 'Zamora'),
(50, 'Zaragoza'),(51, 'Ceuta'),(52, 'Melilla');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cultivo`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`cultivo` (nombre, variedad, tipo, ciclo) VALUES
-- leñosos
('olivo', 'arbequina', 'leñoso', 'perenne'),
('olivo', 'picual', 'leñoso', 'perenne'),
('olivo', 'hojiblanca', 'leñoso', 'perenne'),
('vid', 'tempranillo', 'leñoso', 'perenne'),
('vid', 'garnacha', 'leñoso', 'perenne'),
('vid', 'verdejo', 'leñoso', 'perenne'),
('almendro', 'guara', 'leñoso', 'perenne'),
('almendro', 'marcona', 'leñoso', 'perenne'),
('naranjo', 'navelina', 'leñoso', 'perenne'),
('naranjo', 'valencia late', 'leñoso', 'perenne'),
('limonero', 'fino', 'leñoso', 'perenne'),
('limonero', 'verna', 'leñoso', 'perenne'),
-- herbaceos
('trigo', NULL, 'herbaceo', 'anual'),
('cebada', NULL, 'herbaceo', 'anual'),
('maiz', NULL, 'herbaceo', 'anual'),
('avena', NULL, 'herbaceo', 'anual'),
('centeno', NULL, 'herbaceo', 'anual'),
-- horticolas
('tomate', 'pera', 'horticola', 'anual'),
('tomate', 'cherry', 'horticola', 'anual'),
('tomate', 'raf', 'horticola', 'anual'),
('tomate', 'roma', 'horticola', 'anual'),
('tomate', 'kumato', 'horticola', 'anual'),
('tomate', 'corazon de buey', 'horticola', 'anual'),
('tomate', 'rosa', 'horticola', 'anual'),
('pimiento', 'italiano', 'horticola', 'anual'),
('pimiento', 'lamuyo', 'horticola', 'anual'),
('lechuga', 'romana', 'horticola', 'anual'),
('lechuga', 'iceberg', 'horticola', 'anual'),
('lechuga', 'cogollo', 'horticola', 'anual'),
('cebolla', NULL, 'horticola', 'anual'),
('patata', 'agria', 'horticola', 'anual'),
('patata', 'monalisa', 'horticola', 'anual'),
('patata', 'kennebec', 'horticola', 'anual'),
-- industriales
('girasol', NULL, 'herbaceo', 'anual'),
('colza', NULL, 'herbaceo', 'anual'),
('remolacha azucarera', NULL, 'herbaceo', 'anual'),
('algodon', NULL, 'herbaceo', 'anual'),
-- forrajeros
('alfalfa', NULL, 'forrajero', 'perenne'),
('veza', NULL, 'forrajero', 'anual'),
('maiz forrajero', NULL, 'forrajero', 'anual');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`ecorregimen`
-- -----------------------------------------------------

INSERT INTO `CuadernoDeCampoDB`.`ecorregimen` (ecorregimen_id, nombre, descripcion, activo) VALUES
('ER1', 'Rotación de cultivos con especies mejorantes', 'Alternancia de cultivos incluyendo leguminosas o mejorantes para mejorar el suelo.', true),
('ER2', 'Siembra directa', 'Laboreo mínimo o nulo, manteniendo residuos vegetales en superficie', true),
('ER3', 'Cubiertas vegetales en tierras de cultivo', 'Mantenimiento de vegetación viva o sembrada entre campañas o cultivos', true),
('ER4','Cubiertas vegetales en cultivos leñosos','Vegetación espontánea o sembrada entre líneas de cultivo leñoso.',true),
('ER5','Cubiertas inertes en cultivos leñosos','Uso de restos vegetales o meteriales inertes para proteger el suelo.',true),
('ER6','Pastoreo extensivo','Aprovechamiento del pasto mediante ganadería extensiva.',true),
('ER7','Siega sostenible','Corte de pastos respetando ciclos de regeneración.',true),
('ER8','Mantenimiento de pastos con biodiversidad','Conservación de pastos con alto valor ecológico.',true),
('ER9','Superficies no productivas y elementos de biodiversidad en tierras de cultivo','Áreas destinadas a favorecer fauna y flora sin producción agrícola.',true),
('ER10','Islas de biodiversidad en cultivos permanentes','Pequeñas zonas no cultivadas dentro de explotaciones permanentes.',true);