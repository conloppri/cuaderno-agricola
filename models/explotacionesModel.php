<?php
include "../config/db.php";

function obtenerExplotaciones(PDO $connection, $username) {
    $sql = "select e.* from explotacion e JOIN usuarios_explotacion ue ON e.explotacion_id = ue.explotacion_id JOIN usuarios u ON ue.usuario_id = u.id WHERE u.email = :email";
    $stmt = $connection->prepare($sql);
    //$stmt->bind_param("s", $username);
    //$stmt->execute();
    $stmt->execute(['email' => $username]);
    //$resultado = $stmt->get_result();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resultado;
}
?>