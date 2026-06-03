<?php
include '../controllers/comprobarUsuarioExp.php';
include '../models/rolesUsuariosModel.php';

if(isset($_GET['explotacion_id']) && isset($_GET['usuario_id'])) {
    $explotacion_id = $_GET['explotacion_id'];
    $usuario_id = $_GET['usuario_id'];

    comprobarUsuarioExp($connection, $explotacion_id);
    
    delUsuarioExplotacion($connection, $usuario_id, $explotacion_id);

    echo json_encode(['success' => true, 'message' => 'Usuario eliminado exitosamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'ID de explotación o usuario no proporcionado']);
}
?>