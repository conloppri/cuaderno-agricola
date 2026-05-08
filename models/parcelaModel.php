<?php
include "../config/db.php"; ;

function obtenerParcelas(PDO $connection) {
    $sql = "SELECT * FROM parcela";
    $stmt = $connection->query($sql);
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}

function obtenerUnidadesGestion(PDO $connection, int $idParcela) {
    $sql = "SELECT * FROM unidad_gestion WHERE parcela_id = :idParcela";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idParcela' => $idParcela]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>