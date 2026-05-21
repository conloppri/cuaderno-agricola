<?php
session_start();
include "../config/db.php";

function comprobarUsuarioOrg(PDO $connection, int $organizacion_id) {
    $stmt = $connection->prepare("SELECT * FROM usuarios_organizacion WHERE usuario_id = :usuario_id AND organizacion_id = :organizacion_id");
    $stmt->execute(['usuario_id' => $_SESSION['usuario_id'], 'organizacion_id' => $organizacion_id]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        header("Location: ../views/sinPermiso.php");
        exit("No tienes permiso para acceder a esta organización.");
    }
}
?>