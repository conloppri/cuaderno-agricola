<?php include '../models/catalogosModel.php';

function obtenerCatalogoCultivos() {
    $cultivos = obtenerCultivos();
    $resultado= [];
    foreach($cultivos as $cultivo) {
        $resultado[] = [
            'id' => $cultivo['cultivo_id'],
            'nombre' => $cultivo['nombre']. ' ' . ucfirst($cultivo['variedad']),
            'tipo' => $cultivo['tipo'],
            'ciclo' => $cultivo['ciclo'],
            'descripcion' => $cultivo['descripcion']
        ];
    }
    return $resultado;
}

function obtenerCatalogoEcorregimenes() {
    $ecorregimenes = obtenerEcorregimenes();
    $resultado= [];
    foreach($ecorregimenes as $ecorregimen) {
        $resultado[] = [
            'id' => $ecorregimen['ecorregimen_id'],
            'nombre' => $ecorregimen['nombre'],
            'descripcion' => $ecorregimen['descripcion']
        ];
    }
    return $resultado;
}

function obtenerCatalogoFertilizantes() {
    $fertilizantes = obtenerFertilizantes();
    $resultado= [];
    foreach($fertilizantes as $fertilizante) {
        $resultado[] = [
            'id' => $fertilizante['fertilizante_id'],
            'num_registro' => $fertilizante['num_registro'],
            'nombre' => $fertilizante['nombre'],
            'nitrogeno' => $fertilizante['nitrogeno'],
            'fosforo' => $fertilizante['fosforo'],
            'potasio' => $fertilizante['potasio'],
            'descripcion' => $fertilizante['descripcion']
        ];
    }
    return $resultado;
}

function obtenerCatalogoFitosanitarios() {
    $fitosanitarios = obtenerFitosanitarios();
    $resultado= [];
    foreach($fitosanitarios as $fitosanitario) {
        $resultado[] = [
            'id' => $fitosanitario['fitosanitario_id'],
            'num_registro' => $fitosanitario['num_registro'],
            'nombre' => $fitosanitario['nombre'],
            'descripcion' => $fitosanitario['descripcion']
        ];
    }
    return $resultado;
}

?>