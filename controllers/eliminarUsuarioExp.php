<?php
session_start();

include '../controllers/comprobarUsuarioExp.php';
include '../models/rolesUsuariosModel.php';

if(obtenerRolUsuarioEnExplotacion($connection, $_SESSION['usuario_id'], $_GET['explotacion_id']) !== 'administrador') {
    echo json_encode(['success' => false, 'redirect' => '../views/sinPermiso.php', 'message' => 'No tienes permisos para modificar el rol de este usuario']);
    exit();
}

header('Content-Type: application/json');

if(isset($_GET['explotacion_id']) && isset($_GET['usuario_id'])) {
    $explotacion_id = $_GET['explotacion_id'];
    $usuario_id = $_GET['usuario_id'];

    comprobarUsuarioExp($connection, $explotacion_id);
    
    if(contarAdminExplotacion($connection, $explotacion_id) <= 1 && obtenerRolUsuarioEnExplotacion($connection, $usuario_id, $explotacion_id) === 'administrador') {
        echo json_encode(['success' => false, 'message' => 'Debe haber al menos un administrador en la explotación. No se puede eliminar este usuario.']);
        exit;
    }

    delUsuarioExplotacion($connection, $usuario_id, $explotacion_id);

    echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'ID de explotación o usuario no proporcionado']);
}
?>