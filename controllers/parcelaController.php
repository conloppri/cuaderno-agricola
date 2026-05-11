<?php 
include "../models/parcelaModel.php";
include "../models/globalModel.php";
include "../config/db.php";

function obtenerInfoParcelas(PDO $connection, int $idExplotacion) {
    $parcelasDetails = [];
    $infoParcelas = obtenerParcelas($connection, $idExplotacion);
    foreach ($infoParcelas as &$parcela) {
        $provincia = obtenerProvincia($connection, $parcela['provincia_id']);
        $municipio = obtenerMunicipio($connection, $parcela['municipio_id']);
        $sigpac = str_pad($parcela['provincia_id'], 2, "0", STR_PAD_LEFT) . ':' . str_pad($parcela['municipio_id'], 3, "0", STR_PAD_LEFT) . ':' . $parcela['agregado'] . ':' . $parcela['zona'] . ':' . str_pad($parcela['poligono'], 5, "0", STR_PAD_LEFT) . ":" . str_pad($parcela['parcela'], 5, "0", STR_PAD_LEFT);
        array_push($parcelasDetails,[
            'id' => $parcela['parcela_id'],
            'nombre' => $parcela['nombre'],
            'sigpac' => $sigpac,
            'superficie' => $parcela['superficie'] . ' ha',
            'provincia' => $provincia,
            'municipio' => $municipio
        ]);
    }
    return $parcelasDetails;
}

function obtenerInfoUnidadesGestion(PDO $connection, int $idParcela) {
    $unidadesGestion = obtenerUnidadesGestion($connection, $idParcela);
    $resultado = [];
    foreach ($unidadesGestion as &$unidad) {
        array_push($resultado, [
            'nombre' => $unidad['nombre'],
            'superficie' => $unidad['superficie'] . ' ha',
            'uso' => $unidad['uso']
        ]);
    }
    return $resultado;
}
