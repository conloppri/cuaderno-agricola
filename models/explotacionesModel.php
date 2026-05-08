<?php
session_start();
include "../config/db.php"; ;

$username = $_SESSION['username'];

function obtenerExplotaciones($connection) {
    $sql = "select e.* from explotacion e JOIN usuarios_explotacion ue ON e.explotacion_id = ue.explotacion_id JOIN usuarios u ON ue.usuario_id = u.id WHERE u.email = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado;
}
?>