<?php
include "../config/db.php";

function obtenerMaquinaria(PDO $connection, int $explotacion_id) {
    $sql = "SELECT maquinaria_id, alias, tipo_maquina, marca, modelo, matricula, estado FROM maquinaria WHERE explotacion_id = :explotacion_id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerMaquinaPorId(int $id) {
    global $connection;
    $sql = "SELECT alias, tipo_maquina, marca, modelo, matricula, estado FROM maquinaria WHERE maquinaria_id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function guardarMaquinaria(int $explotacion_id, string $alias, string $tipo, string $marca, string $modelo, string $matricula, string $estado, ?string $titular, ?string $num_roma, ?string $num_reganip, ?string $fecha_adquisicion, ?string $ultima_inspeccion, ?string $caducidad_itv, ?string $observaciones) {
    global $connection;
    $sql = "INSERT INTO maquinaria (explotacion_id, alias, tipo_maquina, marca, modelo, matricula, estado, titular, num_roma, num_reganip, fecha_adquisicion, ultima_inspeccion, caducidad_itv, observaciones) VALUES (:explotacion_id, :alias, :tipo_maquina, :marca, :modelo, :matricula, :estado, :titular, :num_roma, :num_reganip, :fecha_adquisicion, :ultima_inspeccion, :caducidad_itv, :observaciones)";
    $stmt = $connection->prepare($sql);
    return $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'alias' => $alias,
        'tipo_maquina' => $tipo,
        'marca' => $marca,
        'modelo' => $modelo,
        'matricula' => $matricula,
        'estado' => $estado,
        'titular' => $titular,
        'num_roma' => $num_roma,
        'num_reganip' => $num_reganip,
        'fecha_adquisicion' => $fecha_adquisicion,
        'ultima_inspeccion' => $ultima_inspeccion,
        'caducidad_itv' => $caducidad_itv,
        'observaciones' => $observaciones
    ]);
}


?>