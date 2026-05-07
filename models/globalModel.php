<?php
include "../config/db.php";

function obtenerProvincia(PDO $connection, int $idProvincia) {

    $stmt = $connection->prepare("SELECT nombre FROM provincia WHERE provincia_id = :id");
    $stmt->execute(['id' => $idProvincia]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'] ?? 'Desconocida'; 
}

function obtenerMunicipio(PDO $connection, int $idMunicipio) {
    $stmt = $connection->prepare("SELECT nombre FROM municipio WHERE municipio_id = :id");
    $stmt->execute(['id' => $idMunicipio]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['nombre'] ?? 'Desconocido'; 
}

?>