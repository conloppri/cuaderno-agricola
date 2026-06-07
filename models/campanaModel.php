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

function obtenerResumenTratamientos(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT DATE_FORMAT(t.fecha, '%d/%m/%Y') AS fecha, f.nombre AS fitosanitario, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM tratamientos t 
                JOIN plantacion pl ON pl.plantacion_id = t.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id 
                JOIN fitosanitario f ON f.fitosanitario_id = t.fitosanitario_id
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(t.fecha) = :ano 
                ORDER BY t.fecha 
                DESC LIMIT 1;";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerResumenFertilizaciones(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT DATE_FORMAT(f.fecha_fin, '%d/%m/%Y') AS fecha, fer.nombre AS fertilizante, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM fertilizacion f 
                JOIN fertilizante fer ON fer.fertilizante_id = f.fertilizacion_id 
                JOIN plantacion pl ON pl.plantacion_id = f.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(f.fecha_fin) = :ano 
                ORDER BY f.fecha_fin DESC LIMIT 1;";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerResumenRiegos(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT DATE_FORMAT(r.fecha_fin, '%d/%m/%Y') AS fecha, r.cantidad, u.unidad, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM riego r 
                JOIN plantacion pl ON pl.plantacion_id = r.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id 
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                JOIN unidad u ON r.cantidad_unidad_id = u.unidad_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(r.fecha_fin) = :ano 
                ORDER BY r.fecha_fin DESC LIMIT 1;";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
/*
function obtenerResumenLabores(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT l.nombre AS labor, DATE_FORMAT(pl.fecha_inicio, '%d/%m/%Y') AS fecha, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM labor l 
                JOIN plantacion pl ON pl.plantacion_id = l.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id 
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(pl.fecha_inicio) = :ano 
                ORDER BY pl.fecha_inicio DESC LIMIT 1;";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}*/

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

function obtenerCosechasPorCampana(int $explotacion_id, int $ano) {
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
        ORDER BY c.fecha_fin DESC;";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'fecha_inicio' => $fecha_inicio,
        'fecha_fin' => $fecha_fin
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerTratamientosPorCampana(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT DATE_FORMAT(t.fecha, '%d/%m/%Y') AS fecha, f.nombre AS fitosanitario, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM tratamientos t 
                JOIN plantacion pl ON pl.plantacion_id = t.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id 
                JOIN fitosanitario f ON f.fitosanitario_id = t.fitosanitario_id
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(t.fecha) = :ano 
                ORDER BY t.fecha DESC";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerFertilizacionesPorCampana(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT DATE_FORMAT(f.fecha_fin, '%d/%m/%Y') AS fecha, fer.nombre AS fertilizante, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM fertilizacion f 
                JOIN fertilizante fer ON fer.fertilizante_id = f.fertilizacion_id 
                JOIN plantacion pl ON pl.plantacion_id = f.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(f.fecha_fin) = :ano 
                ORDER BY f.fecha_fin DESC";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerRiegosPorCampana(int $explotacion_id, int $ano) {
    global $connection;
    $sql = "SELECT DATE_FORMAT(r.fecha_fin, '%d/%m/%Y') AS fecha, r.cantidad, u.unidad, p.nombre AS parcela, cu.nombre AS cultivo 
                FROM riego r 
                JOIN plantacion pl ON pl.plantacion_id = r.plantacion_id 
                JOIN parcela p ON p.parcela_id = pl.parcela_id 
                JOIN cultivo cu ON cu.cultivo_id = pl.cultivo_id
                JOIN unidad u ON r.cantidad_unidad_id = u.unidad_id
                WHERE p.explotacion_id = :explotacion_id 
                AND YEAR(r.fecha_fin) = :ano 
                ORDER BY r.fecha_fin DESC";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        'explotacion_id' => $explotacion_id,
        'ano' => $ano
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>