<?php

include '../config/db.php';

function obtenerPersonal(PDO $connection, int $idExplotacion) {
    $sql = "SELECT * FROM personal WHERE explotacion_id = :idExplotacion";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idExplotacion' => $idExplotacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function guardarPersonal(PDO $connection, int $idExplotacion, string $nombre, string $dni, string $apellidos, string $telefono, string $email, string $direccion, int $provinciaId, int $municipioId, string $nacionalidad, string $rol) {
    $sql = "INSERT INTO personal (explotacion_id, nombre, dni, apellidos, telefono, email, direccion, provincia_id, municipio_id, nacionalidad, rol) VALUES (:idExplotacion, :nombre, :dni, :apellidos, :telefono, :email, :direccion, :provinciaId, :municipioId, :nacionalidad, :rol)";
    $stmt = $connection->prepare($sql);
    return $stmt->execute([
        'idExplotacion' => $idExplotacion,
        'nombre' => $nombre,
        'dni' => $dni,
        'apellidos' => $apellidos,
        'telefono' => $telefono,
        'email' => $email,
        'direccion' => $direccion,
        'provinciaId' => $provinciaId,
        'municipioId' => $municipioId,
        'nacionalidad' => $nacionalidad,
        'rol' => $rol
    ]);
}

?>