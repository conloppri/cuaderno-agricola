<?php
include '../models/usuariosModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validar que el correo electrónico no esté vacío
    if (empty($email)) {
        echo json_encode(['success' => false, 'message' => 'El correo electrónico es obligatorio.']);
        exit;
    }

    // Validar que la contraseña no esté vacía
    if (empty($password)) {
        echo json_encode(['success' => false, 'message' => 'La contraseña es obligatoria.']);
        exit;
    }

    // Verificar si el usuario ya existe
    if (obtenerUsuarioPorEmail($connection, $email)) {
        echo json_encode(['success' => false, 'message' => 'El correo electrónico ya está registrado.']);
        exit;
    }

    // Registrar el nuevo usuario
    try {
        addUsuario($connection, $email, $password);
        echo json_encode(['success' => true, 'message' => 'Registro exitoso. Puedes iniciar sesión ahora.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Error al registrar: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud no válido.']);
}
?>