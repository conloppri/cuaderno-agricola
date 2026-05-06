<?php
include "../config/db.php"; ;

function obtenerParcelas($connection) {
    $sql = "SELECT * FROM parcela";
    $resultado = $connection->query($sql);
    return $resultado;
}
?>