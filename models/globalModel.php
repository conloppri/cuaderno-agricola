<?php
include "../config/db.php";

// Función para obtener la información de provincia
function obtenerProvincia(PDO $connection, int $idProvincia) {

    $stmt = $connection->prepare("SELECT nombre FROM provincia WHERE provincia_id = :id");
    $stmt->execute(['id' => $idProvincia]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'] ?? 'Desconocida'; 
}

// Función para obtener la información de municipio
function obtenerMunicipio(PDO $connection, int $idMunicipio) {
    $stmt = $connection->prepare("SELECT nombre FROM municipio WHERE municipio_id = :id");
    $stmt->execute(['id' => $idMunicipio]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'] ?? 'Desconocido'; 
}

//Función para obtener lista de provincias
function obtenerProvincias(PDO $connection) {
    $stmt = $connection->prepare("SELECT provincia_id, nombre FROM provincia");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Función obtener lista de municipios por provincia
function obtenerMunicipiosPorProvincia(PDO $connection, int $provinciaId) {
    $municipiosLista = [];
    $stmt = $connection->prepare("SELECT municipio_id, nombre FROM municipio WHERE provincia_id = :id");
    $stmt->execute(['id' => $provinciaId]);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultado as $municipio) {
        $municipiosLista[] = [
            'id' => $municipio['municipio_id'],
            'nombre' => $municipio['nombre']
        ];
    }
    return $municipiosLista;
}
?>