<?php
session_start();
include '../models/organizacionesModel.php';
include 'comprobarUsuarioOrg.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organizacion_id = $_GET['organizacion_id'] ?? null;
    $nombre_organizacion = $_POST['nombre_organizacion'] ?? '';
    $nombre_razon_social = $_POST['nombre_razon_social'] ?? '';
    $nif = $_POST['nif'] ?? null;
    $provincia_id = $_POST['provincia'] ?? null;
    $municipio_id = $_POST['municipio'] ?? null;
    $comunidad = $_POST['comunidad'] ?? '';
    $tlf_movil = $_POST['tlf_movil'] ?? '';
    $tlf_fijo = $_POST['tlf_fijo'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $email = $_POST['correo_electronico'] ?? '';
    $cod_postal = $_POST['codigo_postal'] ?? '';

    comprobarUsuarioOrg($connection, $organizacion_id);

    try {
        modificarOrganizacion($connection, $organizacion_id, $nombre_organizacion, $nombre_razon_social, $nif, $provincia_id, $municipio_id, $comunidad, $tlf_fijo, $tlf_movil, $direccion, $email, $cod_postal);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>