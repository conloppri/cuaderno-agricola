-- -----------------------------------------------------
-- Script de inserción de datos de prueba para la base de datos CuadernoDeCampoDB
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`organizacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`organizacion` (nif, nombre_razon_social, nombre_organizacion, direccion, municipio_id, cod_postal, provincia_id, comunidad, tlf_fijo, tlf_movil, email) VALUES
('A12345678', 'Agricultores Unidos S.A.', 'Agricultores Unidos', 'Calle Falsa 123', 1, '28080', 28, 'Madrid', '912345678', '612345678', 'agricultoresunidos@example.com'),
('B87654321', 'Cooperativa Agrícola La Esperanza', 'Cooperativa La Esperanza', 'Avenida Siempre Viva 456', 2, '08080', 8, 'Cataluña', '934567890', '623456789', 'cooperativalaesperanza@example.com'),
('C11223344', 'Granja El Sol', 'Granja El Sol', 'Carretera del Sol 789', 3, '41080', 41, 'Andalucía', '955678901', '634567890', 'granjaelsol@example.com'),
('D44332211', 'Hortícolas del Norte', 'Hortícolas del Norte', 'Camino del Norte 321', 4, '15080', 15, 'Galicia', '981234567', '645678901', 'horticolasdelnorte@example.com'),
('E55667788', 'Frutas y Verduras del Sur', 'Frutas y Verduras del Sur', 'Paseo del Sur 654', 5, '29080', 29, 'Andalucía', '952345678', '656789012', 'frutasyverdurasdel sur@example.com'),
('F99887766', 'Agropecuaria El Campo', 'Agropecuaria El Campo', 'Avenida del Campo 987', 6, '33080', 33, 'Asturias', '985678901', '667890123', 'agropecuariaelcampo@example.com');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`explotacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`explotacion` (nombre, alias, codigo_siex, codigo_rea, provincia_id, municipio_id, comunidad, organizacion_id) VALUES
('Explotación La Verde', 'La Verde', 'ES001234567891', 'ES001234567891', 28, 1, 'Madrid', 1),
('Explotación El Trigal', 'El Trigal', 'ES009876543210', 'ES009876543210', 8, 2, 'Cataluña', 2),
('Explotación La Huerta', 'La Huerta', 'ES002345678912', 'ES002345678912', 41, 3, 'Andalucía', 3),
('Explotación El Bosque', 'El Bosque', 'ES008765432109', 'ES008765432109', 15, 4, 'Galicia', 4),
('Explotación La Frutera', 'La Frutera', 'ES003456789123', 'ES003456789123', 29, 5, 'Andalucía', 5),
('Explotación El Prado', 'El Prado', 'ES007654321098', 'ES007654321098', 33, 6, 'Asturias', 6);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`usuarios` (email, password_hash, fecha_creacion) VALUES
('user1@example.com', '$2b$12$...', '2023-01-01 00:00:00'),
('user2@example.com', '$2b$12$...', '2023-01-01 00:00:00'),
('user3@example.com', '$2b$12$...', '2023-01-01 00:00:00'),
('user4@example.com', '$2b$12$...', '2023-01-01 00:00:00');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios_explotacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`usuarios_explotacion` (usuario_id, explotacion_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`municipio`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`municipio` (nombre, municipio_id, provincia_id) VALUES
('Madrid', 28, 28),
('Barcelona', 8, 8),
('Sevilla', 41, 41),
('A Coruña', 15, 15),
('Málaga', 29, 29),
('Oviedo', 33, 33);

-- Para poder usar bien los datos para la los datos de prueba:

-- Con XAMPP, desde phpMyAdmin puedes gestionar la base de datos y puedes importar el csv. Para importar el csv, sigue estos pasos:
-- 1. Abre phpMyAdmin y selecciona la base de datos `CuadernoDeCampoDB`.
-- 2. Busca la tabla de municipios y haz clic en la pestaña "Importar".
-- 3. Selecciona el archivo CSV que contiene los datos de los municipios.
-- 4. En importación parcial, omitir 1 fila (para omitir la fila de encabezado).
-- 5. Importas y te cargan todos los datos.

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`parcela`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`parcela` (explotacion_id, provincia_id, municipio_id, agregado, zona, poligono, parcela, nombre, superficie) VALUES
(1, 28, 1, 0, 0, 14, 2, 'Parcela 1', 10.5),
(2, 8, 2, 0, 0, 15, 3, 'Parcela 2', 20.0),
(3, 41, 3, 0, 0, 16, 4, 'Parcela 3', 15.0),
(4, 15, 4, 0, 0, 17, 5, 'Parcela 4', 25.0),
(5, 29, 5, 0, 0, 18, 6, 'Parcela 5', 12.0),
(6, 33, 6, 0, 0, 19, 7, 'Parcela 6', 18.0);