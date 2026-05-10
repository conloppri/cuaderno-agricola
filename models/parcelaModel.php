<?php
include "../config/db.php"; ;

// Funciones para obtener la información de las parcelas y unidades de gestión

// Función para obtener la información de las parcelas de una explotación específica
function obtenerParcelas(PDO $connection, int $idExplotacion) {
    $sql = "SELECT * FROM parcela WHERE explotacion_id = :idExplotacion";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idExplotacion' => $idExplotacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener la información de las unidades de gestión de una parcela específica
function obtenerUnidadesGestion(PDO $connection, int $idParcela) {
    $sql = "SELECT * FROM unidad_gestion WHERE parcela_id = :idParcela";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idParcela' => $idParcela]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>