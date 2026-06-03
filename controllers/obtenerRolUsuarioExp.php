<?php
include '../models/rolesUsuariosModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $usuario_id = $_GET['usuario_id'] ?? null;
    $explotacion_id = $_GET['explotacion_id'] ?? null;

    if (!$usuario_id || !$explotacion_id) {
        echo json_encode(['success' => false, 'message' => 'Parámetros faltantes']);
        exit;
    }

    try {
        $rol = obtenerRolUsuarioEnExplotacion($connection, $usuario_id, $explotacion_id);
        echo json_encode(['success' => true, 'rol' => $rol]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener el rol: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>