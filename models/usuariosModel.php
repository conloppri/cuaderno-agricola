<?php
include "../config/db.php";

function obtenerUsuarioPorEmail(PDO $connection, $email) {
    try {
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        throw new Exception('Error al obtener el usuario: ' . $e->getMessage());
    }
}

function addUsuario(PDO $connection, $email, $password) {
    try {
        // Hashear la contraseña antes de guardarla
        $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

        // Insertar nuevo usuario en la base de datos
        $sql = "INSERT INTO usuarios (email, password_hash, fecha_creacion) VALUES (:email, :password_hash, :fecha_creacion)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'password_hash' => $hashedPassword,
            'fecha_creacion' => date('Y-m-d H:i:s')
        ]);
    } catch (PDOException $e) {
        throw new Exception('Error al guardar el usuario: ' . $e->getMessage());
    }
}
?>