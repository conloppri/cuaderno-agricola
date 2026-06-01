<?php
include '../controllers/comprobarSesion.php';
include '../models/globalModel.php';
include '../models/rolesUsuariosModel.php';

function getExplotacionById(PDO $connection, $idExplotacion) {
    return obtenerExplotacionPorId($connection, $idExplotacion);
}

function getRolesExplotacion(PDO $connection, $idExplotacion) {
    return obtenerRolesExplotacion($connection, $idExplotacion);
}
?>