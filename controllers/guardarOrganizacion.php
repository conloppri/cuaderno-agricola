<?php
session_start();
include '../models/organizacionesModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre_organizacion = $_POST['nombre_organizacion'] ?? '';
    $nombre_razon_social = $_POST['nombre_razon_social'] ?? '';
    $nif = $_POST['nif'] ?? null;
    $provincia_id = $_POST['provincia'] ?? null;
    $municipio_id = $_POST['municipio'] ?? null;
    $comunidad = $_POST['comunidad'] ?? '';
    $tlf_movil = $_POST['tlf_movil'] ?? '';
    $tlf_fijo = $_POST['tlf_fijo'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $email = $_POST['correo_electronico'] ?? '';
    $cod_postal = $_POST['codigo_postal'] ?? '';

    // Validar datos
    if (empty($nombre_organizacion) || empty($nif) || empty($provincia_id) || empty($municipio_id) || empty($comunidad)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos obligatorios.']);
        exit;
    }

    // Insertar nueva organización en la base de datos
    try {
        $organizacion_id = addOrganizacion($connection, $nombre_organizacion, $nombre_razon_social, $nif, $provincia_id, $municipio_id, $comunidad, $tlf_fijo, $tlf_movil, $direccion, $email, $cod_postal);

        // Asociar la organización con el usuario actual.
        addUsuarioOrganizacion($connection, $_SESSION['usuario_id'], $organizacion_id);

        echo json_encode(['success' => true, 'message' => 'Organización guardada exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al guardar la organización: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>