<?php include "../config/db.php"; 

include_once "../models/parcelaModel.php";

function obtenerAnosCampanas(int $explotacion_id) {
    global $connection;
    $sql = "SELECT DISTINCT YEAR(fecha_inicio) AS ano FROM plantacion p INNER JOIN parcela pa ON p.parcela_id = pa.parcela_id WHERE pa.explotacion_id = :explotacion_id ORDER BY ano DESC";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id
    ]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function obtenerResumenPlantaciones(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT COUNT(*) as numPlantaciones, MAX(fecha_inicio) as fechaReciente FROM plantacion p INNER JOIN parcela pa ON p.parcela_id = pa.parcela_id WHERE pa.explotacion_id = :explotacion_id AND YEAR(p.fecha_inicio) = :ano";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerResumenCosechas(int $explotacion_id, int $ano) {
    global $connection;
    $fecha_inicio = "$ano-01-01";
    $fecha_fin = ($ano + 1) . "-01-01";
    $sql = "SELECT c.fecha_fin, cu.nombre AS cultivo, c.cantidad, u.unidad FROM Cosecha c JOIN Plantacion p ON c.plantacion_id = p.plantacion_id
        JOIN Parcela pa ON p.parcela_id = pa.parcela_id
        JOIN Cultivo cu ON p.cultivo_id = cu.cultivo_id
        JOIN Unidad u ON c.cantidad_unidad_id = u.unidad_id
        WHERE pa.explotacion_id = :explotacion_id
        AND c.fecha_fin >= :fecha_inicio 
        AND c.fecha_fin < :fecha_fin
        ORDER BY c.fecha_fin DESC
        LIMIT 1;";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'fecha_inicio' => $fecha_inicio,
        'fecha_fin' => $fecha_fin
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerPlantacionesPorCampana(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT p.*, cu.nombre AS cultivo FROM plantacion p INNER JOIN parcela pa ON p.parcela_id = pa.parcela_id JOIN Cultivo cu ON p.cultivo_id = cu.cultivo_id WHERE pa.explotacion_id = :explotacion_id AND YEAR(p.fecha_inicio) = :ano";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>