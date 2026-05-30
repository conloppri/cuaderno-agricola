<?php
include '../config/db.php';

function obtenerInstalaciones(int $explotacion_id) {
    global $connection;
    $sql = "SELECT instalacion_id, nombre, tipo, superficie, estado FROM instalacion WHERE explotacion_id = :explotacion_id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['explotacion_id' => $explotacion_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>