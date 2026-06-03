<?php
session_start();
include '../models/rolesUsuariosModel.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $explotacion_id = $_GET['explotacion_id'] ?? null;
    $email = $_POST['email'] ?? '';
    $rol = $_POST['rol'] ?? '';

    if (empty($email) || empty($rol)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, completa todos los campos.']);
        exit;
    }

    try {
        addUsuarioExplotacion($connection, $email, $explotacion_id, $rol);
        echo json_encode(['success' => true, 'message' => 'Usuario agregado exitosamente']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al agregar el usuario: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido']);
}
?>