<?php
include "../config/db.php";

function obtenerMaquinaria(PDO $connection, int $explotacion_id) {
    $sql = "SELECT maquinaria_id, alias, tipo_maquina, marca, modelo, matricula, estado FROM maquinaria WHERE explotacion_id = :explotacion_id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>