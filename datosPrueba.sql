-- -----------------------------------------------------
-- Script de inserción de datos de prueba para la base de datos CuadernoDeCampoDB
-- -----------------------------------------------------

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
-- Tabla `CuadernoDeCampoDB`.`organizacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`organizacion` (nif, nombre_razon_social, nombre_organizacion, direccion, municipio_id, cod_postal, provincia_id, comunidad, tlf_fijo, tlf_movil, email) VALUES
('A12345678', 'Agricultores Unidos S.A.', 'Agricultores Unidos', 'Calle Falsa 123', 28, '28080', 28, 'Madrid', '912345678', '612345678', 'agricultoresunidos@example.com'),
('B87654321', 'Cooperativa Agrícola La Esperanza', 'Cooperativa La Esperanza', 'Avenida Siempre Viva 456', 8, '08080', 8, 'Cataluña', '934567890', '623456789', 'cooperativalaesperanza@example.com'),
('C11223344', 'Granja El Sol', 'Granja El Sol', 'Carretera del Sol 789', 41, '41080', 41, 'Andalucía', '955678901', '634567890', 'granjaelsol@example.com'),
('D44332211', 'Hortícolas del Norte', 'Hortícolas del Norte', 'Camino del Norte 321', 15, '15080', 15, 'Galicia', '981234567', '645678901', 'horticolasdelnorte@example.com'),
('E55667788', 'Frutas y Verduras del Sur', 'Frutas y Verduras del Sur', 'Paseo del Sur 654', 29, '29080', 29, 'Andalucía', '952345678', '656789012', 'frutasyverdurasdel sur@example.com'),
('F99887766', 'Agropecuaria El Campo', 'Agropecuaria El Campo', 'Avenida del Campo 987', 33, '33080', 33, 'Asturias', '985678901', '667890123', 'agropecuariaelcampo@example.com');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`explotacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`explotacion` (nombre, alias, codigo_siex, codigo_rea, provincia_id, municipio_id, comunidad, organizacion_id) VALUES
('Explotación La Verde', 'La Verde', 'ES001234567891', 'ES001234567891', 28, 28, 'Madrid', 1),
('Explotación El Trigal', 'El Trigal', 'ES009876543210', 'ES009876543210', 8, 8, 'Cataluña', 2),
('Explotación La Huerta', 'La Huerta', 'ES002345678912', 'ES002345678912', 41, 41, 'Andalucía', 3),
('Explotación El Bosque', 'El Bosque', 'ES008765432109', 'ES008765432109', 15, 15, 'Galicia', 4),
('Explotación La Frutera', 'La Frutera', 'ES003456789123', 'ES003456789123', 29, 29, 'Andalucía', 5),
('Explotación El Prado', 'El Prado', 'ES007654321098', 'ES007654321098', 33, 33, 'Asturias', 6);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`usuarios` (email, password_hash, fecha_creacion) VALUES
('user1@example.com', '$argon2id$v=19$m=16,t=2,p=1$NUhsS0NUM0VnQVFPWm1zeA$75RMOYkuAzGYF1hMtjen/g', '2023-01-01 00:00:00'),
('user2@example.com', '$argon2id$v=19$m=16,t=2,p=1$NUhsS0NUM0VnQVFPWm1zeA$75RMOYkuAzGYF1hMtjen/g', '2023-01-01 00:00:00'),
('user3@example.com', '$argon2id$v=19$m=16,t=2,p=1$NUhsS0NUM0VnQVFPWm1zeA$75RMOYkuAzGYF1hMtjen/g', '2023-01-01 00:00:00'),
('user4@example.com', '$argon2id$v=19$m=16,t=2,p=1$NUhsS0NUM0VnQVFPWm1zeA$75RMOYkuAzGYF1hMtjen/g', '2023-01-01 00:00:00');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`usuarios_explotacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`usuarios_explotacion` (usuario_id, explotacion_id) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`parcela`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`parcela` (explotacion_id, provincia_id, municipio_id, agregado, zona, poligono, parcela, nombre, superficie) VALUES
(1, 28, 28, 0, 0, 14, 2, 'Parcela 1', 10.5),
(2, 8, 8, 0, 0, 15, 3, 'Parcela 2', 20.0),
(3, 41, 41, 0, 0, 16, 4, 'Parcela 3', 15.0),
(4, 15, 15, 0, 0, 17, 5, 'Parcela 4', 25.0),
(5, 29, 29, 0, 0, 18, 6, 'Parcela 5', 12.0),
(6, 33, 33, 0, 0, 19, 7, 'Parcela 6', 18.0);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`unidad_gestion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`unidad_gestion` (parcela_id, nombre, superficie, uso) VALUES
(1, 'Unidad de Gestión 1', 10.5, 'agricola'),
(2, 'Unidad de Gestión 2', 20.0, 'en descanso'),
(3, 'Unidad de Gestión 3', 15.0, 'agricola'),
(4, 'Unidad de Gestión 4', 25.0, 'agricola'),
(5, 'Unidad de Gestión 5', 12.0, 'en descanso'),
(6, 'Unidad de Gestión 6', 18.0, 'en descanso');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cultivo`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`cultivo` (nombre, variedad, descripcion, tipo, ciclo) VALUES
('Cultivo 1', 'Variedad 1', 'Descripción 1', 'leñoso', 'anual'),
('Cultivo 2', 'Variedad 2', 'Descripción 2', 'herbaceo', 'anual'),
('Cultivo 3', 'Variedad 3', 'Descripción 3', 'horticola', 'bianual'),
('Cultivo 4', 'Variedad 4', 'Descripción 4', 'leñoso', 'bianual'),
('Cultivo 5', 'Variedad 5', 'Descripción 5', 'herbaceo', 'perenne'),
('Cultivo 6', 'Variedad 6', 'Descripción 6', 'forrajero', 'perenne');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`plantacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`plantacion` (parcela_id, unidad_gestion_id, cultivo_id, densidad_unidad, recinto, fecha_inicio, fecha_fin, sistema_cultivo, sistema_riego, finalidad, manejo, valor_densidad, anotaciones) VALUES
(1, 1, 1, 22, 1, '2026-01-01', NULL, 'intensivo', 'goteo', 'produccion_agricola', 'convencional', 1.5, 'Anotaciones 1'),
(2, 2, 2, 22, 2, '2026-02-01', NULL, 'extensivo', 'aspersion', 'autoconsumo', 'produccion_integrada', 2.0, 'Anotaciones 2'),
(3, 3, 3, 22, 3, '2026-03-01', NULL, 'tradicional', 'gravedad', 'ganadera', 'ecologico', 2.5, 'Anotaciones 3'),
(4, 4, 4, 22, 4, '2026-04-01', NULL, 'superintensivo', 'goteo', 'conservacion', 'regenerativo', 3.0, 'Anotaciones 4'),
(5, 5, 5, 22, 5, '2026-05-01', NULL, 'intensivo', 'aspersion', 'energetica', 'convencional', 3.5, 'Anotaciones 5'),
(6, 6, 6, 22, 6, '2026-06-01', NULL, 'extensivo', 'gravedad', 'produccion_agricola', 'produccion_integrada', 4.0, 'Anotaciones 6');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`ecorregimen_plantacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`ecorregimen_plantacion` (ecorregimen_id, plantacion_id) VALUES
('ER1', 1),
('ER2', 2),
('ER3', 3),
('ER4', 4),
('ER5', 5),
('ER6', 6);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fenologia`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`fenologia` (plantacion_id, fecha_deteccion, estado, anotaciones) VALUES
(1, '2026-01-15', 'Emergencia', 'Anotaciones 1'),
(2, '2026-02-15', 'Crecimiento vegetativo', 'Anotaciones 2'),
(3, '2026-03-15', 'Floración', 'Anotaciones 3'),
(4, '2026-04-15', 'Fructificación', 'Anotaciones 4'),
(5, '2026-05-15', 'Maduración', 'Anotaciones 5'),
(6, '2026-06-15', 'Cosecha', 'Anotaciones 6');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`personal`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`personal` (dni, nombre, apellidos, telefono, email, direccion, nacionalidad, rol, municipio_id, provincia_id) VALUES
('12345678A', 'Juan', 'Pérez', '123456789', 'juan.perez@example.com', 'Dirección 1', 'Nacionalidad 1', 'propietario', 28, 28),
('87654321B', 'María', 'García', '987654321', 'maria.garcia@example.com', 'Dirección 2', 'Nacionalidad 2', 'tecnico', 8, 8),
('11223344C', 'Carlos', 'López', '555555555', 'carlos.lopez@example.com', 'Dirección 3', 'Nacionalidad 3', 'trabajador', 41, 41),
('44332211D', 'Ana', 'Martínez', '666666666', 'ana.martinez@example.com', 'Dirección 4', 'Nacionalidad 4', 'administrativo', 15, 15),
('55667788E', 'Luis', 'Gómez', '777777777', 'luis.gomez@example.com', 'Dirección 5', 'Nacionalidad 5', 'propietario', 29, 29),
('99887766F', 'Sofía', 'Díaz', '888888888', 'sofia.diaz@example.com', 'Dirección 6', 'Nacionalidad 6', 'tecnico', 33, 33);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fertilizante`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`fertilizante` (num_registro, nombre, tipo, descripcion, nitrogeno, fosforo, potasio) VALUES
('F001', 'Fertilizante A', 'propio', 'Descripción del fertilizante A', 10.0, 5.0, 15.0),
('F002', 'Fertilizante B', 'comercial', 'Descripción del fertilizante B', 12.0, 6.0, 18.0),
('F003', 'Fertilizante C', 'propio', 'Descripción del fertilizante C', 8.0, 4.0, 12.0),
('F004', 'Fertilizante D', 'comercial', 'Descripción del fertilizante D', 15.0, 7.0, 20.0),
('F005', 'Fertilizante E', 'propio', 'Descripción del fertilizante E', 9.0, 4.5, 13.5),
('F006', 'Fertilizante F', 'comercial', 'Descripción del fertilizante F', 11.0, 5.5, 16.5);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fertilizacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`fertilizacion` (plantacion_id, fertilizante_id, dosis_unidad_id, caldo_unidad_id, fecha_inicio, fecha_fin, superficie, tipo_aplicacion, dosis_cantidad, caldo_cantidad, anotaciones) VALUES
(1, 1, 1, 1, '2026-01-20', '2026-01-20', 100.0, 'fondo', 10.0, NULL, 'Anotaciones 1'),
(2, 2, 2, 2, '2026-02-20', '2026-02-20', 150.0, 'cobertura', 12.0, NULL, 'Anotaciones 2'),
(3, 3, 3, 3, '2026-03-20', '2026-03-20', 200.0, 'fertirrigacion', 8.0, NULL, 'Anotaciones 3'),
(4, 4, 4, 4, '2026-04-20', '2026-04-20', 250.0, 'foliar', 15.0, NULL, 'Anotaciones 4'),
(5, 5, 5, 5, '2026-05-20', '2026-05-20', 300.0, 'localizada', 9.0, NULL, 'Anotaciones 5'),
(6, 6, 6, 6, '2026-06-20', '2026-06-20', 350.0, 'fondo', 11.0, NULL, 'Anotaciones 6');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`riego`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`riego` (plantacion_id, cantidad_unidad_id, fecha_inicio, fecha_fin, superficie, cantidad, tipo_riego, tipo_energia, origen_agua) VALUES
(1, 1, '2026-01-25', '2026-01-25', 500.0, 1, 'goteo', 'electrica', 'subterranea'),
(2, 2, '2026-02-25', '2026-02-25', 750.0, 2, 'aspersion', 'combustible', 'superficial'),
(3, 3, '2026-03-25', '2026-03-25', 1000.0, 3, 'manual', 'solar', 'embalse'),
(4, 4, '2026-04-25', '2026-04-25', 1250.0, 4, 'goteo', 'electrica', 'rio'),
(5, 5, '2026-05-25', '2026-05-25', 1500.0, 5, 'aspersion', 'combustible', 'canal'),
(6, 6, '2026-06-25', '2026-06-25', 1750.0, 6, 'manual', 'solar', 'red_publica');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`maquinaria`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`maquinaria` (alias, titular, marca, modelo, num_roma, num_reganip, matricula, estado, fecha_adquisicion, ultima_inspeccion, caducidad_itv, observaciones, tipo_maquina, explotacion_id) VALUES
('Tractor A', '', 'Marca A', 'Modelo A', '', '', 'E 2020MAT', 'Activa', '2026-01-01', '2026-01-01', '2027-01-01', 'Observaciones 1', 'Tractor', 1),
('Cosechadora B', '', 'Marca B', 'Modelo B', '', '', 'E 2020MMB', 'Activa', '2026-02-01', '2026-02-01', '2027-02-01', 'Observaciones 2', 'Cosechadora', 2),
('Sembradora C', '', 'Marca C', 'Modelo C', '', '', 'E 2020TMC', 'Activa', '2026-03-01', '2026-03-01', '2027-03-01', 'Observaciones 3', 'Sembradora', 3),
('Pulverizadora D', '', 'Marca D', 'Modelo D', '', '', 'E 2020VMD', 'Activa', '2026-04-01', '2026-04-01', '2027-04-01', 'Observaciones 4', 'Pulverizadora', 4),
('Fertilizadora F', '', 'Marca F', 'Modelo F', '', '', 'E 2020RMF', 'Activa', '2026-06-01', '2026-06-01', '2027-06-01', 'Observaciones 6', 'Desbrozadora', 6),
('Desbrozadora E', '', 'Marca E', 'Modelo E', '', '', 'E 2020RME', 'Activa', '2026-05-01', '2026-05-01', '2027-05-01', 'Observaciones 5', 'Arado', 5);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cosecha`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`cosecha` (plantacion_id, maquinaria_id, personal_id, cantidad_unidad_id, tipo_cosecha, metodo_cosecha, producto, cantidad, superficie, fecha_inicio, fecha_fin) VALUES
(1, 1, 1, 1, 'manual', 'vareo', 'venta', 10.0, 100.0, '2026-09-01', '2026-09-30'),
(2, 2, 2, 2, 'mecanizada', 'cosechadora', 'autoconsumo', 20.0, 200.0, '2026-10-01', '2026-10-31'),
(3, 3, 3, 3, 'semimecanizada', 'vibrador', 'donacion', 15.0, 150.0, '2026-11-01', '2026-11-30'),
(4, 4, 4, 4, 'manual', 'vareo', 'venta', 25.0, 250.0, '2026-12-01', '2026-12-31'),
(5, 5, 5, 5, 'mecanizada', 'cosechadora', 'autoconsumo', 12.0, 120.0, '2027-01-01', '2027-01-31'),
(6, 6, 6, 6, 'semimecanizada', 'vibrador', 'donacion', 18.0, 180.0, '2027-02-01', '2027-02-28');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`cliente`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`cliente` (nif, nombre, direccion, num_rgseaa) VALUES
('G12345678', 'Cliente A', 'Dirección Cliente A', 'RGSEAA001'),
('H87654321', 'Cliente B', 'Dirección Cliente B', 'RGSEAA002'),
('I11223344', 'Cliente C', 'Dirección Cliente C', 'RGSEAA003'),
('J44332211', 'Cliente D', 'Dirección Cliente D', 'RGSEAA004'),
('K55667788', 'Cliente E', 'Dirección Cliente E', 'RGSEAA005'),
('L99887766', 'Cliente F', 'Dirección Cliente F', 'RGSEAA006');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`comercial`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`comercial` (cosecha_id, cantidad_unidad_id, cliente_id, cantidad, num_albaran) VALUES
(1, 1, 1, 10.0, 'ALB001'),
(2, 2, 2, 20.0, 'ALB002'),
(3, 3, 3, 15.0, 'ALB003'),
(4, 4, 4, 25.0, 'ALB004'),
(5, 5, 5, 12.0, 'ALB005'),
(6, 6, 6, 18.0, 'ALB006');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`fitosanitario`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`fitosanitario` (num_registro, nombre, descripcion, stock) VALUES
('FS001', 'Fitosanitario A', 'Descripción del fitosanitario A', 100),
('FS002', 'Fitosanitario B', 'Descripción del fitosanitario B', 200),
('FS003', 'Fitosanitario C', 'Descripción del fitosanitario C', 150),
('FS004', 'Fitosanitario D', 'Descripción del fitosanitario D', 250),
('FS005', 'Fitosanitario E', 'Descripción del fitosanitario E', 120),
('FS006', 'Fitosanitario F', 'Descripción del fitosanitario F', 180);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`tratamientos`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`tratamientos` (plantacion_id, fitosanitario_id, dosis_unidad_id, fecha, descripcion, modo_aplicacion, dosis, caldo, superficie_tratada) VALUES
(1, 1, 5, '2026-07-01', 'Tratamiento 1', 'foliar', 10.0, 100.0, 50.0),
(2, 2, 5, '2026-08-01', 'Tratamiento 2', 'localizada', 20.0, 200.0, 100.0),
(3, 3, 5, '2026-09-01', 'Tratamiento 3', 'fondo', 15.0, 150.0, 75.0),
(4, 4, 5, '2026-10-01', 'Tratamiento 4', 'foliar', 25.0, 250.0, 125.0),
(5, 5, 5, '2026-11-01', 'Tratamiento 5', 'localizada', 12.0, 120.0, 60.0),
(6, 6, 5, '2026-12-01', 'Tratamiento 6', 'fondo', 18.0, 180.0, 90.0);

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`analitica`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`analitica` (plantacion_id, fecha, tipo_analisis, material, nombre_laboratiorio, nif_laboratorio, parametros_suelo, n_boletin_analisis, anotaciones) VALUES
(1, '2026-07-15', 'suelo', 'muestra de suelo', 'Laboratorio A', 'LAB001', 'pH: 6.5, N: 10.0, P: 5.0, K: 15.0', 'BA001', 'Anotaciones 1'),
(2, '2026-08-15', 'agua', 'muestra de agua', 'Laboratorio B', 'LAB002', 'pH: 7.0, N: 8.0, P: 4.0, K: 12.0', 'BA002', 'Anotaciones 2'),
(3, '2026-09-15', 'planta', 'muestra de planta', 'Laboratorio C', 'LAB003', 'pH: 6.8, N: 9.0, P: 4.5, K: 13.5', 'BA003', 'Anotaciones 3'),
(4, '2026-10-15', 'suelo', 'muestra de suelo', 'Laboratorio D', 'LAB004', 'pH: 6.2, N: 11.0, P: 5.5, K: 16.0', 'BA004', 'Anotaciones 4'),
(5, '2026-11-15', 'agua', 'muestra de agua', 'Laboratorio E', 'LAB005', 'pH: 7.2, N: 7.0, P: 3.5, K: 10.0', 'BA005', 'Anotaciones 5'),
(6, '2026-12-15', 'planta', 'muestra de planta', 'Laboratorio F', 'LAB006', 'pH: 6.9, N: 10.5, P: 5.2, K: 14.0', 'BA006', 'Anotaciones 6');

-- -----------------------------------------------------
-- Tabla `CuadernoDeCampoDB`.`instalacion`
-- -----------------------------------------------------
INSERT INTO `CuadernoDeCampoDB`.`instalacion` (nombre, tipo, superficie, estado, explotacion_id) VALUES
('Instalación de Riego 1', 'Nave', 500.0, 'Disponible', 1),
('Instalación de Riego 2', 'Nave', 750.0, 'Disponible', 2),
('Instalación de Riego 3', 'Almacen', 1000.0, 'Disponible', 3),
('Instalación de Riego 4', 'Almacen', 1250.0, 'Disponible', 4),
('Instalación de Riego 5', 'Silo', 1500.0, 'Disponible', 5),
('Instalación de Riego 6', 'Balsa', 1750.0, 'Disponible', 6);