<?php
include_once "../models/globalModel.php";
include "../config/db.php";

function obtenerNombreExplotacion(int $explotacion_id){
    global $connection;
    $explotacion = obtenerExplotacionPorId($connection, $explotacion_id);
    return $explotacion["nombre"];
}
?>