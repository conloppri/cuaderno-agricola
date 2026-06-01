<?php
include '../config/db.php';

function obtenerRolesExplotacion(PDO $connection, $idExplotacion) {
    $stmt = $connection->prepare("SELECT u.email as email, u.id as usuario_id, ue.rol as rol FROM usuarios u JOIN usuarios_explotacion ue ON u.id = ue.usuario_id WHERE ue.explotacion_id = :explotacion_id");
    $stmt->execute(['explotacion_id' => $idExplotacion]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>