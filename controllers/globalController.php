<?php
include_once "../models/globalModel.php";
include "../config/db.php";

function obtenerNombreExplotacion(int $explotacion_id){
    global $connection;
    $explotacion = obtenerExplotacionPorId($connection, $explotacion_id);
    return $explotacion["nombre"];
}

function obtenerRolUsuario(int $usuarioId, int $explotacionId) {
    global $connection;
    return obtenerRolPorUsuario($connection, $usuarioId, $explotacionId);
}

function obtenerPlantacionesExplotacion(int $explotacion_id) {
    global $connection;
    return obtenerPlantacionesPorExplotacion($connection, $explotacion_id);
}
?>