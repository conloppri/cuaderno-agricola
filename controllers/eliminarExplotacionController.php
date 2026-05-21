<?php
include "../config/db.php";
include "../models/explotacionesModel.php";
include "comprobarUsuarioExp.php";

if (isset($_GET['explotacion_id'])) {
    $explotacion_id = $_GET['explotacion_id'];

    comprobarUsuarioExp($connection, $explotacion_id);
    eliminarExplotacion($connection, $explotacion_id);

} else {
    echo "ID de explotación no proporcionado.";
}
?>