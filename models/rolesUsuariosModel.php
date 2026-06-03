<?php
include '../config/db.php';

function obtenerRolesExplotacion(PDO $connection, $idExplotacion) {
    $stmt = $connection->prepare("SELECT u.email as email, u.id as usuario_id, ue.rol as rol FROM usuarios u JOIN usuarios_explotacion ue ON u.id = ue.usuario_id WHERE ue.explotacion_id = :explotacion_id");
    $stmt->execute(['explotacion_id' => $idExplotacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addUsuarioExplotacion(PDO $connection, $email, $explotacion_id, $rol) {
    // Verificar si el usuario existe
    $stmt = $connection->prepare("SELECT id FROM usuarios WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        throw new PDOException("No se encontró ningún usuario con el email '$email'.");
    }

    $usuario_id = $usuario['id'];

    // Verificar si el usuario ya tiene un rol en esta explotación
    $stmt = $connection->prepare("SELECT * FROM usuarios_explotacion WHERE usuario_id = :usuario_id AND explotacion_id = :explotacion_id");
    $stmt->execute(['usuario_id' => $usuario_id, 'explotacion_id' => $explotacion_id]);
    if ($stmt->fetch()) {
        throw new PDOException("El usuario con email '$email' ya tiene un rol asignado en esta explotación.");
    }

    // Insertar el nuevo rol para el usuario en la explotación
    $stmt = $connection->prepare("INSERT INTO usuarios_explotacion (usuario_id, explotacion_id, rol) VALUES (:usuario_id, :explotacion_id, :rol)");
    $stmt->execute(['usuario_id' => $usuario_id, 'explotacion_id' => $explotacion_id, 'rol' => $rol]);
}

function comprobarUsuarioEnExplotacion(PDO $connection, $usuario_id, $explotacion_id) {
    $stmt = $connection->prepare("SELECT * FROM usuarios_explotacion WHERE usuario_id = :usuario_id AND explotacion_id = :explotacion_id");
    $stmt->execute(['usuario_id' => $usuario_id, 'explotacion_id' => $explotacion_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
}

function delUsuarioExplotacion(PDO $connection, $usuario_id, $explotacion_id) {
    $stmt = $connection->prepare("DELETE FROM usuarios_explotacion WHERE usuario_id = :usuario_id AND explotacion_id = :explotacion_id");
    $stmt->execute(['usuario_id' => $usuario_id, 'explotacion_id' => $explotacion_id]);
}

function obtenerRolUsuarioEnExplotacion(PDO $connection, $usuario_id, $explotacion_id) {
    $stmt = $connection->prepare("SELECT rol FROM usuarios_explotacion WHERE usuario_id = :usuario_id AND explotacion_id = :explotacion_id");
    $stmt->execute(['usuario_id' => $usuario_id, 'explotacion_id' => $explotacion_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['rol'] : null;
}

function modificarRolUsuarioEnExplotacion(PDO $connection, $usuario_id, $explotacion_id, $nuevo_rol) {
    $stmt = $connection->prepare("UPDATE usuarios_explotacion SET rol = :nuevo_rol WHERE usuario_id = :usuario_id AND explotacion_id = :explotacion_id");
    $stmt->execute(['nuevo_rol' => $nuevo_rol, 'usuario_id' => $usuario_id, 'explotacion_id' => $explotacion_id]);
}
?>