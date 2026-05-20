<?php
session_start();
include "../config/db.php";

function comprobarUsuarioExp(PDO $connection, int $explotacion_id) {
    $stmt = $connection->prepare("SELECT * FROM usuarios_explotacion WHERE usuario_id = :usuario_id AND explotacion_id = :explotacion_id");
    $stmt->execute(['usuario_id' => $_SESSION['usuario_id'], 'explotacion_id' => $explotacion_id]);
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$resultado) {
        header("Location: ../views/sinPermiso.php");
        exit("No tienes permiso para acceder a esta explotación.");
    }
}
?>