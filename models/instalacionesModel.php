<?php
include '../config/db.php';

function obtenerInstalaciones(int $explotacion_id) {
    global $connection;
    $sql = "SELECT instalacion_id, nombre, tipo, superficie, estado FROM instalacion WHERE explotacion_id = :explotacion_id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function guardarInstalacion(int $explotacion_id, string $nombre, float $superficie, string $tipo, string $estado) {
    global $connection;
    $sql = "INSERT INTO instalacion (explotacion_id, nombre, tipo, superficie, estado) VALUES (:explotacion_id, :nombre, :tipo, :superficie, :estado)";
    $stmt = $connection->prepare($sql);
    return $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'nombre' => $nombre,
        'tipo' => $tipo,
        'superficie' => $superficie,
        'estado' => $estado
    ]);
}
?>