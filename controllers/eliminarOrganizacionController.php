<?php
include "../config/db.php";
include "../models/organizacionesModel.php";
include "comprobarUsuarioOrg.php";

if (isset($_GET['organizacion_id'])) {
    $organizacion_id = $_GET['organizacion_id'];

    comprobarUsuarioOrg($connection, $organizacion_id);
    eliminarOrganizacion($connection, $organizacion_id);

} else {
    echo "ID de organización no proporcionado.";
}
?>