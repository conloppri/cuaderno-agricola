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

function obtenerParcelasExplotacion(int $explotacion_id) {
    global $connection;
    return obtenerParcelasPorExplotacion($connection, $explotacion_id);
}

function obtenerCatalogoCultivos() {
    global $connection;
    return obtenerCultivos($connection);
}

function obtenerUnidadesGestionExplotacion(int $explotacion_id) {
    global $connection;
    return obtenerUnidadesGestionPorExplotacion($connection, $explotacion_id);
}

function obtenerCatalogoUnidadDensidad() {
    global $connection;
    return obtenerUnidadDensidad($connection);
}
?>