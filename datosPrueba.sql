-- Script de inserción de datos de prueba para la base de datos CuadernoDeCampoDB

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
INSERT INTO `CuadernoDeCampoDB`.`explotacion` (nombre, alias, codigo_siex, codigo_rea, comunidad, organizacion_id) VALUES
('Explotación La Verde', 'La Verde', 'ES001234567891', 'ES001234567891', 'Madrid', 1),
('Explotación El Trigal', 'El Trigal', 'ES009876543210', 'ES009876543210', 'Cataluña', 2),
('Explotación La Huerta', 'La Huerta', 'ES002345678912', 'ES002345678912', 'Andalucía', 3),
('Explotación El Bosque', 'El Bosque', 'ES008765432109', 'ES008765432109', 'Galicia', 4),
('Explotación La Frutera', 'La Frutera', 'ES003456789123', 'ES003456789123', 'Andalucía', 5),
('Explotación El Prado', 'El Prado', 'ES007654321098', 'ES007654321098', 'Asturias', 6);


-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`usuarios` (email, password_hash, fecha_creacion) VALUES
('user1@example.com', '$2b$12$...', '2023-01-01 00:00:00'),
('user2@example.com', '$2b$12$...', '2023-01-01 00:00:00'),
('user3@example.com', '$2b$12$...', '2023-01-01 00:00:00'),
('user4@example.com', '$2b$12$...', '2023-01-01 00:00:00');