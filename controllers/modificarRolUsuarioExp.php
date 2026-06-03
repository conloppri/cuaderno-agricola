<?php
include '../models/rolesUsuariosModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario_id = $_POST['usuario_id'] ?? null;
    $explotacion_id = $_POST['explotacion_id'] ?? null;
    $nuevoRol = $_POST['nuevoRol'] ?? null;

    if (!$usuario_id || !$explotacion_id || !$nuevoRol) {
        echo json_encode(['success' => false, 'message' => 'Parámetros faltantes']);
        exit;
    }

    try {
        modificarRolUsuarioEnExplotacion($connection, $usuario_id, $explotacion_id, $nuevoRol);
        echo json_encode(['success' => true, 'message' => 'Rol modificado correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al modificar el rol: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>