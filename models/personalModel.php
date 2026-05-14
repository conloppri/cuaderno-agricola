<?php

include '../config/db.php';

function obtenerPersonal(PDO $connection, int $idExplotacion) {
    $sql = "SELECT * FROM personal WHERE explotacion_id = :idExplotacion";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['idExplotacion' => $idExplotacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>