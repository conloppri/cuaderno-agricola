<?php
session_start();
include '../models/explotacionesModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'] ?? '';
    $alias = $_POST['alias'] ?? '';
    $organizacion_id = $_POST['organizacion'] ?? null;
    $provincia_id = $_POST['provincia'] ?? null;
    $municipio_id = $_POST['municipio'] ?? null;
    $comunidad = $_POST['comunidad'] ?? '';
    $codigo_rea = $_POST['codigo_rea'] ?? '';
    $codigo_siex = $_POST['codigo_siex'] ?? '';

    // Validar datos (puedes agregar validaciones más robustas)
    if (empty($nombre) || empty($organizacion_id) || empty($provincia_id) || empty($municipio_id) || empty($comunidad)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit;
    }

    // Insertar nueva explotación en la base de datos
    try {
        $explotacion_id = addExplotacion($connection, $nombre, $alias, $organizacion_id, $provincia_id, $municipio_id, $comunidad, $codigo_rea, $codigo_siex);

        // Asociar la explotación con el usuario actual
        addUsuarioExplotacion($connection, $_SESSION['usuario_id'], $explotacion_id, 'administrador'); // Asignar rol de administrador al usuario que creó la explotación

        echo json_encode(['success' => true, 'message' => 'Explotación guardada exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la explotación: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>