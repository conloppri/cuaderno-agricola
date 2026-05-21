<?php
session_start();
include '../models/explotacionesModel.php';
include 'comprobarUsuarioExp.php';
include 'comprobarUsuarioOrg.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $explotacion_id = $_GET['explotacion_id'];
    $nombre = $_POST['nombre'];
    $alias = $_POST['alias'];
    $organizacion_id = $_POST['organizacion'];
    $provincia_id = $_POST['provincia'];
    $municipio_id = $_POST['municipio'];
    $comunidad = $_POST['comunidad'];
    $codigo_rea = $_POST['codigo_rea'];
    $codigo_siex = $_POST['codigo_siex'];

    comprobarUsuarioExp($connection, $explotacion_id);
    comprobarUsuarioOrg($connection, $organizacion_id);

    try {
        modificarExplotacion($connection, $explotacion_id, $nombre, $alias, $organizacion_id, $provincia_id, $municipio_id, $comunidad, $codigo_rea, $codigo_siex);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>