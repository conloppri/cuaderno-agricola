<?php
session_start();

include '../models/rolesUsuariosModel.php';

if(obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $_GET['explotacion_id']) !== 'administrador') {
    echo json_encode(['success' => false, 'redirect' => '../views/sinPermiso.php', 'message' => 'No tienes permisos para modificar el rol de este usuario']);
    exit();
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $explotacion_id = $_GET['explotacion_id'] ?? null;
    $usuario_id = $_POST['usuarioIdRol'] ?? null;
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