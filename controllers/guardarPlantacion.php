<?php
session_start();
include_once "../config/db.php";
include '../models/plantacionesModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $parcela_id = $_POST['parcela'];
    $unidad_gestion_id = $_POST['unidadGestion'];
    $cultivo_id = $_POST['cultivo'];
    $densidad_unidad = $_POST['unidadDensidad'];
    $recinto = $_POST['recinto'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $sistema_cultivo = $_POST['sistema_cultivo'];
    $sistema_riego = $_POST['sistema_riego'];
    $finalidad = $_POST['finalidad'];
    $manejo = $_POST['manejo'];
    $valor_densidad = $_POST['valor_densidad'];
    $anotaciones = $_POST['anotaciones'];

    // Validar datos (puedes agregar validaciones más robustas)
    if (empty($fecha_inicio) || empty($parcela_id) || empty($cultivo_id) || empty($recinto)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit;
    }

    // Insertar nueva plantación en la base de datos
    try {
        addPlantacion($connection, $parcela_id, $unidad_gestion_id, $cultivo_id, $densidad_unidad, $recinto, $fecha_inicio, $sistema_cultivo, $sistema_riego, $finalidad, $manejo, $valor_densidad, $anotaciones);

        echo json_encode(['success' => true, 'message' => 'Plantación guardada exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la plantación: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>