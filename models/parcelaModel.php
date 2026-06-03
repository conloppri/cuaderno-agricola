<?php
include "../config/db.php"; ;

// Funciones para obtener la información de las parcelas y unidades de gestión

// Función para obtener la información de las parcelas de una explotación específica
function obtenerParcelas(int $idExplotacion) {
    global $connection;
    $sql = "SELECT * FROM parcela WHERE explotacion_id = :idExplotacion";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idExplotacion' => $idExplotacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener la información de las unidades de gestión de una parcela específica
function obtenerUnidadesGestion(int $idParcela) {
    global $connection;
    $sql = "SELECT * FROM unidad_gestion WHERE parcela_id = :idParcela";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idParcela' => $idParcela]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function guardarParcela(int $idExplotacion, string $nombreParcela, float $superficieParcela, array $subdivisionesSigpac) {
    global $connection;
    $sql = "INSERT INTO parcela (explotacion_id, nombre, superficie, provincia_id, municipio_id, agregado, zona, poligono, parcela) VALUES (:idExplotacion, :nombreParcela, :superficieParcela, :provinciaId, :municipioId, :agregado, :zona, :poligono, :parcela)";
    $stmt = $connection->prepare($sql);
    return $stmt->execute([
        'idExplotacion' => $idExplotacion,
        'nombreParcela' => $nombreParcela,
        'superficieParcela' => $superficieParcela,
        'provinciaId' => $subdivisionesSigpac['provincia_id'],
        'municipioId' => $subdivisionesSigpac['municipio_id'],
        'agregado' => $subdivisionesSigpac['agregado'],
        'zona' => $subdivisionesSigpac['zona'],
        'poligono' => $subdivisionesSigpac['poligono'],
        'parcela' => $subdivisionesSigpac['parcela']
    ]);
}

function guardarUnidadGestion(int $idParcela, string $nombreUniGestion, float $superficieUniGestion, string $uso) {
    global $connection;
    $sql = "INSERT INTO unidad_gestion (parcela_id, nombre, superficie, uso) VALUES (:idParcela, :nombreUniGestion, :superficieUniGestion, :uso)";
    $stmt = $connection->prepare($sql);
    return $stmt->execute([
        'idParcela' => $idParcela,
        'nombreUniGestion' => $nombreUniGestion,
        'superficieUniGestion' => $superficieUniGestion,
        'uso' => $uso
    ]);
}
?>